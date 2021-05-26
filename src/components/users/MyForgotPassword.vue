<template>
  <v-container>
    <v-dialog
      v-model="dialogForgotPassword"
      max-width="700px"
      persistent
    >
<!--      <v-row justify="center">-->
<!--        <v-col-->
<!--          xs="10"-->
<!--        >-->
          <v-card
            outlined
            class="mx-auto"
            elevation="10"
          >
            <v-card-title>
              <v-row justify='space-between'>
                <v-col>
                  <v-toolbar-title>{{$t(myName + '.NewPassword')}}</v-toolbar-title>
                </v-col>
                <v-spacer></v-spacer>
                <v-col>

                </v-col>
              </v-row>
            </v-card-title>
            <v-card-text>
              <v-form ref="form" v-model="valid" lazy-validation class="container">
                <v-row class="my-0 py-0">
                  <v-col cols="12" xs="12" sm="12" class="my-0 py-0">
                    <!--===userName -->
                    <v-text-field
                      v-model="userName"
                      :rules="rules.userRules"
                      :label="$t(myName + '.user')"
                      required
                      clearable
                      outlined
                    ></v-text-field>
                  </v-col>
                </v-row>
                <v-row>
                  <v-col cols="12" xs="12" sm="12" class="my-0 py-0">
                    <v-card
                      class="mb-2 px-0"
                    >
                      <v-card-text>
                        <v-row class="my-0 py-0">
                          <v-col cols="12" xs="12" sm="12" class="my-0 py-0">
                            <!--===captcha -->
                            <mycaptcha
                              :refresh="refreshCaptcha"
                              :rules="rules.captchaRuls"
                            ></mycaptcha>
                          </v-col>
                        </v-row>
                      </v-card-text>
                    </v-card>
                  </v-col>
                </v-row>
              </v-form>
              <mysavebtn
                :disabled="!valid"
                @submit="submit"
                @clear="back"
                :savetext="$t('sendRequest')"
                :savetooltiptext="$t('sendRequest')"
                :cleartext="$t('back')"
                :cleartooltiptext="$t('back')"
              ></mysavebtn>
            </v-card-text>
          </v-card>
<!--        </v-col>-->
<!--      </v-row>-->
    </v-dialog>
  </v-container>
</template>

<script>
  import {mapGetters} from 'vuex';

  export default {
    name: "NewPassword",
    data() {
      return {
        dialogForgotPassword: this.mydialogforgotpassword,
        refreshCaptcha: true,
        myName: "Login",
        valid: true,
        userName: '',

      }
    },
    computed: {
      ...mapGetters({
        formActive: "language/getFormActive",
      }),
      editedItem() {
        return this.$store.getters[`${this.myName}/getEditedItem`]
      },
      rules() {
        let rules = {
          userRules: [
            v => !!v || this.$t(this.myName + '.rules.userRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.userRules1'),
            v => /^[a-zA-Z0-9äöüÄÖÜß]+([.\-_]?[a-zA-Z0-9äöüÄÖÜß]+)*@[a-zA-Z0-9äöüÄÖÜß]+([.\-_]?[a-zA-Z0-9äöüÄÖÜß]+)*(\.[a-zA-Z0-9äöüÄÖÜß]{2,3})+$/.test(v) || this.$t(this.myName + '.rules.userRules2')

          ],
          captchaRuls: [
            v => !!v || this.$t('captcha.captchaText'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.captchaText'),
          ],
        };

        return this.formActive
          ? rules : {};
      },

    },
    props: {
      mydialogforgotpassword: {
        type: Boolean,
        default: false,
      }
    },

    model: {
      prop: "mydialogforgotpassword",
      event: "changes"
    },

    created() {
      this.initialize();
    },
    methods: {
      initialize() {
        // this.dialogForgotPassword = this.mydialogforgotpassword;
      },

      /**
       * @param value Boolean
       */
      closeDialog(value) {
        this.dialogForgotPassword = value;
        this.$emit("changes", value);
        this.$emit("next");
      },

      clear() {
        this.$refs.form.reset();
      },
      submit() {        //
        if (this.$refs.form.validate()) {
          this.editedItem.user = this.userName;
          this.editedItem.captcha = true;

          this.$store.dispatch(`${this.myName}/forgotPassword`, this.editedItem)
            .then((res) => {
              console.log('MyForgotPassword submit', res);
              if (res.data === "captchaError") {
                this.refreshCaptcha = !this.refreshCaptcha;
              } else {
                this.editedItem.user = '';
                this.closeDialog(false);
              }

            })
            .catch(err => {
              console.error(err);
            });
        }
      },
      back() {
        this.closeDialog(false);
      },

    },
    watch: {
      mydialogforgotpassword() {
        this.dialogForgotPassword = this.mydialogforgotpassword;
      },
    }
  }
</script>

<style scoped>

</style>