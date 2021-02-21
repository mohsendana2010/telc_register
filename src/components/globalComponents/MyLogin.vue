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
                    v-model="editedItem.userName"
                    :rules="rules.userName"
                    :label="$t(myName + '.userName')"
                    required
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===password -->
                  <v-text-field
                    v-model="editedItem.password"
                    :rules="rules.firstNameRules"
                    :label="$t(myName + '.password')"
                    required
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import {mapGetters} from 'vuex';
  export default {
    name: "MyLogin",
    data() {
      return {
        myName: "Login",
        valid: true,

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
          examTypes:  [
            v => !!v || this.myName + '.rules.subtypeRules1',
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.subtypeRules1'),
            v => (v && v.length <= 50) || this.$t(this.myName + '.rules.subtypeRules2'),
          ],
        };
        return this.formActive
          ? rules : {};
      },

    },



  }
</script>

<style scoped>

</style>