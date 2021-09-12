<template>
   <span>
<!--      <span>{{ cellValue }}</span>-->
<!--      <button @click="buttonClicked()">save Uhuuuuuuuu </button>-->
     <mybtn
       @click="buttonClicked('save')"
       text="save "
       color="green accent-3"
     ></mybtn>

    </span>

</template>

<script>
  export default {
    name: "totalValueRenderer",
    data() {
      return {
        cellValue: null,
      }
    },
    beforeMount() {
      // this.params contains the cell & row information and is made available to this component at creation time
      // see ICellRendererParams below for more details
      this.cellValue = this.getValueToDisplay(this.params);
    },
    methods: {
      // gets called whenever the user gets the cell to refresh
      refresh(params) {
        // set value into cell again
        this.cellValue = this.getValueToDisplay(params);
      },

      buttonClicked(val) {
        console.log(`${this.cellValue} `);
        console.log(val);
      },

      getValueToDisplay(params) {
        return params.valueFormatted ? params.valueFormatted : params.value;
      },
    },
  }
</script>

<style scoped>

</style>