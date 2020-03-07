import VueRouter from "vue-router";

import Letter from "../modules/Letters/Letter";

const routes = [
    {
        path: '/',
        component: Letter
    },
    {
        path: '/letters/:id',
        component: Letter
    },
    // {path: '/bar', component: Bar}
];

export default routes;
