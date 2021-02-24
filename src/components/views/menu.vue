<template>
  <v-container>
    <v-card
      class="mb-2 px-0"
      elevation="10"
    >
      <v-card-title class="headline">
        <v-row justify="center">
          {{$t('Menu.menu')}}
        </v-row>
      </v-card-title>
      <v-card-text>
        <v-row no-gutters>
          <v-row justify="center">
            <v-col
              v-for="n in pages"
              :key="n.id"
              cols="auto"
            >
              <v-hover>
                <template v-slot:default="{ hover }">
                <v-card
                  :elevation="hover ? 24 : 6"
                  height="100"
                  width="200"
                  color="light-blue lighten-1"
                  @click="onBtnClick(n.path)"
                >
                  <v-row
                    class="fill-height"
                    align="center"
                    justify="center"
                    v-text="n.name"
                  ></v-row>
                </v-card>
                </template>
              </v-hover>
            </v-col>
          </v-row>
        </v-row>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
  import {mapGetters} from 'vuex';
  export default {
    name: "mymenu",
    data() {
      return {

      }
    },
    computed: {
      ...mapGetters({
        formActive: "language/getFormActive",
      }),
      pages() {
       let  pages = [
          {id: 1,name: this.$t('TelcMember.TelcMember'), path: "telcmember"},
          {id: 2,name: this.$t('ExamDate.ExamDate'), path: "examdate"},
          {id: 3,name: this.$t('ExamType.ExamType'), path: "examtype"},
        ];

         return this.formActive
          ? pages : [];
      },
    },
    methods:{
      onBtnClick(path) {
        console.log(' path',path);

        this.$router.push({path: path})
      },
    },
  }
</script>

<style scoped>

</style>