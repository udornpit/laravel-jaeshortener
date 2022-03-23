<h1 align="center"><b>JAE-Shortener</b></h1><br>


## About JAE-Shortener

A tiny/clean/limit version of Short URL application, and also a successor to JAE-ShortURL project.

## Working Time

- 2022/03/21 - Worked on running numbers algorithm in pure PHP.
- 2022/03/22 - Implemented user/admin authentication and more backend, less frontend in Laravel project.
- 2022/03/23 - Done the rest and fixed bugs along with simple frontend.

## Design Concept

- To generate running numbers instead of the random ones to preserve a unique urls included handling a lot of traffic.
- To keep urls as short as possible by creating a custom radix (106) as a reference of running numbers.

    `ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789กขฃคฅฆงจฉชซฌญฎฏฐฑฒณดตถทธนบปผฝพฟภมยรลวศษสหฬอฮ`

## New/Drop Features

- Only one table for authentication separated by a new field, "user_type".
- Remove UPDATE functionality in admin area to prevent junks pattern.
- More demonstrations on DELETE i.e. deleteByUser, deleteAll(clear&reset).
- Make routes look clean by moving things inside closure to controller.
- No additional packages are required except those coming with the command

  `composer create-project laravel/laravel example-app`

And more with experimentations.

## Install

`git clone`

## Usage

- Create database and config the `.env` file.
- Run `php artisan migrate` to create database tables.
- Run `php artisan serve` and create a new user from `register` route for admin use.
- In order to change user to admin, directly edit `user_type` field in `users` table to `1`, or by migrating.
- Create more users to do a Shorten URL.
- Have fun!

Any ploblems with `JAE-Shortener`, please feel free to let me know.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
