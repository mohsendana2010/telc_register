<template>
  <div
    @click="btnClick"
    v-bind="bind"
    v-on="on"
  >
    <v-text-field
      v-model="editedItem.password"
      :rules="rules.passwordRules"
      :label="$t(myName + '.password')"
      @keyup.enter="submit"
      :type="showPass ? 'text' : 'password'"
      :append-icon="showPass ? 'mdi-eye' : 'mdi-eye-off'"
      @click:append="showPass = !showPass"
      required
      clearable
      outlined
    ></v-text-field>

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

  </div>
</template>

<script>
  export default {
    name: "MyTextField",
    data: () => ({}),
    props: {
      bind: {},
      on: {},
      color: {
        type: String,
        default: "primary"
      },
      disabled: {
        type: Boolean,
        default: false
      },
      text: {
        type: String,
        default: ""
      },
      tooltipcolor: {
        type: String,
        default: "primary"
      },
      tooltiptext: {
        type: String,
        default: ""
      },
      iconname: {
        type: String,
        default: ''
      },
      small: {
        type: Boolean,
        default: false
      },
      fab: {
        type: Boolean,
        default: false
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
    }

  }
</script>

<style scoped>

</style>