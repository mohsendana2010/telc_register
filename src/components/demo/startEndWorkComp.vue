// needs to be more user friendly
<template>
<div>
  <div>
    <v-btn
      elevation="2"
      :disabled="btnDisable.start"
      @click="onChangeBtnStatus('started', $event)"
    >Start</v-btn>
    <v-btn
      elevation="2"
      :disabled="btnDisable.pause"
      @click="onChangeBtnStatus('paused')"
    >Pause</v-btn>
    <v-btn
      elevation="2"
      :disabled="btnDisable.continue"
      @click="onChangeBtnStatus('continued')"
    >Continue</v-btn>
    <v-btn
      elevation="2"
      :disabled="btnDisable.end"
      @click="onChangeBtnStatus('ended')"
    >End</v-btn>
  </div>
</div>
</template>

<script>
  export default {
  name: "DemoPage",
  data() {
    return {
      btnDisable: {
        start: false,
        pause: true,
        continue: true,
        end: true,
      },
    }
  },
  mounted() {
    this.UpdateBtnStatus();
  },
  methods: {
    UpdateBtnStatus: function() {
      this.btnDisable = this.$store.getters["startEndWork/getStatus"];
    },
    onChangeBtnStatus: function(status, event) {
      return console.log(event.target.innerHTML);
      this.$store.dispatch('startEndWork/setStatus', status)
      .then(() => {
        this.UpdateBtnStatus();
      })
    },
  },
}
</script>

<style scoped>

</style>
