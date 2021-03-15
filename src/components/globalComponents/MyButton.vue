<template>
<!--  <v-container>-->
  <div
    @click="btnClick"
    v-bind="bind"
    v-on="on"
    style="cursor: pointer; "
  >
    <div v-if="tooltiptext !== ''">
    <v-tooltip
      bottom
      :color="tooltipcolor"
    >
      <template slot="activator" slot-scope="{ on }">
        <v-btn
          v-on="on"
          :disabled="disabled"
          :color="color"
          :icon="iconname !== ''"
          :small="small"
          :fab = "fab"
        >
          <div v-if="iconname === ''">
            {{text}}
          </div>
          <div v-else>
            <v-icon :color="color" large>{{iconname}}</v-icon>
          </div>
        </v-btn>

      </template>
      <span class="black--text" >{{tooltiptext}}</span>
    </v-tooltip>
    </div>
    <div v-if="tooltiptext === ''">
      <v-btn
        :disabled="disabled"
        :color="color"
        :icon="iconname !== ''"
        :small="small"
        :fab = "fab"
      >
        <div v-if="iconname === ''">
          {{text}}
        </div>
        <div v-else>
          <v-icon :color="color" large>{{iconname}}</v-icon>
        </div>
      </v-btn>
    </div>
  </div>
<!--  </v-container>-->
</template>

<script>
  export default {
    name: "MyButton",
    data: () => ({}),

    props: {
      bind: {},
      on: {},
      color: {
        type: String,
        default: "primary"
      },
      disabled: {
        type: Boolean,
        default: false
      },
      text: {
        type: String,
        default: ""
      },
      tooltipcolor: {
        type: String,
        default: "primary"
      },
      tooltiptext: {
        type: String,
        default: ""
      },
      iconname: {
        type: String,
        default: ''
      },
      small: {
        type: Boolean,
        default: false
      },
      fab: {
        type: Boolean,
        default: false
      },

    },
    // dependencies : ['Helperr'],
    methods: {
      btnClick() {
        if (!this.disabled) {
          this.$emit("click");
          // this.Helperr.testt();
        }
      },
    },
  }
</script>

<style scoped>

</style>