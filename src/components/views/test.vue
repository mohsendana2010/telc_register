<template>
  <v-container>
    <v-row>
      <mybtn
        @click="test"
        text="test"
      >
      </mybtn>
    </v-row>
    <v-row>
      <v-img
        contain
      max-height="564"
      max-width="696"
      :src="fotoSrc"
    ></v-img>

<!--      <img src="../../../server/fotos/ostern.jpg" height="564" width="696"/>-->
    </v-row>


  </v-container>
</template>

<script>
  import PHPServer from '../../res/services/postToPHPServer';
  export default {
    name: "test",
    data() {
      return {
        fotoSrc: '',
      }
    },
    methods: {
      test() {
        const formData = new FormData();
        formData.append('command', "test" );
        PHPServer.send(formData)
          .then(res => {
            // state.items = res.data;

            console.log('test res: ',res.data);
            // this.getImgUrl("Sketch","png");
            this.fotoSrc = res.data;
          });
      },
      getImgUrl(pet,format) {
        var images = require.context('../../../server/fotos/', false);
        this.fotoSrc = images('./' + pet + '.' + format)
      }
    }
  }
 </script>

<style scoped>

</style>