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
 * Вывести пользовательский токен
 * @param state
 * @returns {string}
 */
export const getUserToken = state => {
    return state.tokenType + ' ' + state.accessToken;
};

/**
 * Вывести список сертификатов
 *
 * @param state
 * @returns {string}
 */
export const getListCertificats = state => {
    return state.listCertificate;
};

/**
 * Проверка на авторизацию
 *
 * @param state
 * @return {boolean}
 */
export const isAuthenticated = state => {
    return state.tokenType !=='';
};