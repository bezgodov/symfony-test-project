# Symfony test project

This is a simple test project which main purpose is to understand PHP Framework Symfony

## Requirements

- PHP >=7.1.3
- MySQL >=5.5

### Installation

```shell
$ git clone https://github.com/bezgodov/symfony-test-project.git
$ cd symfony-test-project
$ composer install
```

Customize DB connection
Make a copy of .env and change DATABASE_URL variable

```shell
$ cp .env .env.local
$ open .env.local
```

Then install migrations

```shell
$ php bin/console doctrine:database:create
$ php bin/console doctrine:migrations:migrate
```