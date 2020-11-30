<template>
  <v-container>
    <v-menu
      v-model="Dialog"
      :close-on-content-click="false"
      :nudge-right="40"
      transition="scale-transition"
      offset-y
      min-width="290px"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-text-field
          class="my-0 py-0"
          v-model="date"
          :label="label"
          :rules="rules"
          readonly
          v-bind="attrs"
          v-on="on"
          ref="textfielddata"
          @keyup.left.native="addDate(-1)"
          @keyup.right.native="addDate(1)"
          @keyup.up.native="addMonth(1)"
          @keyup.down.native="addMonth(-1)"
        >
          <template slot="prepend-inner">
            <v-icon
              v-on="on"
              :color="!disabled ? colorDate : ''"
            >mdi-calendar
            </v-icon>
          </template>
        </v-text-field>
      </template>
      <v-date-picker
        v-model="myDate"
        :min="min"
        :max="max"
        @change="closeDialog(myDate)"
        :first-day-of-week="1"
        locale="de-de"
        :type="format"
        default="max"
      ></v-date-picker>
    </v-menu>
  </v-container>
</template>

<script>
  import Helper from "../../res/js/Helper.js";

  export default {
    name: "DatePicker",
    data() {
      return {
        date: "",
        myDate: this.mydate1,
        // tempmydate: "",
        dateFormatted: "",
        colorDate: "blue darken-4",
        Dialog: false,
        maxDate: "",
        hintMessage: ""
      };
    },
    props: {
      mydate1: {
        type: String,
        default: ""
      },
      label: {
        type: String,
        default: ""
      },
      rules: {
        // type: Array,
        // default: []
        type: Array,
        default() {
          return [];
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
      }
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
        //this.max = this.maxDate
        this.myDate = this.mydate1;
        this.dateFormatted = this.formatDate(this.mydate1);
      },

      closeDialog(value) {
        if (this.myDate.length === 7) {
          this.myDate += "-01";
        }
        this.Dialog = false;
        this.$emit("changes", value);
        this.$emit("next");
      },

      addDate(count) {
        if (Math.sign(count) == 1)
        // Positive
          this.$emit("nextDate");
        else if (Math.sign(count) == -1)
        // negative
          this.$emit("prevDate");
        if (this.format == "date") {
          this.addDays2Date(count);
        } else if (this.format == "month") {
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
          this.$eventHub.$emit("showError", this.$t("dateInFuture"));
          this.myDate = currentDate;
          //this.dateFormatted = this.formatDate(this.dateWH);
        } else if (this.myDate < this.min && this.min != "") {
          this.addDays2Date(1);
        } else if (this.myDate > this.max && this.max != "") {
          this.addDays2Date(-1);
        }
        this.closeDialog(this.myDate);
      },

      setCurrentDateYearMonthDayAsString() {
        var date = new Date();
        var day = Helper.addZeroBehind10(date.getDate());
        var month = Helper.addZeroBehind10(date.getMonth() + 1);
        var year = date.getFullYear();
        var currentDate = year + "-" + month + "-" + day;
        return currentDate;
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
      }
    },
    watch: {
      myDate() {
        this.date = this.$moment(this.myDate).format("DD.MM.YYYY");
      },
    }
  };
  //@ sourceURL=datePicker.js
</script>

<style scoped>

</style>