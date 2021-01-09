import Vue from 'vue';

import Root from '../components/Root.vue';
import FestivalList from '../components/festival/List.vue';
import PageNotFound from '../components/error/PageNotFound.vue';

Vue.component('Root', Root);

const ADMIN_ROLE = 1;

let routes = [
    // главной страницы
    {
        path: '/',
        component: Root,
        name: 'root',
        meta: {
            requiresAuth: true,
            role_id: [ADMIN_ROLE]
        }
    },
    // список фестивалей
    {
        path: '/festival',
        component: FestivalList,
        name: 'FestivalList',
        meta: {
            requiresAuth: true,
            role_id: [ADMIN_ROLE]
        }
    },
    { path: "*", component: PageNotFound }
];

export default routes;
