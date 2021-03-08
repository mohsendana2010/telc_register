<template>
  <v-container>
    <v-form ref="form" v-model="valid" lazy-validation class="container">
      <v-card
        class="mb-2 px-0"
      >
        <v-card-title
          class="headline"
        >
          <v-row justify="center">
            <div>
              {{$t(myName +'.telcExam')}}
            </div>
          </v-row>
        </v-card-title>
        <v-card-text>
          <!--   personalData card-->
          <v-card
            class="mb-2 px-0"
            elevation="10"
          >
            <v-card-title
              class="headline"
            >{{$t(myName + '.personalData')}}
            </v-card-title>
            <v-card-text>
              <v-row class="my-0 py-0">
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===gender -->
                  <v-radio-group
                    v-model="editedItem.gender"
                    :mandatory="false"
                    :rules="rules.genderRules"
                    row
                  >
                    <v-radio :label="$t(myName + '.male')" value="male"></v-radio>
                    <v-radio :label="$t(myName + '.female')" value="female"></v-radio>
                  </v-radio-group>
                </v-col>
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===title -->
                  <v-select
                    v-model="editedItem.title"
                    :items="titleItems"
                    :label="$t(myName + '.title')"
                    clearable
                    outlined
                  ></v-select>
                </v-col>
              </v-row>
              <v-row class="my-0 py-0">
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===firstName -->
                  <v-text-field
                    v-model="editedItem.firstName"
                    :rules="rules.firstNameRules"
                    :label="$t(myName + '.firstName')"
                    required
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===lastName -->
                  <v-text-field
                    v-model="editedItem.lastName"
                    :rules="rules.lastNameRules"
                    :label="$t(myName + '.lastName')"
                    required
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row class="my-0 py-0">
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===mobile -->
                  <v-text-field
                    v-model="editedItem.mobile"
                    :rules="rules.mobileRules"
                    :label="$t(myName + '.mobile')"
                    @keypress="isNumber"
                    @paste="onPaste"
                    prepend-inner-icon="mdi-cellphone-basic"
                    required
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===email -->
                  <v-text-field
                    v-model="editedItem.email"
                    :rules="rules.EmailRules"
                    :label="$t(myName + '.email')"
                    required
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row class="my-0 py-0">
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===birthday -->
                  <my_date_picker
                    class="mx-0 px-0"
                    v-model="editedItem.birthday"
                    :label="$t(myName + '.birthday')"
                    min="1950-01-01"
                    :max="maxBirthday"
                    :futureallowed="false"
                    :rules="rules.BirthdayRules"
                    clearable
                    outlined
                  ></my_date_picker>
                </v-col>
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===nativeLanguage -->
                  <v-text-field
                    v-model="editedItem.nativeLanguage"
                    :rules="rules.nativeLanguageRules"
                    :label="$t(myName + '.nativeLanguage')"
                    required
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row class="my-0 py-0">
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===birthCountry -->
                  <v-combobox
                    :items="states"
                    v-model="editedItem.birthCountry"
                    :rules="rules.countryRules"
                    :label="$t(myName + '.birthCountry')"
                    prepend-inner-icon="mdi-city"
                    clearable
                    outlined
                  >
                  </v-combobox>
                </v-col>
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===birthCity -->
                  <v-text-field
                    v-model="editedItem.birthCity"
                    :rules="rules.placeRules"
                    :label="$t(myName + '.birthCity')"
                    required
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-card-text>

          </v-card>
          <!--  address card-->
          <v-card
            class="mb-2 px-0"
            elevation="10"
          >
            <v-card-title
              class="headline"
            >{{$t('address')}}
            </v-card-title>
            <v-card-text>
              <v-row class="my-0 py-0">
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===streetNr -->
                  <v-text-field
                    v-model="editedItem.streetNr"
                    :rules="rules.streetNrRules"
                    :label="$t(myName + '.streetNr')"
                    required
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===co -->
                  <v-text-field
                    v-model="editedItem.co"
                    :label="$t(myName + '.co')"
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row class="my-0 py-0">
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===postCode -->
                  <v-text-field
                    v-model="editedItem.postCode"
                    :rules="rules.postCodeRules"
                    :label="$t(myName + '.postCode')"
                    required
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===place -->
                  <v-text-field
                    v-model="editedItem.place"
                    :rules="rules.placeRules"
                    :label="$t(myName + '.place')"
                    required
                    clearable
                    outlined
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-row class="my-0 py-0">
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===country -->
                  <v-combobox
                    :items="states"
                    v-model="editedItem.country"
                    :rules="rules.countryRules"
                    :label="$t(myName + '.country')"
                    prepend-inner-icon="mdi-city"
                    outlined
                    clearable
                  ></v-combobox>
                </v-col>
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">

                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
          <!--  exam card-->
          <v-card
            class="mb-2 px-0"
            elevation="10"
          >
            <v-card-title
              class="headline"
            >{{$t(myName +'.exam')}}
            </v-card-title>
            <v-card-text>
              <v-row class="my-0 py-0">
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===examType -->
                  <v-select
                    v-model="editedItem.examType"
                    :items="formatedItemsExamType"
                    :rules="rules.examTypeRules"
                    :label="$t(myName + '.examType')"
                    @change="changeExamType"
                    required
                    clearable
                    outlined
                  >
                    <template slot="append-outer">
                      <v-menu
                        button
                        :disabled="!examDescriptionDisabled"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <mybtn
                            :disabled="!examDescriptionDisabled"
                            :bind="attrs"
                            :on="on"
                            iconname="mdi-information"
                            fab
                            small
                          ></mybtn>
                        </template>
                        <v-card>
                          <v-card-title class="headline">{{$t('TelcMember.examInfo')}}</v-card-title>
                          <v-card-text>
                            {{examDescription}}
                          </v-card-text>
                        </v-card>
                      </v-menu>
                    </template>
                  </v-select>
                </v-col>
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0" v-if="editedIndex === -1">
                  <!--===examDate -->
                  <v-select
                    v-model="editedItem.examDate"
                    :items="itemExamDate"
                    :rules="rules.examDateRules"
                    :label="$t(myName + '.examDate')"
                    @change="changeExamDate"
                    required
                    clearable
                    outlined
                  >
                    <template slot="append-outer">
                      <v-menu
                        right
                        :disabled="!examDateDescriptionDisabled"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <mybtn
                            :disabled="!examDateDescriptionDisabled"
                            :bind="attrs"
                            :on="on"
                            iconname="mdi-information"
                            small
                            fab
                          ></mybtn>
                        </template>
                        <v-card>
                          <v-card-title class="headline">{{$t('TelcMember.examDateInfo')}}</v-card-title>
                          <v-card-text>
                            <v-row no-gutters>
                              {{$t('TelcMember.dateWritingExam')}} :
                              <p class="font-weight-black">
                                {{$moment(examDateDescription.value).format('DD.MM.YYYY') }}
                              </p>
                            </v-row>
                            <v-row no-gutters>
                              {{$t('TelcMember.dateSpeakingExam')}}:
                              <p class="font-weight-black">
                                {{$moment(examDateDescription.speakingExamData).format('DD.MM.YYYY')}}
                              </p>
                            </v-row>
                            <v-row no-gutters>
                              {{$t('TelcMember.dateRegistrationDeadlineExam')}}:
                              <p class="font-weight-black">
                                {{$moment(examDateDescription.registrationDeadline).format('DD.MM.YYYY')}}
                              </p>
                            </v-row>
                            <v-row no-gutters>
                              {{$t('TelcMember.dateLastRegistrationDeadline')}}:
                              <p class="font-weight-black">
                                {{$moment(examDateDescription.lastRegistrationDeadline).format('DD.MM.YYYY')}}
                              </p>
                            </v-row>
                          </v-card-text>
                        </v-card>
                      </v-menu>
                    </template>
                  </v-select>
                </v-col>
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0" v-else>
                  <!--===examDate -->
                  <my_date_picker
                    class="mx-0 px-0"
                    v-model="editedItem.examDate"
                    :label="$t(myName + '.examDate')"
                    min="2020-01-01"
                    max="2100-01-01"
                    :futureallowed="true"
                    :rules="rules.examDateRules"
                    clearable
                    outlined
                  ></my_date_picker>
                </v-col>
              </v-row>
              <v-row class="my-0 py-0">
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===partExam -->
                  <v-checkbox
                    v-model="partExam"
                    :label="$t(myName + '.partExam')"
                    required
                  >
                  </v-checkbox>
                </v-col>
              </v-row>
              <v-card v-if="partExam">
                <v-card-text>
                  <v-row class="my-0 py-0">
                    <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                      <!--===partExam -->
                      <v-radio-group
                        v-model="editedItem.partExam"
                        :mandatory="false"
                        :rules="rules.partExamRules"
                        row
                      >
                        <v-radio :label="$t(myName + '.orally')" value="speaking"></v-radio>
                        <v-radio :label="$t(myName + '.written')" value="writing"></v-radio>
                      </v-radio-group>
                    </v-col>
                    <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                      <!--===lastMemberNr -->
                      <v-text-field
                        v-model="editedItem.lastMemberNr"
                        :label="$t(myName + '.lastMemberNr')"
                        :rules="rules.lastMemberNrRules"
                        required
                        clearable
                        outlined
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>
            </v-card-text>
          </v-card>
          <!--  others card-->
          <v-card
            class="mb-2 px-0"
            elevation="10"
          >
            <v-card-title
              class="headline"
            >{{$t(myName + '.others')}}
            </v-card-title>
            <v-card-text>
              <v-row class="my-0 py-0">
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===accommodationRequest -->
                  <v-select
                    v-model="editedItem.accommodationRequest"
                    :items="itemAccommodationRequest"
                    :label="$t(myName + '.accommodationRequest')"
                    required
                    clearable
                    outlined
                  ></v-select>
                </v-col>
                <v-col cols="12" xs="12" sm="6" class="my-0 py-0">
                  <!--===newsletterSubscribe -->
                  <v-select
                    v-model="editedItem.newsletterSubscribe"
                    :items="itemNewsletterSubscribe"
                    :label="$t(myName + '.newsletterSubscribe')"
                    required
                    clearable
                    outlined
                  ></v-select>
                </v-col>
              </v-row>

              <v-checkbox
                v-model="checkboxAGB"
                :rules="rules.checkboxAGB_Rules"
                required
              >
      <span slot="label">{{$t(myName + '.AGB1')}}
          <a href='http://www.diwan-marburg.de/allgemeine-geschaeftsbedingungen-agb/'
             onclick="window.open(this.href,'_blank', 'resizable,scrollbars').focus(); return false;">{{$t(myName + '.AGB')}}</a>
          {{$t(myName + '.AGB2')}}</span>
              </v-checkbox>
              <v-checkbox
                v-model="checkboxDSE"
                :rules="rules.checkboxDSE_Rules"
                required
              >
                        <span slot="label">{{$t(myName + '.privacyPolicy1')}}
                            <a href='http://www.diwan-marburg.de/datenschutz/'
                               onclick="window.open(this.href,'_blank', 'resizable,scrollbars').focus(); return false;">{{$t(myName +'.privacyPolicy')}}</a>
                            {{$t(myName + '.privacyPolicy2')}}</span>
              </v-checkbox>
              <v-card
                class="mb-2 px-0"
              >
                <v-card-text>
                  <v-row class="my-0 py-0">
                    <v-col cols="12" xs="12" sm="12" class="my-0 py-0">
                      <!--===captcha -->
                      <mycaptcha
                        :refresh="refreshCaptcha"
                        :rules="rules.captchaRuls"
                      ></mycaptcha>
                    </v-col>
                  </v-row>
                </v-card-text>
              </v-card>
              <v-row class="my-0 py-0">
                <v-col cols="12" xs="12" class="my-0 py-0">
                  <v-textarea
                    v-model="editedItem.description"
                    clearable
                    clear-icon="mdi-close-circle"
                    :label="$t(myName + '.description')"
                    clearable
                    outlined
                  ></v-textarea>
                </v-col>
              </v-row>

            </v-card-text>
          </v-card>
        </v-card-text>
      </v-card>
    </v-form>
    <!--      buttons-->
    <mysavebtn
      :disabled="!valid"
      @submit="submit"
      @clear="clear"
      :savetext="$t(myName + '.register')"
      :savetooltiptext="$t(myName + '.register')"
      :cleartext="$t(myName + '.reset')"
      :cleartooltiptext="$t(myName + '.reset')"
    ></mysavebtn>
    <mywarningdialog
      v-model="warningDialog"
      :text="warningText"
      @ok="warningOk"
      persistent
    ></mywarningdialog>
  </v-container>
</template>

<script>
  import {mapGetters} from 'vuex';

  export default {
    name: "TelcRegisterForm",
    components: {
      // date_picker,
    },
    data() {
      return {
        refreshCaptcha: true,
        myName: 'TelcMember',
        valid: true,
        checkboxAGB: false,
        checkboxDSE: false,
        partExam: false,
        titleItems: [
          "Prof.",
          "Dr.",
          "-",
        ],
        itemAccommodationRequest: [
          "-",
          "WG-Zimmer",
          "Einzelappartement",
          "Einzimmerwohnung",
          "Zweizimmerwohnung",
          "Dreizimmerwohnung",
        ],
        itemNewsletterSubscribe: [
          "ja",
          "nein",
          "-",
        ],

        states: [
          "Afghanistan", "Ägypten", "Albanien", "Algerien", "Andorra", "Angola", "Antarktis", "Antigua und Barbuda",
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

        warningDialog: false,
        warningMode: "ok", //ok, error
        warningText: '',
        examDescription: "",
        examDescriptionDisabled: false,
        itemExamDate: [],
        examDateDescriptionDisabled: false,
        examDateDescription: [],
      }
    },
    computed: {
      ...mapGetters({
        examTypes: "ExamType/getItems",
        examDates: "ExamDate/getItems",
        captchaEncrypt: "captcha/getCaptchaEncrypt",
        captchaCode: "captcha/getCaptchaCode",
        formActive: "language/getFormActive",

      }),

      editedIndex() {
        return this.$store.getters[`${this.myName}/getEditedIndex`]
      },

      editedItem() {
        return this.$store.getters[`${this.myName}/getEditedItem`]
      },

      rules() {
        let rules = {
          genderRules: [v => !!v || this.$t(this.myName + '.rules.genderRules')],
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
          EmailRules: [
            v => !!v || this.$t(this.myName + '.rules.EmailRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.EmailRules1'),
            v => /^[a-zA-Z0-9äöüÄÖÜß]+([.\-_]?[a-zA-Z0-9äöüÄÖÜß]+)*@[a-zA-Z0-9äöüÄÖÜß]+([.\-_]?[a-zA-Z0-9äöüÄÖÜß]+)*(\.[a-zA-Z0-9äöüÄÖÜß]{2,3})+$/.test(v) || this.$t(this.myName + '.rules.EmailRules2')
          ],
          BirthdayRules: [v => !!v || this.$t(this.myName + '.rules.BirthdayRules')],
          mobileRules: [
            v => !!v || this.$t(this.myName + '.rules.mobileRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.mobileRules1'),
            v => (/^\+?[0-9]*$/.test(v)) || this.$t(this.myName + '.rules.mobileRules3'),
            v => (v && v.length <= 20) || this.$t(this.myName + '.rules.mobileRules2'),
          ],
          streetNrRules: [
            v => !!v || this.$t(this.myName + '.rules.streetNrRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.streetNrRules1'),
            v => (v && v.length <= 70) || this.$t(this.myName + '.rules.streetNrRules2'),
            // v => /^[a-zA-ZäöüÄÖÜß]+([.-]?[a-zA-ZäöüÄÖÜß]+)*[/.,]?\s{1,3}\d{1,5}(\s{1,2})?$/.test(v) || this.$t(this.myName +'.rules.streetNrRules3'),
          ],
          postCodeRules: [
            v => !!v || this.$t(this.myName + '.rules.postCodeRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.postCodeRules1'),
            v => (v && v.length <= 10) || this.$t(this.myName + '.rules.postCodeRules2'),
          ],
          placeRules: [
            v => !!v || this.$t(this.myName + '.rules.placeRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.placeRules1'),
            v => (v && v.length <= 50) || this.$t(this.myName + '.rules.placeRules2'),
          ],
          countryRules: [
            v => !!v || this.$t(this.myName + '.rules.countryRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.countryRules1'),
            v => (v && v.length <= 50) || this.$t(this.myName + '.rules.countryRules2'),
          ],
          examDateRules: [
            v => !!v || this.$t(this.myName + '.rules.examDateRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.examDateRules1'),
            v => (v && v.length <= 10) || this.$t(this.myName + '.rules.examDateRules2'),
          ],
          nativeLanguageRules: [
            v => !!v || this.$t(this.myName + '.rules.nativeLanguageRules'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.nativeLanguageRules'),
          ],
          examTypeRules: [v => !!v || this.$t(this.myName + '.rules.examTypeRules'),],
          lastMemberNrRules: [
            v => !!v || this.$t(this.myName + '.rules.lastMemberNrRules1'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.lastMemberNrRules1'),
            v => (v && v.length <= 50) || this.$t(this.myName + '.rules.lastMemberNrRules2'),
          ],
          partExamRules: [v => !!v || this.$t(this.myName + '.rules.partExamRules'),],
          checkboxAGB_Rules: [v => !!v || this.$t(this.myName + '.rules.checkboxAGB_Rules'),],
          checkboxDSE_Rules: [v => !!v || this.$t(this.myName + '.rules.checkboxDSE_Rules'),],
          captchaRuls: [
            v => !!v || this.$t('captcha.captchaText'),
            v => !(/^\s*$/.test(v)) || this.$t(this.myName + '.rules.captchaText'),
          ],
        };
        return this.formActive
          ? rules : {};
      },

      formatedItemsExamType() {
        return this.$store.getters[`ExamType/formatedItems`];
      },

      formatedItemExamDate() {
        return this.$store.getters[`ExamDate/formatedItems`];
      },

      maxBirthday() {
        return this.$moment(new Date()).subtract(3, 'years').format('YYYY-MM-DD');
      },

    },

    created() {
      this.initialize();
    },

    methods: {
      initialize() {
        if (this.examTypes.length === 0) {
          this.$store.dispatch('ExamType/selectItems');
        }
        if (this.examDates.length === 0) {
          this.$store.dispatch('ExamDate/selectItems');
        }
      },

      clear() {
        this.$refs.form.reset();
      },

      close() {
        this.$emit("change");
      },

      submit() {
        if (this.$refs.form.validate()) {
          this.editedItem.captchaCode = this.captchaCode;
          this.editedItem.captchaEncrypt = this.captchaEncrypt;
          if (this.editedIndex >= 0) {
            this.editedItem.id = this.editedIndex;
            this.editedItem.status = 'update';
          }
          this.$store.dispatch(`${this.myName}/saveItem`, this.editedItem)
            .then(res => {
              // console.log('telc submit', res);
              if (res.data === "captchaError") {
                this.refreshCaptcha = !this.refreshCaptcha;
              } else if (res.data === "success") {
                this.warningMode = "ok";
                this.warningModeChange();
              } else {
                console.log(' log', res);
                this.warningMode = "error";
                this.warningModeChange();
              }
            })
            .catch(err => {
              console.error(err);
            });
        }
      },
      warningModeChange() {
        if (this.warningMode === "ok") {
          if (this.editedItem.id > -1) {
            this.warningText = this.$t(this.myName + '.warningDialogUpdate');
          } else {
            this.warningText = this.$t(this.myName + '.warningDialogtext');
          }
        } else {
          this.warningText = this.$t(this.myName + '.warningDialogtextErorr');
        }
        this.warningDialog = true;
      },

      warningOk() {
        if (this.warningMode === "ok") {
          if (this.editedIndex > -1) {
            this.$router.push({path: 'telcmember'})
          } else {
            location.replace('http://diwan-marburg.de');
          }
        } else {
          this.clear();
        }
      },
      changeExamType(val) {
        this.itemExamDate = [];
        if (typeof val !== 'undefined') {
          let temp = this.formatedItemsExamType.find(obj => {
            return obj.text === val
          });
          this.examDescription = temp.description;
          this.examDescriptionDisabled = true;
          for (let i = 0; i < this.formatedItemExamDate.length; i++) {
            try {
              let tmpExamType = JSON.parse(this.formatedItemExamDate[i].examTypes);
              for (let j = 0; j < tmpExamType.length; j++) {
                if (val === tmpExamType[j]) {
                  this.itemExamDate.push(this.formatedItemExamDate[i]);
                  break;
                }
              }
            } catch (e) {
              console.log(' exeption');
            }
          }

        } else {
          this.itemExamDate = [];
          this.examDescription = "";
          this.examDescriptionDisabled = false;
          this.examDateDescriptionDisabled = false;
        }
        if (this.editedIndex === -1) {
          this.editedItem.examDate = "";
        }
      },
      changeExamDate(val) {
        if (typeof val !== 'undefined') {
          this.examDateDescriptionDisabled = true;
          let temp = this.formatedItemExamDate.find(obj => {
            return obj.value === val
          });
          this.examDateDescription = temp;
        } else {
          this.examDateDescriptionDisabled = false;
        }
      },


      onPaste(evt) {
        let temp = evt.clipboardData.getData('text');

        let re = /^\+?[0-9]*$/gi;
        if (!temp.match(re)) {
          evt.preventDefault();
        }
      },

      isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 43) {
          evt.preventDefault();

        } else {
          return true;
        }
      },
    },

    watch: {
      partExam() {
        if (this.partExam === true) {
          this.editedItem.partExam = "speaking";
        } else {
          this.editedItem.partExam = "";
        }
      },

      editedIndex() {
        if (this.editedIndex === -1) {
          this.clear();
        }
      },
      // "editedItem.examDate" () {
      //   console.log(' editedItem.examDate',this.editedItem.examDate);
      // },

      // "editedItem.birthday"() {editedIndex
      //   // console.log(' birthday:',this.editedItem.birthday);
      // },

    },


  }
</script>

<style scoped>

</style>