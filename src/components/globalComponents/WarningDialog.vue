<template>
  <v-container>
    <v-row justify="center">
      <v-dialog
        v-model="dialog"
        max-width="500px"
        :persistent="persistent"
      >
        <v-row justify="center" no-gutters>
          <v-col>
            <v-card
              max-width="495px"
              elevation="10"
            >
              <v-card-title class="headline"></v-card-title>
              <v-card-text>
                <p class="font-weight-black">
                {{text}}
                </p>
              </v-card-text>
              <v-card-actions>
                <v-row justify="end">
                  <v-col align="end" class="my-0 py-0">
                    <mybtn
                      @click="btnOk"
                      :text="btnoktext"
                    ></mybtn>
                  </v-col>
                  <v-col class="my-0 py-0" v-if="cancelbutton">
                    <mybtn
                      @click="btnCancel"
                      :text="btncanceltext"
                    ></mybtn>
                  </v-col>
                </v-row>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-dialog>
    </v-row>
  </v-container>
</template>

<script>
  export default {
    name: "DialogDelete",
    data() {
      return {
        dialog: false,
      }
    },
    props: {
      mydialog: {
        type: Boolean,
        default: false
      },
      text: {
        type: String,
        default: ""
      },
      cancelbutton: {
        type: Boolean,
        default: false
      },
      btncanceltext: {
        type: String,
        default() {
          return this.$t('cancel')
        }
      },
      btnoktext: {
        type: String,
        default() {
          return this.$t('ok')
        }
      },
      persistent: {
        type: Boolean,
        default: false
      },

    },
    model: {
      prop: "mydialog",
      event: "changes"
    },
    methods: {
      closeDialog(val) {
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
      dialog(val) {
        if (val === false) {
          this.closeDialog(false);
        }
      }
    },
  }

</script>

<style scoped>

</style>