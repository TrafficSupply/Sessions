# TrafficSupply Sessions

Ever came across the problem that you have multiple domains on laravel, but not a single shared id? Want to preserve session information like carts or information filled out in a form on all your sites? TrafficSupply Sessions is just for that!

This package for laravel gives you the opportunity to share a unique ID across multiple domains run on the same or multiple laravel installations, with one url sharing all the unique id's, for all the other domains!

To set it up simply require the package

    composer require trafficsupply/sessions

After that you can set the master domain in either your `.env` file:

    MASTER_DOMAIN=sessions.example.com

or the config, which you can publish with the following command

    php artisan vendor:publish --provider="TrafficSupply\Sessions\ServiceProvider"

## How it works

The master domain creates a unique key with the [Laravel UUID package](https://github.com/webpatser/laravel-uuid), made by Webpatser, which is saved into the session and a cookie. Each request that uses the `sessions` middleware, will have a JavaScript injected just before the head closes. This JavaScript checks if the unique ID requested from the master domain is equal to what is saved in the local session. If not, push it to the server with an XMLHttpRequest.

## ToDo
- add credentials to the XMLHttpRequest;
- posibility to reload after a new unique ID has been set;