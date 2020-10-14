<p align="center"><a href="http://hnbit.localhost" target="_blank"><img src="http://hnbit.localhost/images/hn-bit-logo.png" width="250"></a></p>

# About HN-BIT Shortened DEV links

HN-BIT Shortened DEV links is a simple URL shortener service, developed in [Laravel v8](https://laravel.com) and [Laravel Livewire v2](https://laravel-livewire.com). Users can enter a valid URL and get back a shortened version using a human readable word as a substitute for their URL.

## Specification

-   The word list used to shorten the URLs is pulled form the EFF's short wordlist.
-   A user can enter the same URLs many times, but the resulting short URL always is unique.
-   A user can enter a short (140 characters) description of their URL.
-   When a shortened URL is visited, a counter for that URL is incremented to indicate how many times the shortened link has been used.
-   The main page for the site shows a listing of the 10 most recent shortend URLs, along with their description, the original URL and the visit counts.

### Additional Specification

-   The list of the shortened URLs is paginated.
-   A user can search the listings using the private checkbox and/or the search box.
-   The search looks up the long URLs and the description, if any.

## Libaries used

-   [Laravel Livewire](https://laravel-livewire.com) for frontend, instead of Vue.js
-   [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)
-   No jetstream implemented, which means the files for authentication (inc. forgot passwort/reset password) are all done manually using livewire components.

## Installation

-   This app is a compressed archive. Unzip in a folder and then excute the next command:

```shell
composer install
```

-   Seeding words table. Currently the name of the database is 'hnbit':

```shell
php artisan db:seed
```

For the server requirements, please visit [here](https://laravel.com/docs/8.x#server-requirements)

## Configuration: .env

-   Change the value of the **APP_URL**. Currently it is http://hnbit.localhost
-   The debugbar is enabled. To set it off, set **APP_DEBUG** to false.
-   Change the name of the database (**DB_DATABASE**). Currently it is 'hnbit'.
-   Password reset email will be sent to 'laravel.log' in the storage as **MAIL_MAILER** is set as log.
-   to re-generate a key, use the next command:

```shell
php artisan key:generate
```

## Using the app

-   A user must register & login.
-   No email verification required.
-   The password must be 8-20 long.
