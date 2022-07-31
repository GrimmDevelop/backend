
import Home from "@/frontend/js/modules/home/Home";
import LettersList from "@/frontend/js/modules/search/Letters";
import LettersView from "@/frontend/js/modules/Letters/display/Letter";
import LetterWindowsScan from "@/frontend/js/modules/Letters/windows/Scan";
import LetterWindowsText from "@/frontend/js/modules/Letters/windows/Text";
import CategorizedSearchResults from "../modules/search/components/CategorizedSearchResults";

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
        name: 'letters-windows-text',
        path: '/letters/:id/text',
        component: LetterWindowsText
    },
    {
        name: 'impressum',
        path: '/impressum',
        beforeEnter() {
            location.href = "http://www.grimmnetz.de/wp/impressum/";
        }
    },
    {
        name: 'characterized-search-results',
        path: "/letters/sb",
        component: CategorizedSearchResults // need to refactor search and then change this accordingly

    },
];

export default routes;
