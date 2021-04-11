<template>
  <v-app>
    <v-app-bar
      app
      color="primary"
      dark
    >
      <div class="d-flex align-center">
<!--        <v-img-->
<!--          alt="Vuetify Logo"-->
<!--          class="shrink mr-2"-->
<!--          contain-->
<!--          src="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png"-->
<!--          transition="scale-transition"-->
<!--          width="40"-->
<!--        />-->


        <v-img
          alt="Vuetify Name"
          class="shrink mt-1 hidden-sm-and-down ma-2"
          contain
          min-width="100"
          src="./res/img/diwan marburg.jpeg"
          width="100"
          @click="logoClick"
          style="cursor: pointer"

        />

        <div
          @click="logoClick"
          style="cursor: pointer"
        >
          {{$t('logoName')}}
        </div>
      </div>


      <v-spacer></v-spacer>
      <LanguagePicker class="mr-1" style="maxWidth: 150px;"/>
    </v-app-bar>

    <v-main>
<!--      <v-content>-->
        <v-container style="height: 100%" fluid>
          <v-row no-gutters>
            <v-col cols="12" style="height: 100%">
              <router-view style="height: 90%"></router-view>
            </v-col>
          </v-row>
        </v-container>
<!--      </v-content>-->
    </v-main>

    <myalert></myalert>

    <v-footer color="primary" app>
      <span class="white--text">&copy; Diwan-Marburg Akademie GmbH</span>
    </v-footer>
  </v-app>
</template>

<script>
  import LanguagePicker from "./res/language/component/LanguagePicker";
  export default {
    name: 'App',

    components: {
      LanguagePicker
      // HelloWorld,
    },
    methods: {
      logoClick() {
        window.location.href = 'http://diwan-marburg.de';
        // location.replace('http://diwan-marburg.de');
      },
      // showAlert() {
      //   let snackbarObj = {
      //     text: "Hello, I'm a snackbar in storeasdfasdf",
      //     color: "primary",
      //     timeout: -1,
      //     alertShow: true,
      //   };
      //   this.$store.dispatch('MyAlert/setSnackbar', snackbarObj);
      // },
    },

    data: () => ({
      //
    }),
  };
</script>
