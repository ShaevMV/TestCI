export const setError = (state, payload) => {
    state.dataError = payload;
};


/**
 * Запись секретного токена и тип токена
 *
 * @param state
 * @param payload
 */
export const setTokenAccess = (state, payload) => {
    state.accessToken = payload.accessToken;
    state.tokenType = payload.tokenType;
};

