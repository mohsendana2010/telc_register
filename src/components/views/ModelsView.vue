<template>
  <mydatatable
    :name="myName"
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
      myName: "TriggerExamType",
      saveData: false,
    }),

    computed: {
      // myName: window.location.hash,
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