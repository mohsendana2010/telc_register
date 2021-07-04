<template>
  <v-container>
    <v-container class="fill-height" fluid>
      <v-row justify="center" class="fill-height">
        <v-col
          xs="10"
        >
          <v-card
            outlined
            height="100%"
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
              <v-row justify="space-between">
                <v-col>
                  <mybtn
                    @click="autoSizeColumns"
                    :text="btnAutSizeColumn"
                  ></mybtn>
                </v-col>
                <v-spacer></v-spacer>
                <v-col>
                  <v-row justify="end">
                    <mybtn
                      v-if="btnClearFilterShow"
                      @click="clearFilter"
                      :tooltiptext="$t('MyDataTable.clearFilter')"
                      iconname="mdi-filter-remove-outline "
                    ></mybtn>
                    <mycheckboxsrollabledialog></mycheckboxsrollabledialog>
                  </v-row>
                </v-col>
              </v-row>
              <v-row justify="center" style="height: 70vh;">
                <!--  <examTypeTable></examTypeTable>-->
                <v-col cols="12">
                  <aggridvue
                    style="width: 100%; height: 100% "
                    class="ag-theme-alpine"
                    :columnDefs="headers"
                    :rowData="getItems"
                    rowSelection="multiple"
                    @grid-ready="onGridReady"
                    :gridOptions="gridOptions"
                    :defaultColDef="defaultColDef"
                    @selection-changed="onSelectionChanged"
                    @filterChanged="onFilterChanged"
                    @cellDoubleClicked="onCellDoubleClicked"
                  >

                    <!--
                                      :context="context"
                                      :sideBar="sideBar"
                                      :rowGroupPanelShow="rowGroupPanelShow"
                                      :pivotPanelShow="pivotPanelShow"
                                      :modules="modules"
                                      id="myGrid"
                    :frameworkComponents="frameworkComponents"
                    -->
                  </aggridvue>
                </v-col>
              </v-row>
              <v-row justify="space-between">
                <v-col>
                  <v-row justify="start">
                    <mybtn
                      @click="exportToExcel"
                      :tooltiptext="$t('MyDataTable.exportToExcel')"
                      iconname="mdi-microsoft-excel"
                      :disabled="btnExportToExcelDisabled"
                    ></mybtn>

                  </v-row>
                </v-col>
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
  </v-container>
</template>

<script>
  import {mapGetters} from 'vuex';
  import helper from '../../res/js/Helper'

  // import '@ag-grid-community/all-modules/dist/styles/ag-grid.css';
  // import '@ag-grid-community/all-modules/dist/styles/ag-theme-alpine.css';
  // import { AllCommunityModules } from '@ag-grid-community/all-modules';
  // import CustomDateComponent from './customDateComponentVue.js';

  // import {AgGridVue} from '@ag-grid-community/vue';
  import {AgGridVue} from "ag-grid-vue";
  import XLSX from 'xlsx'

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
        selectedItem: [],

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

        btnDeleteDisabled: true,
        btnEditDisabled: true,
        btnExportToExcelDisabled: true,
        btnClearFilterShow: false,

        autoSizeColumnsModes: ['sizeToFit', 'autoSizeAll'],
        btnAutSizeColumn: 'sizeToFit',

        // modules: AllCommunityModules,
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
      newpage: {
        type: String,
        default: "",
      },
      updatepage: {
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
        let mydataa = this.$store.getters[`${this.myName}/getItems`];
        // console.log('MyDataTable getItems mydataa:', mydataa);
        return mydataa;
        // let tem = this.$store.getters[`${this.myName}/getItems`];
        // console.log(' rtem', tem);
        // return tem;
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
      this.gridOptions = {
        sideBar: true,
      };

      this.context = {componentParent: this};

      this.defaultColDef = {
        editable: false,
        sortable: true,
        filter: true,
        floatingFilter: true,
        resizable: true,
        flex: 1,
        width: 120,
        minWidth: 120,
        suppressSizeToFit: false,
        filterParams: {
          buttons: ['clear', 'reset', 'apply'],
          closeOnApply: true,
        },
      };

      // this.frameworkComponents = { agDateInput: CustomDateComponent };
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
        if (this.newpage === "") {
          this.dialogSave = true
        } else {
          this.gotoPage(this.newpage);
        }
      },

      editItem() {
        let item = this.selectedItem[0];
        this.$store.dispatch(`${this.myName}/setEditedIndex`, parseInt(item.id));
        this.$store.dispatch(`${this.myName}/setEditedItem`, JSON.parse(JSON.stringify(item)));
        if (this.updatepage === "") {
          this.dialogSave = true
        } else {
          this.gotoPage(this.updatepage);
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
        this.gridApi.deselectAll();
        this.onSelectionChanged();
        // this.getItems = this.$store.getters[`${this.myName}/getItems`];
        this.$nextTick(() => {
          this.$store.dispatch(`${this.myName}/setEditedItem`, this.defaultItem);
          this.$store.dispatch(`${this.myName}/setEditedIndex`, -1);
        })
      },

      gotoPage(path) {
        this.$router.push({path: path})
      },

      onGridReady(params) {
        this.gridApi = params.api;
        this.columnApi = params.columnApi;
      },

      onSelectionChanged() {
        const selectedNodes = this.gridApi.getSelectedNodes();
        // console.log('gridApi ',this.columnApi.getAllDisplayedColumns());
        this.selectedItem = selectedNodes.map(node => node.data);
        if (this.selectedItem.length === 1) {
          this.btnDeleteDisabled = false;
          this.btnEditDisabled = false;
          this.btnExportToExcelDisabled = false;
        } else if (this.selectedItem.length > 1) {
          this.btnDeleteDisabled = true;
          this.btnEditDisabled = true;
          this.btnExportToExcelDisabled = false;
        } else {
          this.btnDeleteDisabled = true;
          this.btnEditDisabled = true;
          this.btnExportToExcelDisabled = true;
        }
      },

      clearFilter() {
        this.gridOptions.api.setFilterModel(null);
        this.onFilterChanged();
      },

      exportToExcel() {
        let objToExport = this.getAllDisplayedColumns();
        // Find max Width of Columns
        const jsonKeys = Object.keys(objToExport[0]);
        let objectMaxLength = [];
        for (let i = 0; i < objToExport.length; i++) {
          let value = objToExport[i];
          for (let j = 0; j < jsonKeys.length; j++) {
            if (typeof value[jsonKeys[j]] == "number") {
              objectMaxLength[j] = 10;
            } else {
              const l = value[jsonKeys[j]] ? value[jsonKeys[j]].length : 0;
              objectMaxLength[j] =
                objectMaxLength[j] >= l
                  ? objectMaxLength[j]
                  : l;
            }
          }
          let key = jsonKeys;
          for (let j = 0; j < key.length; j++) {
            objectMaxLength[j] =
              objectMaxLength[j] >= key[j].length
                ? objectMaxLength[j]
                : key[j].length;
          }
        }
        const wscols = objectMaxLength.map(w => {
          return {width: w}
        });
        // Create a new Worksheet
        let binaryWS = XLSX.utils.json_to_sheet(objToExport);
        binaryWS['!cols'] = wscols;
        // Create a new Workbook
        let wb = XLSX.utils.book_new();
        // Name your sheet
        XLSX.utils.book_append_sheet(wb, binaryWS, this.myName);
        // export your excel
        XLSX.writeFile(wb, this.myName + this.$moment().format('YYYY-MM-DD HH-mm') + '.xlsx', {
          bookType: 'xlsx',
          type: 'buffer'
        });
      },

      onCellDoubleClicked(event) {

        console.log('test this.gridOptions ', this.gridOptions);
        this.showColumns();
        if (event.colDef.field === 'row') {
          let objToExport = this.getAllDisplayedColumns();
          helper.copyToClipboard(JSON.stringify(objToExport));
        } else {
          helper.copyToClipboard(event.value);
        }
      },

      getAllDisplayedColumns() {
        let allDisplayedColumns = this.columnApi.getAllDisplayedColumns();
        if (this.selectedItem.length > 0) {
          let objToExport = this.selectedItem.map(obj => {
            let rObj = {};
            for (let i = 0; i < allDisplayedColumns.length; i++) {
              rObj[allDisplayedColumns[i].colDef.headerName] = obj[allDisplayedColumns[i].colId];
            }
            return rObj;
          });
          return objToExport;
        } else {
          return {};
        }

      },

      onFilterChanged() {
        if (
          this.gridApi.getFilterModel() &&
          Object.keys(this.gridApi.getFilterModel()).length === 0 &&
          this.gridApi.getFilterModel().constructor === Object) {
          this.btnClearFilterShow = false;
        } else {
          this.btnClearFilterShow = true;
        }
      },

      autoSizeColumns() {
        let indexMode = this.autoSizeColumnsModes.indexOf(this.btnAutSizeColumn) + 1;
        let mode = this.autoSizeColumnsModes[indexMode % this.autoSizeColumnsModes.length];
        this.btnAutSizeColumn = mode;
        if (mode === 'sizeToFit') {
          this.gridOptions.api.sizeColumnsToFit();
        } else if (mode === 'autoSizeAll') {
          this.autoSizeAllColumns(false);
        } else {
          this.autoSizeAllColumns(true);
        }
      },

      autoSizeAllColumns(skipHeader) {
        let allColumnIds = [];
        this.gridOptions.columnApi.getAllColumns().forEach(function (column) {
          allColumnIds.push(column.colId);
        });

        this.gridOptions.columnApi.autoSizeColumns(allColumnIds, skipHeader);
      },

      showColumns() {
        console.log(' this.columnApi.getAllDisplayedColumns()',this.columnApi.getAllDisplayedColumns());
        this.gridOptions.columnApi.applyColumnState({
          state: [
            {colId: 'writingExamDate', hide: true },
          ],
        });
        console.log(' this.columnApi.getAllDisplayedColumns()',this.columnApi.getAllDisplayedColumns());

        console.log('this.gridOptions ',this.gridOptions);
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
      // editedIndex() {
      //   console.log('editedindex in myTable:', this.editedIndex)
      // },
      selectedItem() {
        // console.log(' selectedItem: ', this.selectedItem);
      },
    },
  };
</script>

<style scoped lang="scss">
  @import "../../../node_modules/ag-grid-community/dist/styles/ag-grid.css";
  @import "../../../node_modules/ag-grid-community/dist/styles/ag-theme-alpine.css";


  .custom-date-filter a {
    position: absolute;
    right: 20px;
    color: rgba(0, 0, 0, 0.54);
    cursor: pointer;
  }

  .custom-date-filter:after {
    position: absolute;
    content: '\f073';
    display: block;
    font-weight: 400;
    font-family: 'Font Awesome 5 Free';
    right: 5px;
    pointer-events: none;
    color: rgba(0, 0, 0, 0.54);
  }

  #myGrid {
    height: 100%;
  }

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