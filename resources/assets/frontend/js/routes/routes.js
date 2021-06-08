
import Home from "../modules/Home/Home";
import Letters from "../modules/Letters/Letters";
import Letter from "../modules/Letters/Letter";

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
