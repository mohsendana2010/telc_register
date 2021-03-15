<template>
  <mydatatable
    :name="myName"
    :savedata="saveData"
  >
  </mydatatable>
</template>

<script>
  // import examDateSave from '../examDate/ExamDateSave'
  export default {
    name: "Session",
    components: {
      // examDateSave,
    },
    data: () => ({
      myName: "Session",
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