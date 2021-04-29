<template>
  <mydatatable
    :name="myName"
    :savedata="saveData"
    newpage="/"
    updatepage="telcmembersave"
  >
  </mydatatable>
</template>

<script>
  export default {
    name: "TelcMember",

    data: () => ({
      myName: "TelcMember",
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
  }
</script>

<style scoped>

</style>