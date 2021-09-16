import Vue from "vue";
import VueRouter, { RouteConfig } from "vue-router";
import Login from "./views/Login.vue";
import App from "./views/PageApp.vue";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        name: "Login",
        component: Login,
        meta: { auth: false }
    },
    {
        path: "/app",
        name: "App",
        component: App,
        meta: { auth: true }
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

// Config authentication router
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (localStorage.getItem("token") == null) {
            next({
                path: "/login",
                params: { nextUrl: to.fullPath }
            });
        } else {
            next();
        }
    } else {
        if (!to.matched.some(record => record)) {
            next({
                path: "/",
                params: { nextUrl: to.fullPath }
            });
        } else {
            next();
        }
    }
});

export default router;
