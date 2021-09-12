<template>
  <mydatatable
    :key="$route.params.id"
    :name="$route.params.id"
    :savedata="saveData"
  >
    <!--    <savedialog  @change="save"></savedialog>-->
  </mydatatable>
</template>

<script>
  // import savedialog from '../users/usersSave'
  export default {
    name: "ModelsView",
    components: {
      // savedialog,
    },
    data: () => ({
      // myName: "TriggerExamType",
      // myName: this.$route.params.id,
      saveData: false,
    }),

    computed: {
      // myName() {
      //   return this.$route.params.id;
      // },
    },

    created() {
      this.initialize()
    },

    methods: {
      initialize() {
        // console.log(' modelsView : ', window.location.hash);
      },
      save() {
        this.saveData = !this.saveData;
      },
    },

  }
</script>

<style scoped>

</style>