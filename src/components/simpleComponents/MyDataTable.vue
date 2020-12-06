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
                <v-toolbar-title>{{$t(name +".examType")}}</v-toolbar-title>
              </v-col>
              <v-spacer></v-spacer>
              <v-col>
                <div class="d-flex justify-end">
                  <mybtn
                    :text="$t('newItem')"
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
      max-width="500px"
    >
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>

        <v-card-text>
          <v-container>
            <examTypeSave
              @change="refreshItems"
            ></examTypeSave>
          </v-container>
        </v-card-text>
      </v-card>
    </v-dialog>

    <mywarningdialog
      v-model="dialogDelete"
      text="Are you sure you want to delete this item?"
      @cancel="close"
      @ok="deleteItemConfirm"
      :persistent="false"
    ></mywarningdialog>

  </v-container>

</template>

<script>
  import examTypeSave from '../examType/ExamTypeSave'
  // import examTypeTable from '../examType/ExamTypeTable'
  import {mapGetters} from 'vuex';

  export default {
    name: "MyDataTable",
    components: {
      examTypeSave,
      // examTypeTable
    },
    data: () => ({
      name: "examType",
      dialogSave: false,
      dialogDelete: false,
    }),

    computed: {
      formTitle() {
        return this.editedIndex === -1 ? this.$t('newItem') : this.$t('editItem');
      },
      ...mapGetters({
        // getItems: `${this.name}/getItems`,
        // editedItem: "examType/getEditedItem",
        // defaultItem: "examType/getDefaultItem",
        // editedIndex: "examType/getEditedIndex",
        // headers: "examType/getHeaders",
      }),
      getItems() {
        return this.$store.getters[`${this.name}/getItems`]
      },
      editedItem() {
        return this.$store.getters[`${this.name}/getEditedItem`]
      },
      defaultItem() {
        return this.$store.getters[`${this.name}/getDefaultItem`]
      },
      editedIndex() {
        return this.$store.getters[`${this.name}/getEditedIndex`]
      },
      headers() {
        return this.$store.getters[`${this.name}/getHeaders`]
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
        this.$store.dispatch(`${this.name}/selectItems`);
      },

      addNewItem() {
        this.dialogSave = true
        // this.close();
        // this.gotoSaveItem();
      },

      editItem(item) {
        this.$store.dispatch(`${this.name}/setEditedIndex`, parseInt(item.id));
        this.$store.dispatch(`${this.name}/setEditedItem`, item);
        // this.gotoSaveItem();
        this.dialogSave = true
      },

      deleteItem(item) {
        this.$store.dispatch(`${this.name}/setEditedIndex`, parseInt(item.id));
        this.dialogDelete = true
      },

      deleteItemConfirm() {
        this.$store.dispatch(`${this.name}/deleteItem`, this.editedIndex)
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

      close() {
        this.dialogSave = false;
        this.dialogDelete = false;
        this.$nextTick(() => {
          this.$store.dispatch(`${this.name}/setEditedItem`, this.defaultItem);
          this.$store.dispatch(`${this.name}/setEditedIndex`, -1);
        })
      },
      gotoSaveItem() {
        this.$router.push({path: 'examtypesave'})
      },
    },

    watch: {
      dialogSave(val) {
        val || this.close()
      },
      dialogDelete(val) {
        val || this.close()
      },
    },

  }
</script>

<style scoped>

</style>