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

    created() {
      this.initialize()
    },

    methods: {
      initialize() {
      },
      save() {
        this.saveData = !this.saveData;
      },
    },
  }
</script>

<style scoped>

</style>