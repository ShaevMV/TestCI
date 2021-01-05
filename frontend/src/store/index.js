import Vue from 'vue';
import Vuex from 'vuex';
import VueAxios from 'vue-axios';
import axios from 'axios'

import * as actions from './actions';
import * as getters from './getters';
import * as mutations from './mutations';

// Модули
import appLogin from './modules/loginModule/index.js'

Vue.use(Vuex, VueAxios, axios);

const store = new Vuex.Store({
    state: {
        /**
         * @type boolean авторизация
         */
        login: false,
        /**
         * @type string Токен пользователя
         */
        token: localStorage.getItem('userToken') || '',
        /**
         * @type object <array> Список ошибок валидации
         */
        dataError: {},
    },
    mutations,
    getters,
    actions,
    modules: {
        'appLogin': appLogin,
    }
});

export default store;
