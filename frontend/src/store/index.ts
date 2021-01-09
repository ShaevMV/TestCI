import Vue from "vue";
import Vuex from "vuex";
import authModule from "@/store/modules/auth/authModule";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},
  modules: {
      authModule,
  }
});
