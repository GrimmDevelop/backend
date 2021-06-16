
import Home from "@/frontend/js/modules/Home/Home";
import Letters from "@/frontend/js/modules/Letters/Letters";
import Letter from "@/frontend/js/modules/Letters/Letter";

const routes = [
    {
        path: '/',
        component: Home
    },
    {
        name: 'letter-list',
        path: '/letters',
        component: Letters
    },
    {
        name: 'letter-view',
        path: '/letters/:id',
        component: Letter
    },
    // {path: '/bar', component: Bar}
];

export default routes;
