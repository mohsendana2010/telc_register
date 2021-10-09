<template>

<div>
  <div class="d-flex justify-center">
    <h1>
      Demo Page
    </h1>
  </div>
  <hr />
  <StartEndWork />
  <hr />
</div>

</template>

<script>
 import StartEndWork from "./startEndWorkComp.vue"

export default {
  name: "demoPage",
  components: {
    StartEndWork
  }, 
}
</script>

<style scoped>

</style>