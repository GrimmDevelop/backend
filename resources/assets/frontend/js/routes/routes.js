
import Home from "@/frontend/js/modules/Home/Home";
import LettersList from "@/frontend/js/modules/Letters/Letters";
import LettersView from "@/frontend/js/modules/Letters/Letter";
import LetterWindowsScan from "@/frontend/js/modules/Letters/Windows/Scan";
import SearchForm from "../components/ui/search/SearchForm";

const routes = [
    {
        path: '/',
        component: Home
    },
    {
        name: 'letters-list',
        path: '/letters',
        component: LettersList
    },
    {
        name: 'letters-view',
        path: '/letters/:id',
        component: LettersView
    },
    {
        name: 'letters-windows-scan',
        path: '/letters/:id/scan',
        component: LetterWindowsScan
    },
    {
        name: 'search-view',
        path: '/lettersearch',
        component: SearchForm
    },
];

export default routes;
