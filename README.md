![Screenshot 2023-10-29 at 1 21 25 AM](https://github.com/nathan-langlois/whale-sightings/assets/147003300/0ce70708-b16b-4321-a211-985dc44b5e4e)

![Screenshot 2023-10-29 at 1 21 47 AM](https://github.com/nathan-langlois/whale-sightings/assets/147003300/382e5146-12b4-4559-8e4a-91e3cc641c39)

![Screenshot 2023-10-29 at 1 22 05 AM](https://github.com/nathan-langlois/whale-sightings/assets/147003300/f7d7f97f-abff-48ce-af93-44a3f81b69e2)

![Screenshot 2023-10-29 at 1 22 51 AM](https://github.com/nathan-langlois/whale-sightings/assets/147003300/a3b2e71b-20d9-4451-8688-f58c7a82f6c5)

## Setup Instructions
- setup `.env` with valid `DB_DATABASE`
- `composer install`
- `php artisan migrate:fresh`
- `php artisan shield:install --fresh` to create super-admin user
- `php artisan db:seed --class=SightingSeeder`
- After logging in as admin, make sure to update `panel-user` role with appropriate permissions

## Packages Used
- Filament 3 / Livewire 3
- Filament Breezy
- Filament Shield
- Pest 2 - run tests with `./vendor/bin/pest`
- Pint

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
