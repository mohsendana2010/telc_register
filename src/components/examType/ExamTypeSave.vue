<template>
  <v-container>
    <v-form ref="form" v-model="valid" lazy-validation class="container">
      <v-row class="my-0 py-0">
        <v-col cols="12" xs="12" sm="4" class="my-0 py-0">
          <!--===language -->
          <v-select
            v-model="editedItem[fields[1]]"
            :items="languages"
            :rules="rules.languageRules"
            :label="$t(myName +'.' +fields[1])"
            required
          ></v-select>
        </v-col>
        <v-col cols="12" xs="12" sm="4" class="my-0 py-0">
          <!--===type -->
          <v-text-field
            v-model="editedItem[fields[2]]"
            :rules="rules.typeRules"
            :label="$t(myName +'.' +fields[2])"
            required
          ></v-text-field>
        </v-col>
        <v-col cols="12" xs="12" sm="4" class="my-0 py-0">
          <!--===subtype -->
          <v-text-field
            v-model="editedItem[fields[3]]"
            :rules="rules.subtypeRules"
            :label="$t(myName +'.' +fields[3])"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row class="my-0 py-0">
        <v-col cols="12" xs="12" class="my-0 py-0">
          <!--          description-->
          <v-textarea
            v-model="editedItem[fields[4]]"
            clearable
            clear-icon="mdi-close-circle"
            :label="$t(myName +'.' +fields[4])"
          ></v-textarea>
        </v-col>
      </v-row>
      <!--      buttons-->
      <v-row class="my-0 py-0">
        <v-col align="start" class="my-0 py-0 mx-2">
          <mybtn
            :disabled="!valid"
            @click="submit"
            :text="$t('save')"
            :tooltiptext="$t('save')"
          ></mybtn>
        </v-col>
        <v-col align="end" class="my-0 py-0 mx-2">
          <mybtn
            @click="clear"
            :text="$t('reset')"
            :tooltiptext="$t('reset')"
          ></mybtn>
        </v-col>
      </v-row>
    </v-form>
  </v-container>
</template>

<script>
  import {mapGetters} from 'vuex';

  export default {
    name: "ExamTypeSave",
    data() {
      return {
        myName: "ExamType",
        valid: true,
        languages: ["Deutsch", " Englisch"],
        fields: [
          "id",
          "language",
          "type",
          "subtype",
          "description"
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
          languageRules: [
            v => !!v || this.$t(this.myName + '.rules.languageRules'),
          ],
          typeRules: [
            v => !!v || this.$t(this.myName + '.rules.typeRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.typeRules1'),
            v => (v && v.length <= 50) || this.$t(this.myName + '.rules.typeRules2'),
          ],
          subtypeRules: [
            v => !!v || this.myName + '.rules.subtypeRules1',
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.subtypeRules1'),
            v => (v && v.length <= 50) || this.$t(this.myName + '.rules.subtypeRules2'),
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