<template>
  <v-container fluid class="my-0 py-0">
    <v-text-field
      v-model="date"
      :label="label"
      :hint="$t('datePicker.hint')"
      :rules="!notrules ? rules : []"
      ref="textfielddata"
      @keyup.left.native="addDate(-1)"
      @keyup.right.native="addDate(1)"
      @keyup.up.native="addMonth(1)"
      @keyup.down.native="addMonth(-1)"
      @keypress="isNumber"
      :clearable="clearable"
      :outlined="outlined"
      autocomplete="off"
      prepend-inner-icon="mdi-calendar"
    >
      <template slot="append">
        <v-menu
          v-model="menu"
          :close-on-content-click="false"
          :nudge-right="40"
          transition="scale-transition"
          offset-y
          min-width="290px"
        >
          <template v-slot:activator="{ on, attrs }">
            <mybtn
            :bind="attrs"
            :on="on"
              iconname="mdi-calendar"
              small
            ></mybtn>
          </template>
          <v-date-picker
            ref="picker"
            v-model="myDate"
            :min="min"
            :max="max"
            @change="closeMenu(myDate)"
            :first-day-of-week="1"
            locale="de-de"
            :type="format"
            default="max"
          ></v-date-picker>

        </v-menu>
      </template>
    </v-text-field>
  </v-container>
</template>

<script>
  import Helper from "../../res/js/Helper.js";
  import {mapGetters} from 'vuex';

  export default {
    name: "DatePicker",
    data() {
      return {
        myDate: "",
        date: this.mydate1,
        // tempmydate: "",
        dateFormatted: "",
        colorDate: "blue darken-4",
        menu: false,
        maxDate: "",
        hintMessage: ""
      };
    },
    computed: {
      ...mapGetters({
        formActive: "language/getFormActive",

      }),
    },
    props: {
      mydate1: {
        type: String,
        default: ''
      },
      label: {
        type: String,
        default() {
          return this.$t('datePicker.date');
        }
      },
      notrules: {
        type: Boolean,
        default: false,
      },
      rules: {
        type: Array,
        default() {
          return [
            v => !!v || this.$t('datePicker.rules.date1'),
            v => !(/^\s*$/.test(v)) || this.$t('datePicker.rules.date2'),
            v => /^(0[1-9]|[12][0-9]|3[01])[- /.,](0[1-9]|1[012])[- /.,](19|20)\d\d$/.test(v) || this.$t('datePicker.rules.date2')
          ];
        }
      },
      textup: {
        type: String,
        default: ""
      },
      hidemytimefield: {
        type: Boolean,
        default: false
      },
      disabled: {
        type: Boolean,
        default: false
      },
      min: {
        type: String,
        default: ""
      },
      max: {
        type: String,
        default: ""
      },
      futureallowed: {
        //notcurentdate = true -> future date allowed to enter
        type: Boolean,
        default: false
      },
      format: {
        //date, month
        type: String,
        default: "date"
      },
      clearable: {
        type: Boolean,
        default: true
      },
      outlined: {
        type: Boolean,
        default: true
      },
    },
    model: {
      prop: "mydate1",
      event: "changes"
    },

    created() {
      this.initialize();
    },
    methods: {
      initialize() {
        this.myDate = this.mydate1;
        this.dateFormatted = this.formatDate(this.mydate1);
      },

      closeMenu(value) {
        if (this.myDate.length === 7) {
          this.myDate += "-01";
        }
        this.menu = false;
        this.$emit("changes", value);
        this.$emit("next");
      },

      addDate(count) {
        if (Math.sign(count) === 1)
        // Positive
          this.$emit("nextDate");
        else if (Math.sign(count) === -1)
        // negative
          this.$emit("prevDate");
        if (this.format === "date") {
          this.addDays2Date(count);
        } else if (this.format === "month") {
          this.addMonth(count);
        }
      },

      formatDate(date) {
        if (!date) return null;
        const [year, month, day] = date.split("-");
        if (this.format == "date") {
          return `${day}.${month}.${year}`;
        } else if (this.format == "month") {
          return `${month}.${year}`;
        }
      },

      addDays2Date(countday) {
        const [year, month, day] = this.myDate.split("-");
        var days = Helper.convDate2Day(
          parseInt(year),
          parseInt(month),
          parseInt(day)
        );
        days += countday;
        this.myDate = Helper.convDay2Date(days);
        this.checkMinMaxDate();
      },

      addMonth(countMonth) {
        this.myDate = Helper.addMonth2Date(this.myDate, countMonth);
        this.checkMinMaxDate();
      },

      checkMinMaxDate() {
        var currentDate = this.setCurrentDateYearMonthDayAsString();
        if (this.myDate > currentDate && !this.notcurentdate) {
          // this.$eventHub.$emit("showError", this.$t("dateInFuture"));
          this.myDate = currentDate;
          //this.dateFormatted = this.formatDate(this.dateWH);
        } else if (this.myDate < this.min && this.min != "") {
          this.addDays2Date(1);
        } else if (this.myDate > this.max && this.max != "") {
          this.addDays2Date(-1);
        }
        this.closeMenu(this.myDate);
      },

      setCurrentDateYearMonthDayAsString() {
        var date = new Date();
        var day = Helper.addZeroBehind10(date.getDate());
        var month = Helper.addZeroBehind10(date.getMonth() + 1);
        var year = date.getFullYear();
        return this.setDateYearMonthDayAsString(year, month, day);
      },
      setDateYearMonthDayAsString(year, month, day) {
        return year + "-" + month + "-" + day;
      },

      changehintMessage() {
        // Functioniert nicht
        if (this.myDate != null || this.myDate != "") {
          var newDate = new Date(this.myDate);
          var day = Helper.getCurrentDayOfWeek(newDate.getDay());
          var date = newDate.getDate();
          var month = Helper.getCurrentMonthName(newDate.getMonth());
          var year = newDate.getFullYear();
          if (this.format == "date") {
            this.hintMessage = day + ", " + date + " " + month + " " + year;
          } else {
            this.hintMessage = month + " " + year;
          }
        } else {
          this.hintMessage = "";
        }
      },

      isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ((charCode > 31 && (charCode < 44 || charCode > 57))) {
          evt.preventDefault();

        } else if (this.date.length >= 10) {
          evt.preventDefault();
        } else if (this.date.length === 9 && (charCode < 48 || charCode > 57)) {
          evt.preventDefault();
        } else if (this.date.length === 8 && (charCode < 48 || charCode > 57)) {
          evt.preventDefault();
        } else if (this.date.length === 7 ) {
          if (this.date[6] === '1' && (charCode < 56 || charCode > 57)) {//1800 - 1999
            evt.preventDefault();
          } else if (this.date[6] === '2' && (charCode < 48 || charCode > 49)) {// 2000 - 2199
            evt.preventDefault();
          } else if ((charCode < 48 || charCode > 57)) {
            evt.preventDefault();
          }
        } else if (this.date.length === 6 && (charCode < 49 || charCode > 50)) { // 1 - 2
          evt.preventDefault();

        } else if (this.date.length === 5 && charCode !== 46 && charCode !== 44) {
          evt.preventDefault();

        } else if (this.date.length === 4 ) {
          if (this.date[3] === '1' && (charCode < 48 || charCode > 50)) {
            evt.preventDefault();
          } else if (this.date[3] === '0' && (charCode === 48)) {
            evt.preventDefault();
          } else if ((charCode < 48 || charCode > 57)) {
            evt.preventDefault();
          }
        } else if (this.date.length === 3 && (charCode < 48 || charCode > 49)) {
          evt.preventDefault();

        } else if (this.date.length === 2 && charCode !== 46 && charCode !== 44) {
          evt.preventDefault();

        } else if (this.date.length === 1) {
          if (this.date[0] === '3' && (charCode < 48 || charCode > 49)) {
            evt.preventDefault();
          } else if (this.date[0] === '0' && (charCode === 48)) {
            evt.preventDefault();
          } else if ((charCode < 48 || charCode > 57)) {
            evt.preventDefault();
          }
        } else if (this.date.length === 0 && (charCode < 48 || charCode > 51)) {
          evt.preventDefault();
        } else {
          return true;
        }
      },
    },
    watch: {
      myDate() {
        if (this.myDate != "") {
          this.date = this.$moment(this.myDate).format("DD.MM.YYYY");
        }
      },
      mydate1() {
        this.date = this.$moment(this.mydate1).format("DD.MM.YYYY");
        this.myDate = this.mydate1;
      },
      date() {
        let re = /^(0[1-9]|[12][0-9]|3[01])[- /.,](0[1-9]|1[012])[- /.,](19|20)\d\d$/gi;
        if (typeof this.date === "string") {
          if (this.date.match(re)) {
            // this.myDate = this.$moment(this.date).format("YYYY-MM-DD")
            let year = this.date.substr(6, 4);
            let month = this.date.substr(3, 2);
            let day = this.date.substr(0, 2);
            // console.log(' date passt',this.setDateYearMonthDayAsString(year, month,day));
            this.closeMenu(this.setDateYearMonthDayAsString(year, month, day));
          } else if (this.date === "Invalid date") {
            this.date = "";
          }
        }
      },
      menu(val) {
        val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
      },
    }
  };
  //@ sourceURL=datePicker.js
</script>

<style scoped>

</style>