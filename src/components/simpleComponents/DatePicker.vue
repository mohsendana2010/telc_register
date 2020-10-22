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
          v-model="mydate"
          :min="min"
          :max="max"
          @change="closeDialog(mydate)"
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
        mydate: this.mydate1,
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
      notcurentdate: {
        //notcurentdate = true -> zukunft datum erlaubt eingeben
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
        this.mydate = this.mydate1;
        this.dateFormatted = this.formatDate(this.mydate1);
      },

      closeDialog(value) {
        if (this.mydate.length === 7) {
          this.mydate += "-01";
        }
        this.Dialog = false;
        // this.tempmydate = this.mydate;
        // this.mydate = value;
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
        const [year, month, day] = this.mydate.split("-");
        var days = Helper.convDate2Day(
          parseInt(year),
          parseInt(month),
          parseInt(day)
        );
        days += countday;
        this.mydate = Helper.convDay2Date(days);
        //this.dateFormatted = this.formatDate(this.mydate);
        this.checkMinMaxDate();
        //this.setMaxDateWH();
      },

      addMonth(countMonth) {
        this.mydate = Helper.addMonth2Date(this.mydate, countMonth);
        this.checkMinMaxDate();
      },

      checkMinMaxDate() {
        var currentDate = this.setCurrentDateYearMonthDayAsString();
        if (this.mydate > currentDate && !this.notcurentdate) {
          this.$eventHub.$emit("showError", this.$t("dateInFuture"));
          this.mydate = currentDate;
          //this.dateFormatted = this.formatDate(this.dateWH);
        } else if (this.mydate < this.min && this.min != "") {
          this.addDays2Date(1);
          //this.mydate = currentDate;
          //this.mydate = this.max;
        } else if (this.mydate > this.max && this.max != "") {
          this.addDays2Date(-1);
        }
        this.closeDialog(this.mydate);
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
        if (this.mydate != null || this.mydate != "") {
          var newDate = new Date(this.mydate);
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
      // mydate1() {
      //   if (this.tempmydate != this.mydate1) {
      //     this.mydate = this.mydate1;
      //   }
      // },
      mydate() {
        this.date = this.$moment(this.mydate).format("DD.MM.YYYY");
        // this.date = this.formatDate(this.mydate);
        // this.changehintMessage();
        // var currentDate = this.setCurrentDateYearMonthDayAsString();
        // if (this.mydate > currentDate && !this.notcurentdate) {
        //   // this.$eventHub.$emit("showError", this.$t("dateInFuture"));
        //   this.mydate = currentDate;
        //   //this.dateFormatted = this.formatDate(this.dateWH);
        // }
      },
      // Dialog() {
      //   if (!this.Dialog) {
      //     this.$nextTick(() => {
      //       this.$refs.textfielddata.focus();
      //     });
      //   }
      // }
    }
  };
  //@ sourceURL=datePicker.js
</script>

<style scoped>

</style>