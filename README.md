# Crew Calls

The site allows people (producer) that are creating a media project, such as tv, film, commercials, find people (crew) with specific types of skills or equipment, such as hair and makeup, sound, camera people, director, etc. to work on it.

- Project
    - [Documents](docs/project.md#documents)
    - [Contributing](docs/project.md#contributing-to-the-project)
    - [Information](docs/project.md#project-information)
- Backend
    -  [Technical](docs/backend.md#technical)
    -  [DB](docs/backend.md#db)
- Frontend
    - [Technical](docs/front-end.md#technical)
    - [Tailwind](docs/front-end.md#tailwind)
        - [Adding](docs/front-end.md#adding-css)
    - [Laravel Mix](docs/front-end.md#laravel-mix)
    - [JQuery](docs/front-end.md#jquery)
        - [Adding](docs/front-end.md#adding-jquery)
- [Laravel Packages](docs/packages.md)

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