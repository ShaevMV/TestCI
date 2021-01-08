import store from './store/index';
import Vue from 'vue';
import App from './App.vue';
import $ from 'jquery'
import VueRouter from 'vue-router';

Vue.config.productionTip = false

/**
 * @type {(function(*=): *)|Window.jQuery|HTMLElement}
 */
window.jQuery = $;

/**
 * @type {Vue | CombinedVueInstance<Vue, object, object, object, Record<never, any>>}
 */
window.eventBus = new Vue(); // события
/**
 * @type {Vue | VueConstructor}
 */
window.Vue = Vue;
/**
 * @type {Store<unknown>}
 */
window.store = store;
window.Vue.use(VueRouter);

new Vue({
    store,
    render: h => h(App),
}).$mount('#app')