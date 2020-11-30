<template>
  <v-data-table
    :headers="headers"
    :items="getExamTypes"
    sort-by="calories"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>{{$t("examType")}}</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>

        <v-dialog
          v-model="dialogSave"
          max-width="500px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
              {{$t('newItem')}}
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <examTypeSave
                  @change="changesItems"
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

      </v-toolbar>


    </template>
    <template v-slot:item.actions="{ item }">
<!--      <mybtn-->
<!--      @click="editItem(item)"-->
<!--      text="test"-->
<!--      ></mybtn>-->
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

</template>

<script>
  import examTypeSave from './ExamTypeSave'
  import {mapGetters} from 'vuex';

  export default {
    name: "ExamType",
    components: {
      examTypeSave,
    },
    data: () => ({
      dialogSave: false,
      dialogDelete: false,
    }),

    computed: {
      formTitle() {
        return this.editedIndex === -1 ? this.$t('newItem') : this.$t('editItem');
      },
      ...mapGetters({
        getExamTypes: "examType/getExamTypes",
        editedItem: "examType/getEditedItem",
        defaultItem: "examType/getDefaultItem",
        editedIndex: "examType/getEditedIndex",
        headers: "examType/getHeaders",
      }),

    },

    created() {
      this.initialize()
    },

    methods: {
      initialize() {
        if (this.getExamTypes.length === 0) {
          this.getItems();
        }
      },

      getItems() {
        this.$store.dispatch('examType/selectExamType');
      },

      editItem(item) {
        this.$store.dispatch('examType/setEditedIndex', parseInt(item.id));
        this.$store.dispatch('examType/setEditedItem', item);
        this.dialogSave = true
      },

      deleteItem(item) {
        console.log('deleteItem: ' ,  item.id);
        this.$store.dispatch('examType/setEditedIndex', parseInt(item.id));
        this.dialogDelete = true
      },

      deleteItemConfirm() {
        console.log('deleteItemConfirm : ' ,  this.editedIndex);
        this.$store.dispatch('examType/deleteExamType', this.editedIndex)
          .then(res => {
            console.log('delete', res);
            this.changesItems();
          })
          .catch(err => {
            console.error(err);
          });
      },

      changesItems() {
        this.getItems();
        this.close();
      },

      close() {
        this.dialogSave = false;
        this.dialogDelete = false;
        this.$nextTick(() => {
          this.$store.dispatch('examType/setEditedItem', this.defaultItem);
          this.$store.dispatch('examType/setEditedIndex', -1);
        })
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