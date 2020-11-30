<template>
<!--  <v-container>-->
  <div   @click="btnClick"  >
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
          :icon="icon"
        >
          <div v-if="!icon">
            {{text}}
          </div>
          <div v-else>
            <v-icon :color="color" x-large>{{iconname}}</v-icon>
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
        :icon="icon"
      >
        <div v-if="!icon">
          {{text}}
        </div>
        <div v-else>
          <v-icon :color="color" x-large>{{iconname}}</v-icon>
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
      icon: {
        type: Boolean,
        default: false
      },
      iconname: {
        type: String,
        default: "primary"
      },

    },
    methods: {
      btnClick() {
        this.$emit("click");
      },
    },
  }
</script>

<style scoped>

</style>