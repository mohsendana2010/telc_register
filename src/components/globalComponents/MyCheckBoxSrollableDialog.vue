<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      scrollable
      max-width="300px"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          Open Dialog
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <v-checkbox
            v-model="sound"
          ></v-checkbox>
          {{dialogname}}
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text style="height: 300px;">

          <template v-for="(item, i) in 10">
          <v-list-item :key="i">
            <v-list-item-action>
              <v-checkbox
                v-model="sound"
                label="`Checkbox 1`"
              ></v-checkbox>
            </v-list-item-action>
<!--            <v-list-item-content>-->
<!--              <v-list-item-title>Sound</v-list-item-title>-->
<!--              <v-list-item-subtitle>Auto-update apps at any time. Data charges may apply</v-list-item-subtitle>-->
<!--            </v-list-item-content>-->
          </v-list-item>
          </template>


        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <mysavebtn
            :disabled="false"
            @submit="submit"
            @clear="back"
            :savetext="$t('save')"
            :savetooltiptext="$t('save')"
            :cleartext="$t( 'back')"
            :cleartooltiptext="$t('back')"
          ></mysavebtn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  export default {
    name: "MyCheckBoxSrollableDialog",
    data () {
      return {
        dialog: false,
        testSelect: true,
        sound: true,

      }
    },
    props:{
      dialogname:{
        Type: String,
        default: 'Select item'
      },
      // items:{
      //   type: Object,
      //   // eslint-disable-next-line vue/require-valid-default-prop
      //   default: {}
      // }
    },
    methods:{
      back() {
        this.dialog = false;
      },
      submit() {

      },
    },
  }
</script>

<style scoped>

</style>