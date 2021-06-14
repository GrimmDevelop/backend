
import Home from "@/frontend/js/modules/Home/Home";
import Letters from "@/frontend/js/modules/Letters/Letters";
import Letter from "@/frontend/js/modules/Letters/Letter";

const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/letters',
        component: Letters
    },
    {
        path: '/letters/:id',
        component: Letter
    },
    // {path: '/bar', component: Bar}
];

export default routes;
