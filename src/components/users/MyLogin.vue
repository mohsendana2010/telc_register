<template>
  <v-container>
    <v-row justify="center">
      <v-col
        xs="10"
      >
        <v-card
          outlined
          class="mx-auto"
          elevation="10"
        >
          <v-card-title>
            <v-row justify='space-between'>
              <v-col>
                <v-toolbar-title>{{$t(myName + "." + myName)}}</v-toolbar-title>
              </v-col>
              <v-spacer></v-spacer>
              <v-col>

              </v-col>
            </v-row>
          </v-card-title>
          <v-card-text>
            <v-form ref="form" v-model="valid" lazy-validation class="container">
              <v-row class="my-0 py-0">
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===userName -->
                  <v-text-field
                    v-model="editedItem.user"
                    :rules="rules.userRules"
                    :label="$t(myName + '.user')"
                    required
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===password -->
                  <v-text-field
                    v-model="editedItem.password"
                    :rules="rules.passwordRules"
                    :label="$t(myName + '.password')"
                    @keyup.enter="submit"
                    :type="showPass ? 'text' : 'password'"
                    :append-icon="showPass ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="showPass = !showPass"
                    required
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-form>
            <mysavebtn
              :disabled="!valid"
              @submit="submit"
              @clear="forgotPassword"
              :savetext="$t(myName + '.login')"
              :savetooltiptext="$t(myName + '.login')"
              :cleartext="$t(myName + '.forgotPassword')"
              :cleartooltiptext="$t(myName + '.forgotPassword')"
            ></mysavebtn>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

<!--    <v-dialog-->
<!--      v-model="dialogForgotPassword"-->
<!--      max-width="700px"-->
<!--    >-->
<!--      <v-card>-->
<!--        <v-card-text>-->
<!--          <v-container>-->

            <forgotPassword
              v-model="dialogForgotPassword"
            ></forgotPassword>

<!--          </v-container>-->
<!--        </v-card-text>-->
<!--      </v-card>-->
<!--    </v-dialog>-->


  </v-container>
</template>

<script>
  import {mapGetters} from 'vuex';
  import forgotPassword from './MyForgotPassword'

  export default {
    name: "MyLogin",
    components: {
      forgotPassword,
    },
    data() {
      return {
        showPass: false,
        myName: "Login",
        valid: true,
        dialogForgotPassword: false,

      }
    },
    computed: {
      ...mapGetters({
        formActive: "language/getFormActive",
      }),
      editedItem() {
        return this.$store.getters[`${this.myName}/getEditedItem`]
      },
      logind() {
        return this.$store.getters[`${this.myName}/getEditedItem`]
      },
      rules() {
        let rules = {
          userRules: [
            v => !!v || this.$t(this.myName + '.rules.userRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.userRules1'),
            v => /^[a-zA-Z0-9äöüÄÖÜß]+([.\-_]?[a-zA-Z0-9äöüÄÖÜß]+)*@[a-zA-Z0-9äöüÄÖÜß]+([.\-_]?[a-zA-Z0-9äöüÄÖÜß]+)*(\.[a-zA-Z0-9äöüÄÖÜß]{2,3})+$/.test(v) || this.$t(this.myName + '.rules.userRules2')

          ],
          passwordRules: [
            v => !!v || this.$t(this.myName + '.rules.passwordRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.passwordRules1'),
          ],
        };

        return this.formActive
          ? rules : {};
      },

    },

    created() {
      this.initialize();
    },
    methods: {
      initialize() {
      },

      clear() {
        this.$refs.form.reset();
      },
      submit() {        //
        if (this.$refs.form.validate()) {

          this.$store.dispatch(`${this.myName}/login`, this.editedItem)
            .then((res) => {
              // console.log(' res my promis', res.data);
              if (res.data.loggedIn) {
                this.$router.push({path: 'menu'});
              } else {
                this.clear();
              }
              // this.$router.push({path: 'menu'});
              // console.log('login submit', res);
              // if (res.data === "captchaError") {
              //   this.refreshCaptcha = !this.refreshCaptcha;
              // } else if (res.data === "success") {
              //   this.warningMode = "ok";
              //   this.warningModeChange();
              // } else {
              //   console.log(' log', res);
              //   this.warningMode = "error";
              //   this.warningModeChange();
              // }
            })
            .catch(err => {
              console.error(err);
            });
        }
      },
      forgotPassword() {
        this.dialogForgotPassword = true;
      },

    },

  }
</script>

<style scoped>

</style>