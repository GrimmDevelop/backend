
import Home from "../modules/Home/Home";
import Letters from "../modules/Letters/Letters";
import Letter from "../modules/Letters/Letter";
import LetterEditor from "../../../../views/letters/LetterEditor";

const routes = [
    {
        path: '/',
        component: Home
    },
    {
        path: '/',
        component: Letters
    },
    {
        path: '/letters/:id',
        component: Letter
    },
    {
        path: '/editor/:id',
        component: LetterEditor
    },
    // {path: '/bar', component: Bar}
];

export default routes;
