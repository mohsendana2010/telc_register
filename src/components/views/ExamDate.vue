<template>
  <v-container>
    <v-form ref="form" v-model="valid" lazy-validation class="container">
      <v-row class="my-0 py-0">
        <v-col cols="12" xs="12"  sm="6" class="my-0 py-0">
          <!--===writtenExamDate -->
          <my_date_picker
            class="mx-0 px-0"
            v-model="formItems.writtenExamDate"
            :rules="rules.writtenExamDate"
            :label="$t('writtenExamDate')"
            :futureallowed="true"
          ></my_date_picker>
        </v-col>
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--===oralExamData -->
          <my_date_picker
            class="mx-0 px-0"
            v-model="formItems.oralExamData"
            :rules="rules.oralExamData"
            :label="$t('oralExamData')"
            :futureallowed="true"
          ></my_date_picker>
        </v-col>
      </v-row>
      <v-row cols="12" xs="12" sm="6" class="my-0 py-0">
        <v-col  :class="vColClass">
          <!--===registrationDeadline -->
          <my_date_picker
            class="mx-0 px-0"
            v-model="formItems.registrationDeadline"
            :rules="rules.registrationDeadline"
            :label="$t('registrationDeadline')"
            :futureallowed="true"
          ></my_date_picker>
        </v-col>
        <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
          <!--===lastRegistrationDeadline -->
          <my_date_picker
            class="mx-0 px-0"
            v-model="formItems.lastRegistrationDeadline"
            :rules="rules.lastRegistrationDeadline"
            :label="$t('lastRegistrationDeadline')"
            :futureallowed="true"
          ></my_date_picker>
        </v-col>
      </v-row>
      <v-row cols="12" xs="12" sm="6" class="my-0 py-0">
      <v-col  :class="vColClass">
        <!--===examTypes -->
        <v-text-field
          v-model="formItems.examTypes"
          :rules="rules.examTypes"
          :label="$t('examTypes')"
        ></v-text-field>
      </v-col>
      <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
        <!--=== -->

      </v-col>
    </v-row>


      <v-btn
        :disabled="!valid"
        @click="submit"
      >
        {{$t('save')}}
      </v-btn>
      <v-btn @click="clear">{{$t('reset')}}</v-btn>

    </v-form>
  </v-container>
</template>

<script>
  export default {
    name: "ExamDate",
    data() {
      return {
        valid: true,
        formItems: {
          id: "",
          writtenExamDate: "",
          oralExamData: "",
          registrationDeadline: "",
          lastRegistrationDeadline: "",
          examTypes: "",
        },
        rules: {
          writtenExamDate: [
            v => !!v || 'Vorname ist erforderlich',
            v => (v && v.length <= 50) || 'Der Vorname darf nicht länger als 50 Zeichen sein'
          ],
          oralExamData: [
            v => !!v || 'Nachname ist erforderlich',
            v => (v && v.length <= 50) || 'Der Nachname darf nicht länger als 50 Zeichen sein'
          ],
          registrationDeadline: [
            v => !!v || 'Email ist erforderlich',
            v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Email muss gültig sein'
          ],
          lastRegistrationDeadline: [
            v => !!v || 'Geburtsdatum ist erforderlich',
          ],
          examTypes: [
            v => !!v || 'Geburtsdatum ist erforderlich',
          ],

        },
      }
    },
    methods: {
      clear() {
        this.$refs.form.reset()
      },
      submit() {
        if (this.$refs.form.validate()) {
          this.$store.dispatch('examDate/insertExamDate', this.formItems)
            .then(res => {
              console.log(res);
              console.log(res.data);
            })
            .catch(err => {
              console.error(err);
            });
        }

      },
    },

  }
</script>

<style scoped>

</style>