import './bootstrap';
import './icon';
import './backdrop';
import './tailwindcss';
import './timer';
import './connectionStatus';
import Cookie from './Cookie';
import Search from './Search';
import Table from './Table';
import Alpine from 'alpinejs';
import * as te from 'tw-elements';



import 'lity/dist/lity';


window.Cookie = Cookie;

window.Search = new Search();

window.Table = new Table();

window.Alpine = Alpine;

Alpine.start();





