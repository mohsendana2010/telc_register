<template>
  <v-app>
    <v-system-bar color="deep-purple darken-3"></v-system-bar>
    <v-app-bar
      app
      color="primary"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <!--      <v-toolbar-title>My files</v-toolbar-title>-->

      <!--      <v-spacer></v-spacer>-->

      <!--      <v-btn icon>-->
      <!--        <v-icon>mdi-magnify</v-icon>-->
      <!--      </v-btn>-->

      <!--      <v-btn icon>-->
      <!--        <v-icon>mdi-filter</v-icon>-->
      <!--      </v-btn>-->

      <!--      <v-btn icon>-->
      <!--        <v-icon>mdi-dots-vertical</v-icon>-->
      <!--      </v-btn>-->

      <div class="d-flex align-center">
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

    <v-navigation-drawer
      v-model="drawer"
      absolute
      left
      temporary
    >
      <v-list
        nav
        dense
      >
        <v-list-item-group
          v-model="group"
          active-class="deep-purple--text text--accent-4"
        >
          <!--          <v-list-item>-->
          <!--            <v-list-item-title>-->
          <!--              <router-link to="/menu">menue</router-link>-->
          <!--            </v-list-item-title>-->
          <!--          </v-list-item>-->
          <v-list-item v-for=" x in toLink" :key="x.name">
            <router-link :to="x.path">{{x.name}}</router-link>
          </v-list-item>


        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>


    <v-main>
      <!--      <v-content>-->
      <v-container style="height: 100%" fluid>
        <v-row no-gutters>
          <v-col cols="12" style="height: 100%">
<!--            <transition>-->
              <router-view style="height: 90%"></router-view>
<!--            </transition>-->
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
    data: () => ({
      drawer: false,
      group: null,
      toLink: [
        {name: 'menue', path: '/menu'},
        {name: 'telcmember', path: '/telcmember'},
        {name: 'examtype', path: '/examtype'},
        {name: 'examdate', path: '/examdate'},
        {name: 'modelsViews/ExamType', path: '/modelsViews/ExamType'},
        {name: 'modelsViews/ExamDate', path: '/modelsViews/ExamDate'},
        {name: 'test/my', path: '/test/my'},
        // { name: '', path: ''},
      ],

    }),
    components: {
      LanguagePicker

    },
    methods: {
      logoClick() {
        window.location.href = 'http://diwan-marburg.de';
        // location.replace('http://diwan-marburg.de');
      },
    },

    watch: {
      group() {
        this.drawer = false
      },
    },
  };
</script>
