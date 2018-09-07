# Crew Calls

The site allows people (producer) that are creating a media project, such as tv, film, commercials, find people (crew) with specific types of skills or equipment, such as hair and makeup, sound, camera people, director, etc. to work on it.

## Contributing to the project
* [Developers Guide](https://github.com/cca-bheath/crewcalls/wiki/Developers-Guide)

## Create test user

Create a confirmed test user on site that is Crew and Producer.

Password `test123`

```php
php artisan test_user test@test.com
```

## Restart from scratch

* Migrate
* Seed
* Create new test user

```php
php artisan startfromscratch test@test.com
```

## Front

### Framework

Using [tailwind css](https://tailwindcss.com/docs/installation/) as the CSS
framework

### Compile

```bash
npm install
```

```bash
npm run dev

//OR

npm run production
```

## JS

- JQuery v3
- [Tooltipster](http://iamceege.github.io/tooltipster/#demos)
- [Slick Carousel](http://kenwheeler.github.io/slick/)

## Laravel Packages

Added packages

### Open On Make

https://github.com/ahuggins/open-on-make

### Laravel ER Diagram Generator

https://github.com/beyondcode/laravel-er-diagram-generator

### Laravel N+1 Query Detector

https://github.com/beyondcode/laravel-query-detector

### Laravel Dump Server

https://github.com/beyondcode/laravel-dump-server

### Xray

https://github.com/beyondcode/laravel-view-xray

### Laravel Collection Macros

https://github.com/spatie/laravel-collection-macros
