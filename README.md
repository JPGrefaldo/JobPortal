# Crew Calls

The site allows people (producer) that are creating a media project, such as tv, film, commercials, find people (crew) with specific types of skills or equipment, such as hair and makeup, sound, camera people, director, etc. to work on it.

- Project
    - [Documentation](docs/project.md#documents)
    - [Contributing to the project](docs/project.md#contributing-to-the-project)
- Frontend Development
    - [Framework](docs/front-end.md#framework)
    - [Compile](docs/front-end.md#compile)
    - [Javascript](docs/front-end.md#javascript)
- Laravel Packages

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