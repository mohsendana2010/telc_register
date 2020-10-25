<template>
  <v-container>
    <v-form ref="form" v-model="valid" lazy-validation class="container">
      <v-row class="my-0 py-0">
        <v-col xs="12" sm="12" class="my-0 py-0">
          <v-radio-group
            v-model="editedItem.gender"
            :mandatory="false"
            :rules="[v => !!v || 'Auswahl ist erforderlich!']"
            row
          >
            <v-radio :label="$t('male')" value="male"></v-radio>
            <v-radio :label="$t('female')" value="female"></v-radio>
          </v-radio-group>
        </v-col>
      </v-row>
      <v-row class="my-0 py-0">
        <v-col xs="12" sm="12" md="6" class="my-0 py-0">
          <!--===firstName -->
          <v-text-field
            v-model="editedItem.firstName"
            :rules="rules.firstNameRules"
            :label="$t('firstName')"
            required
          ></v-text-field>
        </v-col>
        <v-col xs="12" sm="12" md="6"  class="my-0 py-0">
          <!--===lastName -->
          <v-text-field
            v-model="editedItem.lastName"
            :rules="rules.lastNameRules"
            :label="$t('lastName')"
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row class="my-0 py-0">
        <v-col xs="12" sm="6" class="my-0 py-0">
          <!--===title -->
          <v-select
            v-model="editedItem.title"
            :items="titleItems"
            :label="$t('title')"
          ></v-select>
        </v-col>
        <v-col xs="12" sm="6" class="my-0 py-0">
          <!--===email -->
          <v-text-field
            v-model="editedItem.email"
            :rules="rules.EmailRules"
            :label="$t('email')"
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row class="my-0 py-0">
        <v-col xs="12" sm="6" class="my-0 py-0">
          <!--===birthday -->
          <my_date_picker
            class="mx-0 px-0"
            v-model="editedItem.birthday"
            :label="$t('birthday')"
            textup="Datum"
            min="1800-01-01"
            :max="maxBirthday"
            :notcurentdate="false"
          ></my_date_picker>
        </v-col>
        <v-col xs="12" sm="6" class="my-0 py-0">
          <!--===mobile -->
          <v-text-field
            v-model="editedItem.mobile"
            :rules="rules.mobileRules"
            :label="$t('mobile')"
            v-on:keypress="isNumber(event)"
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row class="my-0 py-0">
        <v-col xs="12" sm="6" class="my-0 py-0">
          <!--===birthCountry -->
          <v-autocomplete
            :items="states"
            v-model="editedItem.birthCountry"
            :rules="rules.countryRules"
            :label="$t('countryOfBirth')"
          >
            <!--          cache-items-->
            <!--          flat-->
            <!--          hide-no-data-->
            <!--          hide-details-->
            <template slot="prepend-inner">
              <v-icon
                color="blue darken-4"
              >mdi-city
              </v-icon>
            </template>
          </v-autocomplete>
        </v-col>
        <v-col xs="12" sm="6" class="my-0 py-0">
          <!--===birthCity -->
          <v-text-field
            v-model="editedItem.birthCity"
            :rules="rules.placeRules"
            :label="$t('birthCity')"
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row class="my-0 py-0">
        <v-col xs="12" sm="6" class="my-0 py-0">
          <!--===streetNr -->
          <v-text-field
            v-model="editedItem.streetNr"
            :rules="rules.streetNrRules"
            :label="$t('streetNr')"
            required
          ></v-text-field>
        </v-col>
        <v-col xs="12" sm="6" class="my-0 py-0">
          <!--===co -->
          <v-text-field
            v-model="editedItem.co"
            :label="$t('co')"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row class="my-0 py-0">
        <v-col xs="12" sm="6" class="my-0 py-0">
          <!--===postCode -->
          <v-text-field
            v-model="editedItem.postCode"
            :rules="rules.postCodeRules"
            :label="$t('postCode')"
            required
          ></v-text-field>
        </v-col>
        <v-col xs="12" sm="6" class="my-0 py-0">
          <!--===place -->
          <v-text-field
            v-model="editedItem.place"
            :rules="rules.placeRules"
            :label="$t('place')"
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row class="my-0 py-0">
        <v-col xs="12" sm="6" class="my-0 py-0">
          <!--===country -->
          <v-autocomplete
            :items="states"
            v-model="editedItem.country"
            :rules="rules.countryRules"
            cache-items
            flat
            hide-no-data
            hide-details
            :label="$t('country')"
          ></v-autocomplete>
        </v-col>
        <v-col xs="12" sm="6" class="my-0 py-0">

        </v-col>
      </v-row>
      <v-row class="my-0 py-0">
        <v-col xs="12" sm="6" class="my-0 py-0">
          <!--===examDate -->
          <v-select
            v-model="editedItem.examDate"
            :items="itemExamDate"
            :rules="[v => !!v || $t('ExamDateRequired')]"
            :label="$t('examDate')"
            required
          ></v-select>
        </v-col>
        <v-col xs="12" sm="6" class="my-0 py-0">
          <!--===examType -->
          <v-select
            v-model="editedItem.examType"
            :items="itemExamType"
            :rules="[v => !!v || 'Prüfungsbezeichnung ist erforderlich']"
            :label="$t('examType')"
            required
          ></v-select>
        </v-col>
      </v-row>
      <v-checkbox
        v-model="checkboxAGB"
        :rules="[v => !!v || 'Zustimmung ist erforderlich!']"
        required
      >
      <span slot="label">Ich habe die
          <a href='http://www.diwan-marburg.de/allgemeine-geschaeftsbedingungen-agb/'
             onclick="window.open(this.href,'_blank', 'resizable,scrollbars').focus(); return false;">AGB</a>
          gelesen und akzeptiere sie.</span>
      </v-checkbox>
      <v-checkbox
        v-model="checkboxDSE"
        :rules="[v => !!v || 'Zustimmung ist erforderlich!']"
        required
      >
                        <span slot="label">Ich habe die
                            <a href='http://www.diwan-marburg.de/datenschutz/'
                               onclick="window.open(this.href,'_blank', 'resizable,scrollbars').focus(); return false;">Datenschutzerklärung</a>
                            gelesen und akzeptiere sie.</span>
      </v-checkbox>

      <v-btn
        :disabled="!valid"
        @click="submit"
      >
        submit
      </v-btn>
      <v-btn @click="clear">clear</v-btn>

    </v-form>
  </v-container>
</template>

<script>

  import postToPHPServer from '../res/services/postToPHPServer';
  export default {
    name: "TelcRegisterForm",
    components: {
      // date_picker,
    },
    data() {
      return {
        valid: true,
        editedItem: {
          id: "",
          gender: "",
          firstName: "",
          lastName: "",
          birthday: "",
          email: "",
          mobile: "",
          co: "",
          streetNr: "",
          postCode: "",
          place: "",
          country: "",
          birthCountry: "",
          birthCity: "",
          examDate: "",
          examType: "",
          title: "",
          job: "",
          phone: "",
          fax: "",
          message: "",
        },
        checkboxAGB: false,
        checkboxDSE: false,
        rules: {
          firstNameRules: [
            v => !!v || 'Vorname ist erforderlich',
            v => (v && v.length <= 50) || 'Der Vorname darf nicht länger als 50 Zeichen sein'
          ],
          lastNameRules: [
            v => !!v || 'Nachname ist erforderlich',
            v => (v && v.length <= 50) || 'Der Nachname darf nicht länger als 50 Zeichen sein'
          ],
          EmailRules: [
            v => !!v || 'Email ist erforderlich',
            v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Email muss gültig sein'
          ],
          BirthdayRules: [
            v => !!v || 'Geburtsdatum ist erforderlich',
          ],
          mobileRules: [
            // v => !!v || 'Mobile ist erforderlich',
            v => (v && v.length <= 20) || 'Did Nummer darf nicht länger als 20 Zeichen sein'
          ],
          streetNrRules: [
            v => !!v || 'Strasse und Nr. ist erforderlich',
            v => (v && v.length <= 50) || 'Die Strasse und Nr. darf nicht länger als 50 Zeichen sein',
            //v => /^\w+([.-]?\w+)*\s\d{1,5}$/.test(v) || 'Die Strasse und Nr. muss gültig sein'
          ],
          postCodeRules: [
            v => !!v || 'PLZ ist erforderlich',
            v => (v && v.length <= 10) || 'PLZ darf nicht länger als 10 Zeichen sein'
          ],
          placeRules: [
            v => !!v || 'Ort ist erforderlich',
            v => (v && v.length <= 50) || 'Ort darf nicht länger als 50 Zeichen sein'
          ],
          countryRules: [
            v => !!v || 'Land ist erforderlich',
            v => (v && v.length <= 50) || 'Land darf nicht länger als 50 Zeichen sein'
          ],
          examDateRules: [
            v => !!v || 'Prüfungs Datum ist erforderlich',
            v => (v && v.length <= 10) || 'Prüfungs Datum darf nicht länger als 10 Zeichen sein'
          ],
        },
        titleItems: [
          "Prof.",
          "Dr.",
          "-",
        ],
        states: [
          "Afghanistan", "Ägypten,", "Albanien", "Algerien", "Andorra", "Angola", "Antarktis", "Antigua und Barbuda",
          "Äquatorialguinea", "Argentinien", "Armenien", "Aserbaidschan", "Äthiopien", "Australien", "Bahamas",
          "Bahrain", "Bangladesch", "Barbados", "Belgien", "Belize", "Benin", "Bhutan", "Bolivien",
          "Bosnien und Herzegowina", "Botsuana", "Brasilien", "Brunei", "Bulgarien", "Burkina Faso", "Birma", "Burundi",
          "Chile", "China", "Cookinseln", "Costa Rica (cta)", "Dänemark", "Deutschland", "Dominica",
          "Dominikanische Republik", "Dschibuti", "Ecuador", "Elfenbeinküste", "El Salvador", "Eritrea", "Estland",
          "Falklandinseln", "Fidschi", "Finnland", "Föderierte Staaten von Mikronesien", "Frankreich",
          "Französisch Guayana", "Gabun", "Gambia", "Georgien", "Ghana", "Grenada", "Griechenland", "Großbritannien",
          "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Indien", "Indonesien", "Irak", "Iran",
          "Irland", "Island", "Israel", "Italien", "Jamaika", "Japan", "Jemen", "Jordanien", "Kambodscha", "Kamerun",
          "Kanada", "Kap Verde", "Kasachstan", "Katar", "Kenia", "Kirgisistan", "Kiribati", "Kolumbien", "Komoren",
          "Kongo (Demokratische Republik)", "Kongo (Republik) Kosovo", "Kroatien", "Kuba", "Kuwait", "Laos", "Lesotho",
          "Lettland", "Libanon", "Liberia", "Libyen", "Liechtenstein", "Litauen", "Luxemburg", "Madagaskar", "Malawi",
          "Malaysia", "Malediven", "Mali", "Malta", "Marokko", "Marshallinseln", "Mauretanien", "Mauritius", "Mazedonien",
          "Mexiko", "(Föderierte Staaten von) Mikronesien", "Moldawien", "Monaco", "Mongolei", "Montenegro", "Mosambik",
          "Myanmar", "Namibia", "Nauru", "Nepal", "Neuseeland", "Nicaragua", "Niederlande", "Niger", "Nigeria", "Nordkorea",
          "Nordzypern", "Norwegen", "Oman", "Österreich", "Pakistan", "Palau", "Palästina", "Panama", "Papua-Neuguinea",
          "Paraguay", "Peru", "Philippinen", "Polen", "Portugal", "Ruanda", "Rumänien", "Russland", "Saint Kitts und Nevis",
          "Saint Lucia", "Saint Vincent und die Grenadinen", "Salomonen", "Sambia", "Samoa", "San Marino",
          "São Tomé und Príncipe", "Saudi-Arabien", "Senegal", "Serbien", "Seychellen", "Sierra Leone", "Singapur",
          "Simbabwe", "Slowakei", "Slowenien", "Somalia", "Spanien", "Sri Lanka", "Südafrika", "Sudan", "Südsudan",
          "Südkorea", "Surinam", "Svalbard", "Swasiland", "Schweden", "Schweiz", "Syrien", "Tadschikistan", "Taiwan",
          "Tansania", "Thailand", "Timor-Leste", "Togo", "Tonga", "Trinidad und Tobago", "Tschad", "Tschechien",
          "Tunesien", "Türkei", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "Ungarn", "Uruguay", "Usbekistan",
          "Vanuatu", "Vatikan", "Venezuela", "Vereinigte Arabische Emirate", "Vereinigtes Königreich",
          "Vereinigte Staaten von Amerika", "Vietnam", "Weißrussland", "Westsahara", "Zentralafrikanische Republik",
          "Zypern",
        ],
        itemExamDate: [
          "2018-08-25",
          "2018-09-22",
          "2018-10-20",
          "2018-11-24",
          "2018-12-22",
        ],
        itemExamType: [
          "A1",
          "A2",
          "B1",
          "B2",
          "C1",
          "C1-Hochschule",
        ],
      }
    },
    computed: {
      maxBirthday() {
        return this.$moment(new Date()).subtract(3, 'years').format('YYYY-MM-DD');
      },
    },
    methods: {

      clear() {
        this.$refs.form.reset()
      },

      submit() {
        console.log("submit");
        this.login();
        // if (this.$refs.form.validate()) {
        //   console.log("submit");
        // }
      },

       login() {
          try {
            const formData = new FormData();
            formData.append('command', 'Login');

             postToPHPServer.send(formData)
              .then(res => {
                if (res.status === 200) {

                  console.log(res );
                  console.log(res.data);
                  console.log(res.data.token);
                }
              })
              .catch(error => {
                console.error(error);
              });
          } catch (error) {
            console.error(error);
          }
      },

      isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
          evt.preventDefault();
        } else {
          return true;
        }
      },
      test(msg) {
        console.log(msg);
        // let str = "2000-02-12";
        let momentStr = this.$moment(new Date()).subtract(3, 'years').format('YYYY-MM-DD');
        console.log(momentStr);
      },
    }
  }
</script>

<style scoped>

</style>