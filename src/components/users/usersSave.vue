<template>
  <v-container >
    <v-form ref="form" v-model="valid" lazy-validation class="container">
      <v-row class="my-0 py-0">
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--===language -->
          <v-text-field
            v-model="editedItem[fields[1]]"
            :rules="rules.languageRules"
            :label="$t(myName +'.' +fields[1])"
            required
            clearable
            outlined
          ></v-text-field>
        </v-col>
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--===type -->
          <v-text-field
            v-model="editedItem[fields[2]]"
            :label="$t(myName +'.' +fields[2])"
            required
            clearable
            outlined
          ></v-text-field>
        </v-col>

      </v-row>
      <v-row class="my-0 py-0">
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--===subtype -->
          <v-text-field
            v-model="editedItem[fields[3]]"
            :label="$t(myName +'.' +fields[3])"
            clearable
            outlined
          ></v-text-field>
        </v-col>
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--          description-->
          <v-text-field
            v-model="editedItem[fields[4]]"
            :label="$t(myName +'.' +fields[4])"
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
          // firstNameRules: [
          //   v => !!v || this.$t(this.myName + '.rules.languageRules'),
          // ],
          // lastNameRules: [
          //   v => !!v || this.$t(this.myName + '.rules.typeRules1'),
          //   v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.typeRules1'),
          //   v => (v && v.length <= 50) || this.$t(this.myName + '.rules.typeRules2'),
          // ],
          // subtypeRules: [
          //   v => !!v || this.myName + '.rules.subtypeRules1',
          //   v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.subtypeRules1'),
          //   v => (v && v.length <= 50) || this.$t(this.myName + '.rules.subtypeRules2'),
          // ],
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