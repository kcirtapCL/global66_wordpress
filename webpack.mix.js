const mix = require("laravel-mix");

mix.postCss(
    "css/main.css",
    "style.css",
    [
        require("tailwindcss"),
        require("postcss-nested")
    ]
).options({
    processCssUrls: false
});