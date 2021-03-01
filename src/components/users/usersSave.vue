<template>
  <v-container >
    <v-form ref="form" v-model="valid" lazy-validation class="container">
      <v-row class="my-0 py-0">
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--===firstName -->
          <v-text-field
            v-model="editedItem[fields[1]]"
            :label="$t(myName +'.' +fields[1])"
            :rules="rules.firstNameRules"
            required
            clearable
            outlined
          ></v-text-field>
        </v-col>
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--===lastName -->
          <v-text-field
            v-model="editedItem[fields[2]]"
            :label="$t(myName +'.' +fields[2])"
            :rules="rules.lastNameRules"
            required
            clearable
            outlined
          ></v-text-field>
        </v-col>

      </v-row>
      <v-row class="my-0 py-0">
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--===user -->
          <v-text-field
            v-model="editedItem[fields[3]]"
            :label="$t(myName +'.' +fields[3])"
            :rules="rules.userRules"
            clearable
            outlined
          ></v-text-field>
        </v-col>
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--===password-->
          <v-text-field
            v-model="editedItem[fields[4]]"
            :label="$t(myName +'.' +fields[4])"
            :rules="rules.passwordRules"
            clearable
            outlined
          ></v-text-field>
        </v-col>
      </v-row>
      <!--      buttons-->
      <mysavebtn
        :disabled="!valid"
        @submit="submit"
        @clear="clear"
      ></mysavebtn>

    </v-form>
  </v-container>
</template>

<script>
  import {mapGetters} from 'vuex';
  export default {
    name: "usersSave",
    data() {
      return {
        myName: "Users",
        valid: true,
        fields: [
          "id", "firstName", "lastName", "user", "password", "access"
        ],
      }
    },
    computed: {
      ...mapGetters({
        formActive: "language/getFormActive",
      }),
      getItems() {
        return this.$store.getters[`${this.myName}/getItems`]
      },
      editedItem() {
        return this.$store.getters[`${this.myName}/getEditedItem`]
      },
      editedIndex() {
        return this.$store.getters[`${this.myName}/getEditedIndex`]
      },
      rules() {
        let rules = {
          firstNameRules: [
            v => !!v || this.$t(this.myName + '.rules.firstNameRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.firstNameRules1'),
            v => (v && v.length <= 50) || this.$t(this.myName + '.rules.firstNameRules2')
          ],
          lastNameRules: [
            v => !!v || this.$t(this.myName + '.rules.lastNameRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.lastNameRules1'),
            v => (v && v.length <= 50) || this.$t(this.myName + '.rules.lastNameRules2')
          ],
          userRules: [
            v => !!v || this.$t(this.myName + '.rules.userRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.userRules1'),
            v => /^[a-zA-Z0-9äöüÄÖÜß]+([.\-_]?[a-zA-Z0-9äöüÄÖÜß]+)*@[a-zA-Z0-9äöüÄÖÜß]+([.\-_]?[a-zA-Z0-9äöüÄÖÜß]+)*(\.[a-zA-Z0-9äöüÄÖÜß]{2,3})+$/.test(v)
              || this.$t(this.myName + '.rules.userRules2'),
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
      this.initialize()
    },
    methods: {
      initialize() {
      },
      close() {
        this.$emit("change");
      },
      clear() {
        this.$refs.form.reset()
      },
      submit() {
        if (this.$refs.form.validate()) {
          if (this.editedIndex >= 0) {
            this.editedItem.id = this.editedIndex;
          }
          this.$store.dispatch(`${this.myName}/saveItem`, this.editedItem)
            .then(() => {
              this.$store.dispatch(`${this.myName}/selectItems`);
              this.clear();
              this.close();
            })
            .catch(err => {
              console.error(err);
            });
        }
      },
    },
    watch: {
      editedIndex() {
        if (this.editedIndex === -1){
          this.clear();
        }
      },
    },

  }
</script>

<style scoped>

</style>