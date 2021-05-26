<template>
  <v-container>
    <v-row  align="start" >
      <v-col cols="12" xs="12"  sm="6" class="my-0 py-0">
        <v-row align="center" class="my-1">

        <v-img
          contain
          max-height="70"
          max-width="280"
          :src="captchaImage"
        ></v-img>
        <mybtn
          @click="refreshCode"
          iconname="mdi-refresh"
          small
          fab
        ></mybtn>
        </v-row>
      </v-col>
      <v-col cols="12" xs="12"   sm="6"  align="center" class="my-0 py-0">
        <v-row align="end" class="my-1">
        <v-text-field
          v-model="captchaCode"
          :rules="rules"
          :label="$t('captcha.captchaText')"
          required
          clearable
          outlined
        ></v-text-field>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import {mapGetters} from 'vuex';

  export default {
    name: "Captcha",
    data() {
      return {
        captchaCode: "",

      }
    },
    computed: {
      ...mapGetters({
        captchaImage: "captcha/getCaptchaImage",
        captchaEncrypt: "captcha/getCaptchaEncrypt",
        formActive: "language/getFormActive",
      }),

        // captchaCodeRuls() {
        //   return this.formActive
        //   ? [v => !!v.trim() || this.$t('captcha.captchaText')] : []
        // },

    },
    props:{
      refresh:{
        type: Boolean,
        default: true,
      },
      rules: {
        type: Array,
        default() {
          return this.formActive
            ? [v => !!v.trim() || this.$t('captcha.captchaText')] : [];
        }
      },
    },
    created() {
      this.initialize()
    },
    methods: {
      initialize() {
        this.refreshCode();
      },
      refreshCode() {
        this.captchaCode = "";
        this.$store.dispatch('captcha/getCaptcha');
      },
      test() {
        let item = {
          captchaCode: this.captchaCode,
          captchaEncrypt: this.captchaEncrypt,
        };
        this.$store.dispatch('captcha/verifyCaptcha', item)
          .then(res => {
            console.log('capcha verify:', res);
          });
      },

    },
    watch:{
      refresh() {
        this.refreshCode();
      },
      captchaCode() {
        this.$store.dispatch('captcha/setCaptchaCode', this.captchaCode)
      },
    },
  }
</script>

<style scoped>

</style>