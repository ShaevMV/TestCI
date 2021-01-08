import * as getters from './getters';
import * as actions from './actions';
import * as mutations from './mutations';

/**
 * Модуль для работы с авторизацией
 */
export default {
    namespaced: true,
    state: {
        tokenType: '',
        accessToken: '',

        dataError: {},
    },
    getters,
    actions,
    mutations
};