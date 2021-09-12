<template>
  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      scrollable
      max-width="400px"
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

<!--          <v-list-item-->
<!--            ripple-->
<!--            @click="toggle"-->
<!--          >-->
<!--            <v-list-item-action>-->
<!--              <v-icon :color="checkBoxColor">-->
<!--                {{ icon }}-->
<!--              </v-icon>-->
<!--            </v-list-item-action>-->
<!--            <v-list-item-content>-->
<!--              <v-list-item-title>-->
<!--                {{dialoglabel}}-->
<!--              </v-list-item-title>-->
<!--            </v-list-item-content>-->
<!--          </v-list-item>-->
          <v-row>
            <v-col lg="2">
              {{dialoglabel}}
            </v-col>

<!--            <v-spacer></v-spacer>-->
            <v-col lg="3">
              <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                :label="$t('General.search')"
                single-line
                hide-details
                clearable
                outlined
              ></v-text-field>
            </v-col>

          </v-row>


        </v-card-title>
        <v-divider></v-divider>
        <v-card-text style="height: 300px;">

<!--          <template v-for="(item, i) in myItems">-->
<!--            <v-list-item :key="i">-->
<!--              <v-list-item-action>-->
<!--                <v-checkbox-->
<!--                  v-model="mySelectedItems"-->
<!--                  :value="item"-->
<!--                  :label="itemstext[i].text"-->
<!--                ></v-checkbox>-->
<!--              </v-list-item-action>-->
<!--            </v-list-item>-->
<!--          </template>-->

          <v-data-table
            v-model="mySelectedItems"
            :headers="headers"
            :items="myItems"
            :single-select="singleSelect"
            :search="search"
            show-select
            hide-default-footer
            class="elevation-1"
          >
          </v-data-table>



        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <mysavebtn
            :disabled="false"
            @submit="submit"
            @clear="back"
            :savetext="$t('General.save')"
            :savetooltiptext="$t('General.save')"
            :cleartext="$t('General.back')"
            :cleartooltiptext="$t('General.back')"
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
        name: 'MyCheckBoxSrollableDialog',
        dialog: false,
        testSelect: true,
        sound: false,
        myItems: this.items,
        mySelectedItems: this.selectedItems,

        search: '',
        singleSelect: false,
        headers: [
          {
            text: 'items',
            align: 'start',
            sortable: false,
            value: 'text',
          },
          // { text: 'Calories', value: 'calories' },
          // { text: 'Fat (g)', value: 'fat' },
          // { text: 'Carbs (g)', value: 'carbs' },
          // { text: 'Protein (g)', value: 'protein' },
          // { text: 'Iron (%)', value: 'iron' },
        ],
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
      itemstext() {
        let returnArry = [];
        let objectFildName = this.textfieldname === '' ? 'text' : this.textfieldname;
        returnArry = this.items.map(obj => {
          let robj = {};
          robj['text'] = obj[objectFildName];
          return robj;
        });
        return returnArry;
      },
    },

    props: {
      dialoglabel: {
        Type: String,
        // default: this.$t(this.name + '.dialoglabel'),
        default() {
          return this.$t(this.name + '.dialoglabel');
        }
      },
      btntext: {
        Type: String,
        default: 'Open Dialog'
      },
      items: {
        type: Array,
        // eslint-disable-next-line vue/require-valid-default-prop
        default: function () { return [] }
      },
      textfieldname: {
        Type: String,
        default: ''
      },
      selectedItems: {
        type: Array,
        // eslint-disable-next-line vue/require-valid-default-prop
        default() {
          return [];
        },
      },

    },

    model: {
      prop: "selectedItems",
      event: "changes"
    },
    methods: {
      openDialog() {
        this.$emit('refresh');
        this.dialog = true;
      },
      closeDialog(value) {
        this.dialog = false;
        this.$emit("changes", value);
        this.$emit("next");
      },
      back() {
        this.dialog = false;
      },
      submit() {
        this.closeDialog(this.mySelectedItems);
        //console.log('myCheckBoxSrollableDialog ' , this.mySelectedItems);
        // console.log('myCheckBoxSrollableDialog ' , this.items);
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
        console.log('myCheckBoxSrollableDialog ' , this.mySelectedItems);
      },
    },
    watch: {
      items() {
        this.myItems = this.items;
      },
      selectedItems() {
        this.mySelectedItems = this.selectedItems;
      },
    }

  }
</script>

<style scoped>

</style>