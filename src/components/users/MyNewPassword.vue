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
                  <!--===password1 -->
                  <v-text-field
                    v-model="password1"
                    :rules="rules.passwordRules"
                    :label="$t(myName + '.password')"
                    :type="showPass1 ? 'text' : 'password'"
                    :append-icon="showPass1 ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="showPass1 = !showPass1"
                    required
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" xs="12" sm="12" class="my-0 py-0">
                  <!--===password2 -->
                  <v-text-field
                    v-model="password2"
                    :rules="rules.passwordRules"
                    :label="$t(myName + '.password')"
                    :type="showPass2 ? 'text' : 'password'"
                    :append-icon="showPass2 ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="showPass2 = !showPass2"
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
              @clear="clear"
              :savetext="$t(myName + '.changePassword')"
              :savetooltiptext="$t(myName + '.changePassword')"
              :cleartext="$t('reset')"
              :cleartooltiptext="$t('reset')"
            ></mysavebtn>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import {mapGetters} from 'vuex';

  export default {
    name: "NewPassword",
    data() {
      return {
        myName: "Login",
        password1: '',
        password2: '',
        showPass1: false,
        showPass2: false,
        editedItem: {},
        valid: false,
      }
    },
    computed: {
      ...mapGetters({
        formActive: "language/getFormActive",
      }),
      rules() {
        let rules = {
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
          let token = window.location.hash;
          if (this.password2 === this.password1 && token.search("=") !==  -1) {
            token = token.substr(token.search("=") + 1);
            localStorage.setItem('token', token);
            this.editedItem.password = this.password2;
            this.$store.dispatch(`${this.myName}/newPassword`, this.editedItem)
              .then((res) => {
                if (res.data === "captchaError") {
                  this.refreshCaptcha = !this.refreshCaptcha;
                }
                console.log('submit MyNewPassword users component', res);
                // console.log(' res my promis', res.data);
                // if (res.data.loggedIn) {
                //   this.$router.push({path: 'menu'});
                // } else {
                //   this.clear();
                // }
              })
              .catch(err => {
                console.error(err);
              });
          } else {
            this.valid = false;
          }
        }
      },
    },
    watch: {
      password2() {
        this.valid = this.password2 === this.password1;
      },
    }
  }
</script>

<style scoped>

</style>