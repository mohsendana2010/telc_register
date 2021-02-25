<template>
  <mydatatable
    :name="myName"
    :savedata="saveData"
  >
    <examTypeSave @change="save"></examTypeSave>
  </mydatatable>
</template>

<script>
  import examTypeSave from '../examType/ExamTypeSave'

  export default {
    name: "ExamType",
    components: {
      examTypeSave,
    },
    data: () => ({
      myName: "ExamType",
      saveData: false,
    }),

    computed: {},

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

    watch: {},

  }
</script>

<style scoped>

</style>