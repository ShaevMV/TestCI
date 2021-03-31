import axios from "axios";

import router from "@/router"; //shortcut to src
import {Module} from "vuex";
import {authInterface, tokenInterface} from "@/store/modules/auth/Interface";
import {authUserMutation} from "@/apolloClient/queries";
import {apolloClient} from "@/apolloClient";

const authModule: Module<any, any> = {
  namespaced: true,
  state: {
    loggedIn: false,
    loginError: null,
    username: null,
    token: {
      accessToken: '',
      tokenType: '',
      expiresIn: 0,
    }
  },

  getters: {
    /**
     * Вывести ошибки авторизации
     *
     * @param state
     */
    getLoginError(state: any): string | null {
      return state.loginError;
    },

    /**
     * Проверить что пользователь авторизован
     *
     * @param state
     */
    isLogin(state: any): boolean {
      return state.loggedIn;
    },
  },

  mutations: {
    /**
     * Авторизовать пользователя
     *
     * @param state
     * @param payload
     */
    loggedIn(state: any, payload: tokenInterface) {
      state.loggedIn = true;
      state.loginError = null;
      state.token = payload;

      router.push("/").catch((e: any) => {
        console.error(e);
      });
    },

    /**
     * Разлогинить пользователя
     *
     * @param state
     */
    loggedOut(state: any) {
      state.loggedIn = false;
      router.push("/").catch((e: any) => {
        console.error(e);
      });
    },

    /**
     * Ошибки авторизации
     *
     * @param state
     * @param payload
     */
    loginError(state: any, payload: string) {
      state.loginError = payload;
    }
  },

  actions: {
    loginUser({commit, getters}, payload: authInterface): void {
      apolloClient.mutate({
        mutation: authUserMutation,
        variables: {
          email: payload.email,
          password: payload.password,
        }
      }).then(r => {
        if (r.data.auth !== undefined) {
          console.log(r.data.auth);
          commit('loggedIn', r.data.auth);
        }
      }).catch(e => {
        if (e.graphQLErrors) {
          const error: string[] = [];
          e.graphQLErrors.forEach(function (item: any) {
            error.push(item.message);
          });
          commit("loginError", error.join(' '));
        }
      });
    },

    logout({dispatch, commit}) {
      axios({
        method: "post",
        url: "/auth/logout"
      })
        .then(response => {
          commit("clearNavigationState");
          commit("loggedOut");
        })
        .catch(error => {
          commit("clearNavigationState");
          commit("loggedOut");
        });
    }
  }
};

export default authModule;
