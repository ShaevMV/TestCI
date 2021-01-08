import * as getters from './getters';
import * as actions from './actions';
import * as mutations from './mutations';

/**
 * Модуль для работы со стилями
 */
export default {
    namespaced: true,
    state: {
        /**
         * @type boolean Открытие боковое меню
         */
        openSidebar: false,
    },
    getters,
    actions,
    mutations
};
