<template>
  <div class="text-center ma-2">

    <v-snackbar
      v-model="snackbar"
      :timeout="timeout"
      rounded="pill"
      outlined
      :color="color"
      text
      top
    >
      <v-row align="center" justify="space-between">
      {{ text }}
        <mybtn
          @click="setShowAlert(false)"
          iconname="mdi-close"
          :color="color"
          small
          fab
        ></mybtn>
      </v-row>

    </v-snackbar>
  </div>
</template>

<script>
  import {mapGetters} from 'vuex';
  export default {
    name: "MyAlert",
    data() {
      return {
        snackbar: false,
      }
    },

    props: {
      bind: {},
      on: {},
    },
    computed: {
      ...mapGetters({
        alertShow: "MyAlert/getAlertShow",
        text: "MyAlert/getText",
        color: "MyAlert/getColor",
        timeout: "MyAlert/getTimeout",
      }),
    },
    methods: {
      setShowAlert(show) {
        this.$store.dispatch('MyAlert/setShowAlert', show);
      },

      openAlert(show) {
        this.snackbar = show;
      },
    },
    watch: {
      alertShow() {
        this.openAlert(this.alertShow);
      },
    },
  }
</script>

<style scoped>

</style>