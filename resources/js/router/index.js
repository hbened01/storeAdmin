import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
    routes: [{
            path: "/",
            component: require("./../views/dashboard/index").default,
        },
        {
            path: "/category",
            component: require("./../views/category/index").default,
        },
        {
            path: "/client",
            component: require("./../views/client/index").default,
        },
        {
            path: "/order",
            component: require("./../views/order/index").default,
        },
        {
            path: "/order-report",
            component: require("./../views/orderReport/index").default,
        },
        {
            path: "/permit",
            component: require("./../views/permit/index").default,
        },
        {
            path: "/permit/create",
            component: require("./../views/permit/create").default,
        },
        {
            path: "/permit/edit/:id",
            name: "/permit/edit",
            component: require("./../views/permit/edit").default,
            props: true,
        },
        {
            path: "/product",
            component: require("./../views/product/index").default,
        },
        {
            path: "/role",
            component: require("./../views/role/index").default,
        },
        {
            path: "/role/create",
            component: require("./../views/role/create").default,
        },
        {
            path: "/role/edit/:id",
            name: "/role/edit",
            component: require("./../views/role/edit").default,
            props: true,
        },
        {
            path: "/user",
            component: require("./../views/user/index").default,
        },
        {
            path: "/user/create",
            component: require("./../views/user/create").default,
        },
        {
            path: "/user/edit/:id",
            name: "/user/edit",
            component: require("./../views/user/edit").default,
            props: true,
        },
        {
            path: "/user/view/:id",
            name: "/user/view",
            component: require("./../views/user/view").default,
            props: true,
        },
        {
            path: "/user/permit/:id",
            name: "/user/permit",
            component: require("./../views/user/permit").default,
            props: true,
        },
    ],
    mode: 'history',
    linkActiveClass: 'active',
});