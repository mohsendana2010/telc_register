// import Vue from 'vue';

// export default Vue.extend({
//   template: `
//         <span>
//             <button style="height: 20px; line-height: 0.5" v-on:click="invokeParentMethod" class="btn btn-info">Invoke Parent</button>
//         </span>
//     `,
//   data: function () {
//     return {};
//   },
//   beforeMount() {},
//   mounted() {},
//   methods: {
//     invokeParentMethod() {
//       console.log(' test test test rtest');
//       // this.params.context.componentParent.methodFromParent(
//       //   `Row: ${this.params.node.rowIndex}, Col: ${this.params.colDef.headerName}`
//       // );
//     },
//   },
// });

// export default Vue.extend({
//   template: `
//         <span>
//             <button @click="btnClickedHandler()">Click me!</button>
//         </span>
//     `,
//   methods: {
//     btnClickedHandler() {
//       console.log(' test ag grid button');
//       this.params.clicked(this.params.value);
//     }
//   },
// });

const MedalCellRenderer = {
  template: `
       <span>
          <span>{{cellValue}}</span>
          <button @click="buttonClicked()">Push For Total</button>
       </span>
   `,
  data: function () {
    return {
      cellValue: null
    };
  },
  beforeMount() {
    // this.params contains the cell & row information and is made available to this component at creation time
    // see ICellRendererParams below for more details
    this.cellValue = this.getValueToDisplay(this.params);
  },
  methods: {
    // gets called whenever the user gets the cell to refresh
    refresh(params) {
      // set value into cell again
      this.cellValue = this.getValueToDisplay(params);
    },

    buttonClicked() {
      alert(`${this.cellValue} medals won!`)
    },

    getValueToDisplay(params) {
      return params.valueFormatted ? params.valueFormatted : params.value;
    }
  }
};

export default MedalCellRenderer;