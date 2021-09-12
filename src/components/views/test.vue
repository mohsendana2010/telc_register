<template>
  <v-container>
    <v-row justify="center">
      <v-col
        xs="10"
      >
        <v-card
          outlined
          class="mx-auto"
          elevation="10"
        >
          <v-card-title>
            <v-row justify='space-between'>
              <v-col>
                <v-toolbar-title>{{$t(myName + "." + myName)}}</v-toolbar-title>
              </v-col>
              <v-spacer></v-spacer>
              <v-col>

              </v-col>
            </v-row>
          </v-card-title>
          <v-card-text>
            <v-row justify="center">

              <mybtn
                @click="test"
                text="test1"
              >
              </mybtn>
              <mybtn
                @click="test2"
                text="test2"
              >
              </mybtn>

              <!--  <examTypeTable></examTypeTable>-->
              <v-col cols="12">
              </v-col>
              <v-row>
                <!--                <mycaptcha-->
                <!--                  :refresh="refreshCaptcha"-->
                <!--                ></mycaptcha>-->

                <!--      <img src="../../../server/fotos/ostern.jpg" height="564" width="696"/>-->
              </v-row>
            </v-row>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import {mapGetters} from 'vuex';
  // import PHPServer from '../../res/services/postToPHPServer';

  // const fs = require('fs');
  //
  // const someFileContents = fs.readFileSync('../views/');

  export default {
    name: "test",
    data() {
      return {
        myName: "test",
        refreshCaptcha: true,
        fotoSrc: '',
      }
    },
    computed: {
      ...mapGetters({
        formActive: "language/getFormActive",
        token: "Login/getTocken",
        myTestFormatedItems: "ExamDate/formatedItems",

      }),
    },
    // provide() {
    //   const foo = {};
    //   Object.defineProperty(foo, 'info', {
    //     enumerable: true,
    //     get: () => this.info,
    //     set(v) {
    //       this.info = v;
    //     }
    //   });
    //   return {
    //     foo,
    //   }
    // },
    methods: {
      test() {
        // console.log(' Login/getTocken',this.token);

        // const formData = new FormData();
        // formData.append('command', "test");
        // PHPServer.send(formData)
        //   .then(res => {
        //     // state.items = res.data;
        //
        //     console.log('test res: ', res);
        //   });
        this.$toast.error("I'm a toast!", {
          timeout : 5000
        });
      },
      test2() {


         // this.$store.dispatch('ExamType/test').then(res => {
         //   console.log(' temp test in testView:', res);
         // });

        // this.$store.dispatch('ExamDate/test').then(res => {
        //   console.log(' temp test in testView:', res);
        // });

          console.log(' temp test2 in testView:', this.$route.params.id);


         //let temp = this.$store.commit('ExamType/test');
        // console.log(' temp test in testView:', temp);
        // get token from adressbar of browser
        // let token = window.location.hash;
        // let mytoken = token.substr(token.search("=") + 1);
        // console.log(' test token', mytoken);

        // console.log(' href => ' + window.location.href);
        // console.log(' host => ' + window.location.host);
        // console.log(' hostname => ' + window.location.hostname);
        // console.log(' port => ' + window.location.port);
        // console.log(' protocol => ' + window.location.protocol);
        // console.log(' pathname => ' + window.location.pathname);
        // console.log(' hashpathname => ' + window.location.hash);
        // console.log(' search=> ' + window.location.search);

        // this.showAlert();
        // this.$store.dispatch('Login/loginVerify');
        // this.$store.dispatch('Login/logout');
      },

      // getImgUrl(pet,format) {
      //   var images = require.context('../../../server/fotos/', false);
      //   this.fotoSrc = images('./' + pet + '.' + format)
      // }
      showAlert() {
        let snackbarObj = {
          text: "Hello, I'm a snackbar in storeasdfasdf",
          color: "red",
          timeout: -1,
          alertShow: true,
        };
        this.$store.dispatch('MyAlert/setSnackbar', snackbarObj);
      },
    }
  }
</script>

<style scoped>

</style>