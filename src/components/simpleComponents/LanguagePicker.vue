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
      }),
    },
    methods: {
      changeLanguage(lang) {
        this.$i18n.locale = lang;
        this.$vuetify.lang.current = lang;
        this.$store.dispatch("language/setLanguage", lang);
      },
    }
  }
</script>

<style scoped>
</style>