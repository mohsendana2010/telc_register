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
                <mycaptcha
                  :refresh="refreshCaptcha"
                ></mycaptcha>

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
        token: "Login/getTocken"

      }),
    },
    methods: {
      test() {
        console.log(' Login/getTocken',this.token);

        // const formData = new FormData();
        // formData.append('command', "test" );
        // formData.append('captchaCode', this.captchaCode );
        // formData.append('captchaEncrypt',  this.captchaEncrypt );
        // PHPServer.send(formData)
        //   .then(res => {
        //     // state.items = res.data;
        //
        //     console.log('test res: ',res.data);
        //   });
      },
      test2() {
        this.$store.dispatch('Login/loginVerify');
        // const formData = new FormData();
        // formData.append('command', "loginVerify" );
        // formData.append('token', this.token );
        // PHPServer.send(formData)
        //   .then(res => {
        //     // state.items = res.data;
        //
        //     console.log('test2 res: ',res.data);
        //   });
        // console.log(' files', someFileContents);
      },
      // getImgUrl(pet,format) {
      //   var images = require.context('../../../server/fotos/', false);
      //   this.fotoSrc = images('./' + pet + '.' + format)
      // }
    }
  }
 </script>

<style scoped>

</style>