import Modules  from "./cls_modules";

class TileModule
{
  constructor(myName,myTableName){
    this.modules = new Modules(myName, myTableName);
    this.state = this.modules.myState();
    this.getters = this.modules.myGetters();
    this.actions =  this.modules.myActions(this.state);
    this.mutations = this.modules.myMutation(this.state);
    return {
      namespaced: true,
      state : this.state,
      getters : this.getters,
      actions : this.actions,
      mutations : this.mutations,
    }
  }

}
// export const myTileModule = tileModule;

export default TileModule;