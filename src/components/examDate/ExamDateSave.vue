<template>
  <v-container>
    <v-form ref="form" v-model="valid" lazy-validation class="container">
      <v-row class="my-0 py-0">
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--===writtenExamDate -->
          <my_date_picker
            class="mx-0 px-0"
            v-model="editedItem.writingExamDate"
            :label="$t(myName + '.' +fields[1])"
            :futureallowed="true"
            :max="maxDate"
            :min="minDate"
          ></my_date_picker>
        </v-col>
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--===oralExamData -->
          <my_date_picker
            class="mx-0 px-0"
            v-model="editedItem[fields[2]]"
            :label="$t(myName +'.' +fields[2])"
            :futureallowed="true"
            :max="maxDate"
            :min="minDate"
          ></my_date_picker>
        </v-col>
      </v-row>
      <v-row cols="12" xs="12" sm="6" class="my-0 py-0">
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--===registrationDeadline -->
          <my_date_picker
            class="mx-0 px-0"
            v-model="editedItem[fields[3]]"
            :label="$t(myName +'.' +fields[3])"
            :futureallowed="true"
            :max="maxDate"
            :min="minDate"
          ></my_date_picker>
        </v-col>
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--===lastRegistrationDeadline -->
          <my_date_picker
            class="mx-0 px-0"
            v-model="editedItem[fields[4]]"
            :label="$t(myName +'.' +fields[4])"
            :futureallowed="true"
            :max="maxDate"
            :min="minDate"
          ></my_date_picker>
        </v-col>
      </v-row>
      <v-row cols="12" xs="12" sm="6" class="my-0 py-0">
<!--        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">-->
<!--          &lt;!&ndash;===examTypes &ndash;&gt;-->
<!--          <v-text-field-->
<!--            v-model="editedItem[fields[5]]"-->
<!--            :rules="rules.examTypesRules"-->
<!--            :label="$t(myName +'.' +fields[5])"-->
<!--          ></v-text-field>-->
<!--        </v-col>-->
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--=== -->
         <myselectall
           v-model="examTypeSelect"
           :label="$t(myName +'.' +fields[5])"
           :items="formatedItemsExamType"
           notshowall
           :rules="rules.examTypesRules"
         ></myselectall>

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
  // "id", "writingExamDate", "speakingExamData",
  //   "registrationDeadline", "lastRegistrationDeadline", "examTypes"
  export default {
    name: "ExamDate",
    data() {
      return {
        myName: "ExamDate",
        valid: true,
        // examTypes: [],
        examTypeSelect: [],

        fields: [
          "id",
          "writingExamDate",
          "speakingExamData",
          "registrationDeadline",
          "lastRegistrationDeadline",
          "examTypes"
        ],
      }
    },
    computed: {
      ...mapGetters({
        examTypes: "ExamType/getItems",
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
      maxDate() {
        return this.$moment(new Date()).add(2, 'years').format('YYYY-MM-DD');
      },
      minDate() {
        return this.$moment(new Date()).subtract(1, 'years').format('YYYY-MM-DD');
      },

      rules() {
        let rules = {
          // writtenExamDate: [
          //   v => !!v || 'Vorname ist erforderlich',
          //   v => (v && v.length <= 50) || 'Der Vorname darf nicht länger als 50 Zeichen sein'
          // ],
          // oralExamData: [
          //   v => !!v || 'Nachname ist erforderlich',
          //   v => (v && v.length <= 50) || 'Der Nachname darf nicht länger als 50 Zeichen sein'
          // ],
          // registrationDeadline: [
          //   v => !!v || 'Email ist erforderlich',
          //   v => (v && v.length <= 50) || 'Der Nachname darf nicht länger als 50 Zeichen sein'
          // ],
          // lastRegistrationDeadline: [
          //   v => !!v || 'Geburtsdatum ist erforderlich',
          // ],
          examTypesRules:  [
            v => !!v || this.$t(this.myName + '.rules.examTypesRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.examTypesRules1'),
            v => (v && v.length <= 50) || this.$t(this.myName + '.rules.examTypesRules2'),
          ],
        };
        return this.formActive
          ? rules : {};
      },

      formatedItemsExamType() {
        let temp =  this.$store.getters[`ExamType/formatedItems`];
        let arryTemp = [];
        for (let i = 0; i< temp.length; i++){
          arryTemp.push(temp[i].text);
        }
        return arryTemp;
      },
    },
    created() {
      this.initialize()
    },
    methods: {
      initialize() {
        if (this.examTypes.length === 0) {
          this.$store.dispatch('ExamType/selectItems');
        }
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
              // console.log(res);
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
    watch:{
      editedIndex() {
        if (this.editedIndex === -1){
          this.clear();
        }
      },
      'editedItem.writingExamDate'() {
        console.log('test12',typeof (this.editedItem.speakingExamData));
        if (this.editedItem.speakingExamData == "" || typeof (this.editedItem.speakingExamData) == "undefined") {
          this.editedItem.speakingExamData = this.$moment(this.editedItem.writingExamDate).add(1, 'days').format('YYYY-MM-DD');
        }if (this.editedItem.registrationDeadline == "" || typeof (this.editedItem.registrationDeadline) == "undefined") {
          this.editedItem.registrationDeadline = this.$moment(this.editedItem.speakingExamData).subtract(1, 'months').format('YYYY-MM-DD');
        }if (this.editedItem.lastRegistrationDeadline == "" || typeof (this.editedItem.lastRegistrationDeadline) == "undefined") {
          this.editedItem.lastRegistrationDeadline = this.$moment(this.editedItem.writingExamDate).subtract(11, 'days').format('YYYY-MM-DD');
        }
      },
      examTypeSelect() {
       this.editedItem.examTypes = JSON.stringify(this.examTypeSelect);
        console.log(' this.examTypeSelect.',this.examTypeSelect);
      },
      "editedItem.examTypes"() {
        this.examTypeSelect = JSON.parse(this.editedItem.examTypes);
        console.log(' this.editedItem.examTypes',this.editedItem.examTypes);
  },
      formatedItemsExamType() {

        console.log('formatedItemsExamType',this.formatedItemsExamType);
      },
    },

  }
</script>

<style scoped>

</style>