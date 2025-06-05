const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .scripts('resources/js/calender.js', 'public/js/calender.js')
    .scripts('resources/js/filamentScript.js', 'public/js/filamentScript.js')
    .js('resources/js/chartjs.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require("tailwindcss"),
    ])
    .postCss('resources/css/tw.css', 'public/css')
    .copy('resources/css/filamentStyles.css', 'public/css/filamentStyles.css')
    .copyDirectory('resources/fonts', 'public/fonts')
    .version();

