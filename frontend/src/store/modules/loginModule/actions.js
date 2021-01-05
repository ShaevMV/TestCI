import axios from 'axios';

/**
 * Авторизация пользователя, получение пользовательского токена
 *
 * @param context
 * @param payload
 */
export const loginUser = (context, payload) => {

    let params = {
        grant_type: 'password',
        client_id: process.env.VUE_APP_CLIENT_ID,
        client_secret: process.env.VUE_APP_PUSHER_APP_KEY_API,
        username: payload.username,
        password: payload.password,
        scope: '*'
    };


    let promise = axios.post(process.env.VUE_APP_URL_API + 'oauth/token', params);
    promise.then(async function (response) {
                let data = response.data;

                context.commit('setTokenAccess', {
                    tokenType: data['token_type'],
                    accessToken: data['access_token']
                });
                await localStorage.setItem('userToken', context.getters.getUserToken); // сохранение токена пользователя на стороне клиента
                await context.dispatch('initDataUser', null, {root: true});
                if (typeof payload.callback !== 'undefined'){
                    payload.callback();
                }
            })
            .catch(function (error) {
                if(error.response.status === 401 || error.response.status === 400){
                    context.commit('setError', {
                        login: 'Не удаётся войти. <br/>' +
                        'Пожалуйста, проверьте правильность написания логина и пароля.'
                    },{root: true});
                }
                if(error.response.status === 402) {
                    context.commit('setError', {
                        login: 'Для авторизации пользователя. <br/>' +
                            'Пожалуйста, подтвердите свой емайл.'
                    },{root: true});
                }

            });
};

/**
 * Регистрация пользователя
 *
 * @param context
 * @param payload
 */
export const registration = (context, payload) => {
    let params = payload.data;
    params.userType = payload.userType;
    let promise = axios.post('/api/v1/user/registration', params);
    promise.then(async function (response) {
        //let data = response.data;

        /*context.commit('setTokenAccess', {
            tokenType: data['token_type'],
            accessToken: data['access_token']
        });
        await localStorage.setItem('userToken', context.getters.getUserToken); // сохранение токена пользователя на стороне клиента
        await context.dispatch('initDataUser', null, {root: true});*/
        context.commit('setMessageModal', response.data.message,{
            root: true
        });

        if (typeof payload.callback !== 'undefined'){
            payload.callback();
        }
        //
    }).catch(function (error) {
            context.commit('setError',  error.response.data.errors,{root: true});
        });
};


/**
 * Разлогиниться
 *
 * @constructor
 */
export const logOut = () => {
    let promise = axios.get('api/v1/clearCash');
    promise.then(function () {
        localStorage.removeItem('userToken');
        localStorage.removeItem('clientToken');
        localStorage.removeItem('userData');
        window.location.replace("/");
    });

};

/**
 * Обновить данные пользователя
 *
 * @param context
 * @param payload
 */
export const updateUser = (context, payload) => {
    let promise = axios.post('/api/v1/user/updateUser', payload);

    promise.then(function (response) {
        localStorage.setItem('userData',JSON.stringify(response.data));
        context.commit('setUserData', response.data, { root: true });
        if(typeof payload.callback !== 'undefined') {
            payload.callback();
        }
    }).catch(function (error) {
        context.commit('setError', error.response.data.errors,{root: true});
    });
};


/**
 * Загрузить список уведомлений
 *
 * @param context
 */
export const loadNotification = (context) => {
    let promise = axios.get('/api/v1/user/getNotification');
    promise.then(function (response) {
        context.commit('setNotifications', response.data.notificationList, { root: true });
    })
};

/**
 * Проверить что пользователь активен
 *
 * @param context
 * @param payload
 */
export const activation = (context, payload) => {
    return axios.get(`/api/v1/user/activation/${payload.userId}/${payload.token}`);
};

/**
 * Отправить запрос на восстановления пароля
 *
 * @param context
 * @param payload
 * @return {Promise<AxiosResponse<T>>}
 */
export const getRestorePassword = (context, payload) => {
    let promise = axios.post('/api/v1/user/restorePassword', {
        email: payload.email
    });
    promise.then(function (response) {
        context.commit('setMessageModal', response.data.message,{
            root: true
        });
        if (typeof payload.callback !== 'undefined'){
            payload.callback();
        }
    }).catch(function (error) {
        context.commit('setError', error.response.data.errors,{root: true});
    })
};

/**
 * Сменить пароль и авторизовать
 *
 * @param context
 * @param payload
 */
export const changePassword = (context, payload) => {
    let promise = axios.post('/api/v1/user/changePassword', payload.data);
    promise.then(async function (response) {
        let data = response.data;

        context.commit('setTokenAccess', {
            tokenType: data['token_type'],
            accessToken: data['access_token']
        });
        await localStorage.setItem('userToken', context.getters.getUserToken); // сохранение токена пользователя на стороне клиента
        await context.dispatch('initDataUser', null, {root: true});

        if(typeof payload.callback !== 'undefined') {
            payload.callback();
        }
    }).catch(function (error) {
        context.commit('setError', error.response.data.errors,{root: true});
    })
};
