<template>
  <mydatatable
    :name="myName"
    :savedata="saveData"
  >
    <examDateSave  @change="save"></examDateSave>
  </mydatatable>
</template>

<script>
  import examDateSave from '../examDate/ExamDateSave'

  export default {
    name: "ExamDate",
    components: {
      examDateSave,
    },
    data() {
      return {
        myName: "ExamDate",
        saveData: false,

      }
    },

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