<template>
  <v-container>
    <v-dialog
      v-model="dialog"
      max-width="500px"
      :persistent="persistent"
    >
      <v-card>
        <v-card-title class="headline">{{text}}</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>

          <v-row class="my-0 py-0" justify="start" >
            <v-col cols="2"   class="my-0 py-0">
              <mybtn
                @click="btnOk"
                :text="btnoktext"
                :tooltiptext="btnoktext"
              ></mybtn>
            </v-col>
            <v-col cols="1"  class="my-0 py-0 mx-2">
              <mybtn
                @click="btnCancel"
                :text="btncanceltext"
                :tooltiptext="btncanceltext"
              ></mybtn>
            </v-col>
          </v-row>
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>


  </v-container>
</template>

<script>
  export default {
    name: "DialogDelete",
    data() {
      return{
        dialog: false,
      }
    },
    props: {
      mydialog:{
        type: Boolean,
        default: false
      },
      text: {
        type: String,
        default: ""
      },
      btncanceltext: {
        type: String,
        default(){
          return  this.$t('cancel')
        }
      },
      btnoktext: {
        type: String,
        default(){
          return  this.$t('ok')
        }
      },
      persistent:{
        type: Boolean,
        default: true
      },
    },
    model: {
      prop: "mydialog",
      event: "changes"
    },
    methods: {
      closeDialog(val){
        this.dialog = val;
        this.$emit("changes", val);
      },
      btnCancel() {
        this.closeDialog(false);
        this.$emit("cancel");
      },
      btnOk() {
        this.closeDialog(false);
        this.$emit("ok");
      },

    },
    watch: {
      mydialog() {
        this.dialog = this.mydialog;
      },
      dialog (val) {
        if (val === false) {
          this.closeDialog(false);
        }
      }
    },
  }

</script>

<style scoped>

</style>