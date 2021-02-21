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
                <v-row justify="end">
                  <mybtn
                    :tooltiptext="$t('MyDataTable.newItem')"
                    iconname="mdi-plus-thick"
                    @click="addNewItem"
                  ></mybtn>
                  <mybtn
                    @click="editItem"
                    :tooltiptext="$t('MyDataTable.editItem')"
                    :disabled="btnDeleteDisabled"
                    iconname=" mdi-pencil"
                    color="green accent-3"
                  ></mybtn>
                  <mybtn
                  @click="deleteItem"
                  :tooltiptext="$t('MyDataTable.deleteItem')"
                  :disabled="btnDeleteDisabled"
                  iconname="mdi-trash-can-outline"
                  color="deep-orange accent-3"
                ></mybtn>
                </v-row>
              </v-col>
            </v-row>

          </v-card-title>
          <v-card-text>

            <v-row justify="center">
              <!--  <examTypeTable></examTypeTable>-->
              <v-col cols="12">
                <aggridvue
                  style="width: 100%; height: 500px;"
                  class="ag-theme-alpine"
                  :columnDefs="headers"
                  :rowData="getItems"
                  rowSelection="multiple"
                  @grid-ready="onGridReady"
                  :gridOptions="gridOptions"
                  :modules="modules"
                  :defaultColDef="defaultColDef"
                  @selection-changed="onSelectionChanged"
                >

<!--                  :context="context"

                  id="myGrid"
-->
                </aggridvue>
              </v-col>
            </v-row>
            <v-row justify="end">
              <mybtn
                :tooltiptext="$t('MyDataTable.newItem')"
                iconname="mdi-plus-thick"
                @click="addNewItem"
              ></mybtn>
              <mybtn
                @click="editItem"
                :tooltiptext="$t('MyDataTable.editItem')"
                :disabled="btnDeleteDisabled"
                iconname=" mdi-pencil"
                color="green accent-3"
              ></mybtn>
              <mybtn
                @click="deleteItem"
                :tooltiptext="$t('MyDataTable.deleteItem')"
                :disabled="btnDeleteDisabled"
                iconname="mdi-trash-can-outline"
                color="deep-orange accent-3"
              ></mybtn>
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

  import {AgGridVue} from '@ag-grid-community/vue';
  import {AllModules} from '@ag-grid-enterprise/all-modules'
  import '@ag-grid-community/core/dist/styles/ag-grid.css';
  import '@ag-grid-community/core/dist/styles/ag-theme-alpine.css';

  export default {
    name: "MyAgGrid",
    components: {
      aggridvue: AgGridVue,
    },
    data() {
      return {
        myName: this.name,
        dialogSave: false,
        dialogDelete: false,
        selectedItem : [],

        columnDefs: null,
        rowData: null,
        gridApi: [],
        columnApi: [],

        gridOptions: null,
        defaultColGroupDef: null,
        columnTypes: null,

        context: null,
        frameworkComponents: null,
        defaultColDef: null,
        modules: AllModules,

        btnDeleteDisabled: true,
        btnEditDisabled: true,

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
        return this.editedIndex === -1 ? this.$t('MyDataTable.newItem') : this.$t('MyDataTable.editItem');
      },
      ...mapGetters({
        formActive: "language/getFormActive",
      }),
      getItems() {
        return this.$store.getters[`${this.myName}/getItems`];
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

    beforeMount() {
      this.gridOptions = {};
      this.columnDefs = [
        {
          headerName: 'row',
          field: 'row',
          headerCheckboxSelection: true,
          headerCheckboxSelectionFilteredOnly: true,
          checkboxSelection: true,
          filter: 'agNumberColumnFilter',
          pinned: 'left',
          // suppressSizeToFit: true,

        },
        // {
        //   headerName: 'id',
        //   field: 'id',
        //   filter: 'agTextColumnFilter',
        // },
        {
          headerName: 'language',
          field: 'language',
          filter: 'agSetColumnFilter',
        },
        {
          headerName: 'subtype',
          field: 'subtype',
          filter: 'agTextColumnFilter',
        },
        {
          headerName: 'type',
          field: 'type',
          filter: 'agTextColumnFilter',
        },
        {
          headerName: 'description',
          field: 'description',
          filter: 'agTextColumnFilter',
        },
      ];

      this.context = {componentParent: this};


      this.defaultColDef = {
        editable: false,
        sortable: true,
        filter: true,
        resizable: true,
        flex: 1,
        width: 120,
        minWidth:70,
        suppressSizeToFit: false,
        filterParams: {
          buttons: ['clear', 'reset', 'apply'],
          closeOnApply: true,
        },
      };
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
        if (this.gotopage === "") {
          this.dialogSave = true
        } else {
          this.gotoPage();
        }
      },

      editItem() {
        let item = this.selectedItem[0];
        this.$store.dispatch(`${this.myName}/setEditedIndex`, parseInt(item.id));
        this.$store.dispatch(`${this.myName}/setEditedItem`, JSON.parse(JSON.stringify(item)));
        if (this.gotopage === "") {
          this.dialogSave = true
        } else {
          this.gotoPage();
        }
      },

      deleteItem() {
        let item = this.selectedItem[0];
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
        if (this.editedIndex >= 0) {
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

      onGridReady(params) {
        this.gridApi = params.api;
        this.columnApi = params.columnApi;
      },

      onSelectionChanged() {
        const selectedNodes = this.gridApi.getSelectedNodes();
        this.selectedItem = selectedNodes.map(node => node.data);
        if (this.selectedItem.length === 1){
          this.btnDeleteDisabled = false;
          this.btnEditDisabled = false;
        } else {
          this.btnDeleteDisabled = true;
          this.btnEditDisabled = true;
        }


      },

      // onCellClicked(event) {
      //   console.log('onCellClicked: ' + event.rowIndex + ' ' + event.colDef.field + ' ' + event.value);
      // },
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
      // editedIndex() {
      //   console.log('editedindex in myTable:', this.editedIndex)
      // },
      // selectedItem() {
      //   console.log(' selectedItem: ', this.selectedItem);
      // },
    },
  }

</script>

<style scoped lang="scss">

</style>

<!--https://github.com/ag-grid/ag-grid-vue-example/blob/master/src/rich-grid-example/RichGridExample.vue-->

<!--{-->
<!--headerName: 'actions',-->
<!--// children: [-->
<!--//   {headerName: "edit",field: 'id', sortable: false, resizable: true,-->
<!--//     filter: false,-->
<!--//     pinned: 'right',},-->
<!--//   {headerName: "delete",field: 'id', sortable: false, resizable: true,-->
<!--//     filter: false,-->
<!--//     pinned: 'right',},-->
<!--// ],-->

<!--field: 'id', sortable: false, resizable: true,-->
<!--filter: false,-->
<!--// cellRenderer: "mybtn1",-->

<!--cellRenderer: 'MyBtn',-->
<!--// eslint-disable-next-line no-unused-vars-->
<!--// cellRenderer: (params) => {-->
<!--// console.log(' params',params);-->
<!--// return params.value* 2;-->
<!--// },-->

<!--// cellRendererFramwork: "mybtn1",-->

<!--// cellRendererParams: {-->
<!--//   clicked: function(field) {-->
<!--//     alert(`${field} was clicked`);-->
<!--//   }-->
<!--// },-->
<!--// cellRendererSelector: function() {-->
<!--//   var moodDetails = {-->
<!--//     component: ''-->
<!--//   };-->
<!--//  return moodDetails;-->
<!--// },-->
<!--pinned: 'right',-->
<!--width: 100,-->

<!--},-->


<!--// function countryCellRenderer(params) {-->
<!--//   // let flag = "<v-icon>mdi-pencil</v-icon>";-->
<!--//   // return flag ;-->
<!--//   let value = params.value;-->
<!--//   let eDivPercentBar = document.createElement('div');-->
<!--//   eDivPercentBar.className = 'div-percent-bar';-->
<!--//   eDivPercentBar.style.width = value + '%';-->
<!--//   if (value < 20) {-->
<!--//     eDivPercentBar.style.backgroundColor = 'red';-->
<!--//   } else if (value < 60) {-->
<!--//     eDivPercentBar.style.backgroundColor = '#ff9900';-->
<!--//   } else {-->
<!--//     eDivPercentBar.style.backgroundColor = '#00A000';-->
<!--//   }-->
<!--//   let eValue = document.createElement('div');-->
<!--//   eValue.className = 'div-percent-value';-->
<!--//   eValue.innerHTML = value + '%+';-->
<!--//   let eOuterDiv = document.createElement('div');-->
<!--//   eOuterDiv.className = 'div-outer-div';-->
<!--//   eOuterDiv.appendChild(eValue);-->
<!--//   eOuterDiv.appendChild(eDivPercentBar);-->
<!--//   return eOuterDiv;-->
<!--// }-->


<!--methodFromParent(cell) {-->
<!--alert('Parent Component Method from ' + cell + '!');-->
<!--},-->