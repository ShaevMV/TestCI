export const getError = state => type => {
    if(state.dataError !== undefined && state.dataError[type] !== undefined){
        if(typeof state.dataError[type] === "object"){
            return state.dataError[type][0];
        }
        return state.dataError[type];
    }
    return '';
};

/**
 * Проверка того, что пользователь авторизован
 *
 * @return {boolean}
 */
export const isAuthenticated = () => {
    return !!localStorage['userToken'];
};

