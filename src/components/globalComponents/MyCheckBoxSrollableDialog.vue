<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      scrollable
      max-width="300px"
    >
      <template v-slot:activator="{}">
        <mybtn
          :text="btntext"
          :tooltiptext="btntext"
          @click="openDialog"
        ></mybtn>
      </template>
      <v-card>
        <v-card-title>
          <v-list-item
            ripple
            @click="toggle"
          >
            <v-list-item-action>
              <v-icon :color="checkBoxColor">
                {{ icon }}
              </v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title><mybtn
                text="test"
                tooltiptext="test"
                @click="test"
              ></mybtn>
                {{dialogname}}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <!--          <v-checkbox-->
          <!--            v-model="sound"-->
          <!--          ></v-checkbox>-->
          <!--          {{dialogname}}-->
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text style="height: 300px;">

          <template v-for="(item, i) in myItems">
            <v-list-item :key="i">
              <v-list-item-action>
                <v-checkbox
                  v-model="item.checked"
                  :label="item.text"
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
    data() {
      return {
        dialog: false,
        testSelect: true,
        sound: false,
        myItems: this.items,
        mySelectedItems: this.selectedItems,

      }
    },
    computed: {
      // ...mapGetters({
      //   formActive: "language/getFormActive",
      //
      // }),
      likesAllItems() {
        return this.mySelectedItems.length === this.myItems.length
      },
      likesSomeItems() {
        return this.mySelectedItems.length > 0 && !this.likesAllItems
      },
      icon() {
        if (this.likesAllItems) return 'mdi-close-box';
        if (this.likesSomeItems) return 'mdi-minus-box';
        return 'mdi-checkbox-blank-outline'
      },
      checkBoxColor() {
        if (typeof this.mySelectedItems !== "undefined") {
          if (this.mySelectedItems.length > 0) {
            return 'indigo darken-4';
          } else {
            return '';
          }
        } else {
          return '';
        }
      },
    },
    props: {
      dialogname: {
        Type: String,
        default: 'Select item',
      },
      btntext: {
        Type: String,
        default: 'Open Dialog'
      },
      items: {
        type: Array,
        // eslint-disable-next-line vue/require-valid-default-prop
        default: []
      },
      selectedItems: {
        type: Array,
        // eslint-disable-next-line vue/require-valid-default-prop
        default() {
          return [];
        },
      },

    },
    methods: {
      openDialog() {
        this.dialog = true;
      },
      back() {
        this.dialog = false;
      },
      submit() {

      },

      toggle() {
        this.$nextTick(() => {
          if (this.likesAllItems) {
            this.mySelectedItems = []
          } else {
            this.mySelectedItems = this.myItems.slice()
          }
        })
      },

      test() {
        console.log('myCheckBoxSrollableDialog ' , this.myItems);
      },
    },

  }
</script>

<style scoped>

</style>