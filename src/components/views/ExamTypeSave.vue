<template>
  <v-container>
    <v-form ref="form" v-model="valid" lazy-validation class="container">
      <v-row class="my-0 py-0">
        <v-col cols="12" xs="12" sm="4" class="my-0 py-0">
          <!--===language -->
          <v-select
            v-model="editedItem.language"
            :items="languages"
            :rules="rules.language"
            :label="$t('language')"
            required
          ></v-select>
        </v-col>
        <v-col cols="12" xs="12" sm="4" class="my-0 py-0">
          <!--===type -->
          <v-text-field
            v-model="editedItem.type"
            :rules="rules.type"
            :label="$t('type')"
            required
          ></v-text-field>
        </v-col>
        <v-col cols="12" xs="12" sm="4" class="my-0 py-0">
          <!--===subtype -->
          <v-text-field
            v-model="editedItem.subtype"
            :rules="rules.subtype"
            :label="$t('subtype')"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row class="my-0 py-0">
        <v-col cols="12" xs="12" class="my-0 py-0">
          <v-textarea
            v-model="editedItem.description"
            clearable
            clear-icon="mdi-close-circle"
            :label="$t('description')"
            :rules="rules.description"
          ></v-textarea>
        </v-col>
      </v-row>


      <v-btn
        :disabled="!valid"
        @click="submit"
      >
        {{$t('save')}}
      </v-btn>
      <v-btn @click="clear">{{$t('reset')}}</v-btn>
      <v-btn @click="test">test</v-btn>

    </v-form>
  </v-container>
</template>

<script>

  import {mapGetters} from 'vuex';

  export default {
    name: "ExamTypeSave",
    data() {
      return {
        valid: true,
        languages: ["Deutsch", " Englisch"],
        rules: {
          language: [
            v => !!v || 'language ist erforderlich',
            v => (v && v.length <= 50) || 'Der language darf nicht länger als 50 Zeichen sein'
          ],
          type: [
            v => !!v || 'type ist erforderlich',
            v => (v && v.length <= 50) || 'Der type darf nicht länger als 50 Zeichen sein'
          ],
          subtype: [
            v => !!v || 'subtype ist erforderlich',
            v => (v && v.length <= 100) || 'Der subtype darf nicht länger als 100 Zeichen sein'
          ],
          description: [
            //v => !!v || 'Geburtsdatum ist erforderlich',
          ],

        },
      }
    },
    props: {
    },
    model: {
      prop: "myvalue",
      event: "changes"
    },
    computed: {
      ...mapGetters({
        getExamTypes: "examType/getExamTypes",
        getDefaultItem: "examType/getDefaultItem",
        editedItem: "examType/getEditedItem",
        id: "examType/getEditedIndex",

      }),
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
          if (this.id >= 0) {
            this.editedItem.id = this.id;
          }
          this.$store.dispatch('examType/insertExamType', this.editedItem)
            .then(res => {
              console.log('lokal', res);
              this.clear();
              this.close();
            })
            .catch(err => {
              console.error(err);
            });
        }
      },
      test() {
        if (this.getExamTypes.length === 0) {
          this.$store.dispatch('examType/selectExamType');
        } else {
          console.log('lokal2:', this.getExamTypes);
        }

      },
    },
    watch: {
      id() {
        console.log('id:' , this.id);
        console.log('id?', this.editedItem );
      },

    },

  }
</script>

<style scoped>

</style>