<template>
  <v-app>
    <v-app-bar
      app
      color="primary"
      dark
    >
      <div class="d-flex align-center">
        <v-img
          alt="Vuetify Logo"
          class="shrink mr-2"
          contain
          src="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png"
          transition="scale-transition"
          width="40"
        />

        <v-img
          alt="Vuetify Name"
          class="shrink mt-1 hidden-sm-and-down"
          contain
          min-width="100"
          src="https://cdn.vuetifyjs.com/images/logos/vuetify-name-dark.png"
          width="100"
        />
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

    <v-footer color="blue darken-4" app>
      <span class="white--text">&copy; Diwan Akademi GmbH 2020</span>
    </v-footer>
  </v-app>
</template>

<script>
  import LanguagePicker from "./components/simpleComponents/LanguagePicker";
  export default {
    name: 'App',

    components: {
      LanguagePicker
      // HelloWorld,
    },

    data: () => ({
      //
    }),
  };
</script>
