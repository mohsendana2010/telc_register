<template>
  <v-row class="my-0 py-0">
    <v-col cols="12" xs="12" sm="6"   class="my-1 py-0">
      <mybtn
        @click="clear"
        :text="cleartext"
        :tooltiptext="cleartooltiptext"
        color="deep-orange accent-3"
      ></mybtn>
    </v-col>
    <v-col  cols="auto" xs="12" sm="6"  align="end"  class="my-1 py-0">
      <mybtn
        :disabled="disabled"
        @click="submit"
        :text="savetext"
        :tooltiptext="savetooltiptext"
        color="green lighten-1"
      ></mybtn>
    </v-col>
  </v-row>
</template>

<script>
  export default {
    name: "MySaveGrupButtons",
    data() {
      return {

      }
    },
    props: {
      disabled:{
        type: Boolean,
        default: true,
      },
      savetext:{
        type: String,
        default() {
          return this.$t('save');
        },
      },
      savetooltiptext:{
        type: String,
        default() {
          return this.$t('save');
        },
      },
      cleartext:{
        type: String,
        default() {
          return this.$t('reset');
        },
      },
      cleartooltiptext:{
        type: String,
        default() {
          return this.$t('reset');
        },
      },

    },
    methods: {
      submit() {
        this.$emit("submit");
      },
      clear() {
        this.$emit("clear");
      },
    },

  }
</script>

<style scoped>

</style>