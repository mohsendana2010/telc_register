<template>
  <v-container>
    <v-dialog
      v-model="dialog"
      max-width="450px"
      :persistent="persistent"
    >
      <v-card>
        <v-card-title class="headline" >{{text}}</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>

          <v-row class="my-0 py-0"  >
            <v-col align="start" class="my-0 py-0">
              <mybtn
                @click="btnOk"
                :text="btnoktext"
                :tooltiptext="btnoktext"
              ></mybtn>
            </v-col>
            <v-col align="end"  class="my-0 py-0"  v-if="cancelbutton">
              <mybtn
                @click="btnCancel"
                :text="btncanceltext"
                :tooltiptext="btncanceltext"
              ></mybtn>
            </v-col>
          </v-row>
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
      cancelbutton:{
        type: Boolean,
        default: false
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
        default: false
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