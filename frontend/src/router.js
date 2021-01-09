import VueRouter from 'vue-router';

import adminRoutes from "./router/admin.js";

const router = new VueRouter({
    mode: 'history',
    routes: [...adminRoutes],
});

export default router;
