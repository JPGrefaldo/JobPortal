# Backend Information

## Technical

- [Laravel 5.6](https://laravel.com/docs/5.6/installation)
- PHP 7.1 or greater

## DB

MySQL 5.7 will be used as the primary DB in production.

### Local

For local development it is recommended to use sqlite

#### Linux

```linux
touch database/database.sqlite
```

#### Windows

Create a new file `database/database.sqlite`

### Testing

phpUnit will use sqlite in memory.  Nothing special is required

