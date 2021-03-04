<template>
  <v-container>
    <v-select
      v-model="selected"
      :items="languages"
      item-text="title"
      item-value="value"
      :label="$t('language_picker_helper')"
      outlined
      @change="changeLanguage(selected)"
    ></v-select>
  </v-container>
</template>

<script>
  import { mapGetters } from  'vuex';
  export default {
    name: "LanguagePicker",
    data() {
      return {
        selected:"",
      };
    },
    computed: {
      ...mapGetters({
        languages: 'language/getLanguages',
        formActive: "language/getFormActive",

      }),
    },
    methods: {
      changeLanguage(lang) {
        this.$i18n.locale = lang;
        this.$vuetify.lang.current = lang;
        this.$store.dispatch("language/setLanguage", lang);
      },
    },
    watch:{
      formActive() {
        if (!this.formActive) {
          this.$nextTick(() => {
            this.$store.dispatch("language/setFormActive", true);
          });
        }
      },
    }
  }
</script>

<style scoped>
</style>


<!-- add in app.vue -->
<!--import LanguagePicker from "./res/language/component/LanguagePicker";-->

<!--<LanguagePicker class="mr-1" style="maxWidth: 150px;"/>-->

<!--components: {-->
<!--LanguagePicker-->