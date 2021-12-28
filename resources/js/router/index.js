import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
  routes: [
    {
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
      path: "/product",
      component: require("./../views/product/index").default,
    },
    {
      path: "/rol",
      component: require("./../views/rol/index").default,
    },
    {
      path: "/user",
      component: require("./../views/user/index").default,
    },
    {
      path: "/user/create",
      component: require("./../views/user/create").default,
    },
  ],
  mode: 'history',
  linkExactActiveClass: 'active',
});
