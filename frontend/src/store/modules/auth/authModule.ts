import axios from "axios";

import router from "@/router"; //shortcut to src
import {Module} from "vuex";
import {authInterface, tokenInterface} from "@/store/modules/auth/Interface";

// define your typings for the store state
export interface AuthState {
    loggedIn: boolean,
    loginError: null,
    token: tokenInterface,
}

const authModule: Module<any, any> = {
    namespaced: true,
    state: {
        loggedIn: false,
        loginError: null,
        username: null,
        token: {
            accessToken: '',
            typeToken: '',
        }
    },

    getters: {},

    mutations: {
        loggedIn(state: any, payload) {
            state.loggedIn = true;
            state.loginError = null;
            state.username = payload.username || "";

            router.push("/");
        },

        loggedOut(state: any) {
            state.loggedIn = false;
            router.push("/login");
        },

        loginError(state: any, payload) {
            state.loginError = payload;
        }
    },

    actions: {
        loginUser({commit, getters}, payload: authInterface) {
            axios({
                method: "post",
                url: `${process.env.VUE_APP_URL_API}api/auth/login`,
                params: {
                    email: payload.email,
                    password: payload.password
                }
            }).then(response => {
                console.log(response);
            })


        },

        async logout({dispatch, commit}) {
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
