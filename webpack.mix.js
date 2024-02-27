const mix = require('laravel-mix');


mix
    .sass('resources/css/app.scss', 'public/css')
    .js('resources/js/anime_suggestions.js', 'public/js')