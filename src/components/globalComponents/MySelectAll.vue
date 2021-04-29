<template>
  <v-container fluid>
    <v-select
      v-model="selectedItems"
      :items="items"
      :label="label"
      :chips="chips"
      :rules="!notrules ? rules : []"
      multiple
    >
      <template v-slot:prepend-item>
        <v-list-item
          ripple
          @click="toggle"
        >
          <v-list-item-action>
            <v-icon :color="chechBoxColor">
              {{ icon }}
            </v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>
              {{$t('MySelectAll.selectAll')}}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-divider class="mt-2"></v-divider>
      </template>
      <template v-slot:append-item>
        <v-divider class="mb-2"></v-divider>
        <v-list-item disabled>
<!--          <v-list-item-avatar color="grey lighten-3">-->
<!--            <v-icon>-->
<!--              mdi-food-apple-->
<!--            </v-icon>-->
<!--          </v-list-item-avatar>-->

<!--          <v-list-item-content v-if="likesAllItems">-->
<!--            <v-list-item-title>-->
<!--              Holy smokes, someone call the fruit police!-->
<!--            </v-list-item-title>-->
<!--          </v-list-item-content>-->

<!--          <v-list-item-content v-else-if="likesSomeItems">-->
            <v-list-item-content >
            <v-list-item-title>
              {{$t('MySelectAll.itemsCount')}}
            </v-list-item-title>
            <v-list-item-subtitle>
              {{ selectedItems.length }}
            </v-list-item-subtitle>
          </v-list-item-content>

<!--          <v-list-item-content v-else>-->
<!--            <v-list-item-title>-->
<!--              How could you not like fruit?-->
<!--            </v-list-item-title>-->
<!--            <v-list-item-subtitle>-->
<!--              Go ahead, make a selection above!-->
<!--            </v-list-item-subtitle>-->
<!--          </v-list-item-content>-->
        </v-list-item>
      </template>
      <template v-slot:selection="{ item, index }" v-if="notshowall">
        <v-chip v-if="index === 0">
          <span>{{ item }}</span>
        </v-chip>
        <span
          v-if="index === 1"
          class="grey--text caption"
        >
          (+{{ selectedItems.length - 1 }} {{$t('MySelectAll.others')}})
        </span>
      </template>
    </v-select>
  </v-container>
</template>

<script>
  import {mapGetters} from 'vuex';
  export default {
    name: "MySelectAll",
    data: () => ({
      // selectedItems: this.myselecteditems,
      selectedItems: [],
      // selectedItems: this.myselecteditems,
    }),
    props:{
      myselecteditems:{
        type: Array,
        default() {
          return [];
        }
      },
      items:{
        type: Array,
        default() {
          return [];
        }
      },
      label: {
        type: String,
        default: ""
      },
      chips: {
        type: Boolean,
        default: false,
      },
      notshowall: {
        type: Boolean,
        default: false,
      },
      notrules: {
        type: Boolean,
        default: false,
      },
      rules: {
        type: Array,
        default() {
          return [v => !!v || this.$t('MySelectAll.rules.allSelect')];
        }
      },
    },

    model: {
      prop: "myselecteditems",
      event: "changes"
    },

    computed: {
      ...mapGetters({
        formActive: "language/getFormActive",

      }),
      likesAllItems() {
        return this.selectedItems.length === this.items.length
      },
      likesSomeItems() {
        return this.selectedItems.length > 0 && !this.likesAllItems
      },
      icon() {
        if (this.likesAllItems) return 'mdi-close-box';
        if (this.likesSomeItems) return 'mdi-minus-box';
        return 'mdi-checkbox-blank-outline'
      },
      chechBoxColor() {
        if (typeof this.selectedItems !== "undefined"){
          if (this.selectedItems.length > 0){
            return 'indigo darken-4';
          } else {return ''; }
        } else {return '';}
      },
    },

    created() {
      this.initialize();
    },
    methods: {
      initialize() {
        this.selectedItems = this.myselecteditems;
      },

      changeSelecteditems(value){
        this.$emit("changes", (value));
        this.$emit("next");

      },
      change() {
        this.changeSelecteditems(this.selectedItems);
      },
      toggle() {
        this.$nextTick(() => {
          if (this.likesAllItems) {
            this.selectedItems = []
          } else {
            this.selectedItems = this.items.slice()
          }
        })
      },
    },
    watch:{
      selectedItems() {
        this.changeSelecteditems(this.selectedItems);

      },
      myselecteditems() {

        // console.log('my selectitems', this.myselecteditems);
        // console.log('typeof my selectitems',typeof this.myselecteditems);
        this.selectedItems = (this.myselecteditems);

        // this.selectedItems = this.myselecteditems;

      },
    },
  }
</script>

<style scoped>

</style>