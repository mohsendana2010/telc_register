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
                <div class="d-flex justify-end">
                  <mybtn
                    :text="$t('MyDataTable.newItem')"
                    @click="addNewItem"
                  ></mybtn>
                </div>
              </v-col>
            </v-row>
          </v-card-title>
          <v-card-text>
            <v-row>
              <!--  <examTypeTable></examTypeTable>-->
              <v-data-table
                :headers="headers"
                :items="getItems"
                sort-by="calories"
                class="elevation-1"
              >
                <template v-slot:item.actions="{ item }">
                  <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                  >
                    mdi-pencil
                  </v-icon>
                  <v-icon
                    small
                    @click="deleteItem(item)"
                  >
                    mdi-delete
                  </v-icon>
                </template>

                <template v-slot:no-data>
                  <v-btn
                    color="primary"
                    @click="initialize"
                  >
                    Reset
                  </v-btn>

                </template>
              </v-data-table>
            </v-row>
          </v-card-text>

        </v-card>
      </v-col>
    </v-row>

    <v-dialog
      v-model="dialogSave"
      max-width="700px"
    >
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
<!--          back button-->
<!--          todo back button--->
        </v-card-title>

        <v-card-text>
          <v-container>

            <slot></slot>

          </v-container>
        </v-card-text>
      </v-card>
    </v-dialog>

    <mywarningdialog
      v-model="dialogDelete"
      :text="$t('MyDataTable.warningDeleteText')"
      @cancel="close"
      @ok="deleteItemConfirm"
      cancelbutton
      :persistent="false"
    ></mywarningdialog>

  </v-container>

</template>

<script>
  import {mapGetters} from 'vuex';

  export default {
    name: "MyDataTable",
    components: {},
    data() {
      return {
        myName: this.name,
        dialogSave: false,
        dialogDelete: false,
      }
    },
    props: {
      name: {
        type: String,
        default: ""
      },
      savedata: {
        type: Boolean,
        default: false,
      },
      gotopage: {
        type: String,
        default: "",
      }
    },

    computed: {
      formTitle() {
        return this.editedIndex === -1 ? this.$t('MyDataTable.newItem') : this.$t('editItem');
      },
      ...mapGetters({
        formActive: "language/getFormActive",
      }),
      getItems() {
        return this.$store.getters[`${this.myName}/getItems`]
      },
      editedItem() {
        return this.$store.getters[`${this.myName}/getEditedItem`]
      },
      defaultItem() {
        return this.$store.getters[`${this.myName}/getDefaultItem`]
      },
      editedIndex() {
        return this.$store.getters[`${this.myName}/getEditedIndex`]
      },
      headers() {
        return this.$store.getters[`${this.myName}/getHeaders`];
      },

    },

    created() {
      this.initialize()
    },

    methods: {
      initialize() {
        if (this.getItems.length === 0) {
          this.getItemsFromServer();
        }
      },

      getItemsFromServer() {
        this.$store.dispatch(`${this.myName}/selectItems`);
        // this.$store.dispatch(`${this.myName}/fieldsItems`);
      },

      addNewItem() {
        this.close();
        this.$store.dispatch(`${this.myName}/setEditedItem`, this.defaultItem);
        if ( this.gotopage === ""){
          this.dialogSave = true
        } else {
          this.gotoPage();
        }
      },

      editItem(item) {
        this.$store.dispatch(`${this.myName}/setEditedIndex`, parseInt(item.id));
        this.$store.dispatch(`${this.myName}/setEditedItem`, item);
        console.log(' editedItem', this.editedItem);
        if ( this.gotopage === ""){
          this.dialogSave = true
        } else {
          this.gotoPage();
        }
      },

      deleteItem(item) {
        this.$store.dispatch(`${this.myName}/setEditedIndex`, parseInt(item.id));
        this.dialogDelete = true
      },

      deleteItemConfirm() {
        this.$store.dispatch(`${this.myName}/deleteItem`, this.editedIndex)
          .then(() => {
            this.refreshItems();
          })
          .catch(err => {
            console.error(err);
          });
      },

      refreshItems() {
        this.getItemsFromServer();
        this.close();
      },
      closeDialogAfterUpdate() {
        if (this.editedIndex >= 0){
          this.close();
        }
      },

      close() {
        this.dialogSave = false;
        this.dialogDelete = false;
        // this.getItems = this.$store.getters[`${this.myName}/getItems`];
        this.$nextTick(() => {
          this.$store.dispatch(`${this.myName}/setEditedItem`, this.defaultItem);
          this.$store.dispatch(`${this.myName}/setEditedIndex`, -1);
        })
      },
      gotoPage() {
        this.$router.push({path: this.gotopage})
      },
    },

    watch: {
      dialogSave(val) {
        val || this.close()
      },
      dialogDelete(val) {
        val || this.close()
      },
      savedata() {
        this.closeDialogAfterUpdate();
      },
      editedIndex() {
        console.log('edinte index in myTable:', this.editedIndex)
      },
    },

  }
</script>

<style scoped>

</style>