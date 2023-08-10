# Book Planet

A catalogue where all the book information can be seen and can be also exported as CSV and XML. There is a search box for quicker access and the list can also be sorted. One can even add a new book information (title & author), update the same if required and delete book info.

## Getting Started

### Prerequisites

- [Docker](https://docs.docker.com/install)
- [Docker Compose](https://docs.docker.com/compose/install)

### Setup

1. Clone the repository.
1. Start the containers by running `docker-compose up -d` in the project root.
1. Install the composer packages by running `docker-compose exec laravel composer install`.
1. Access the Laravel instance on `http://localhost` (If there is a "Permission denied" error, run `docker-compose exec laravel chown -R www-data storage`).

Note that the changes you make to local files will be automatically reflected in the container.

### Persistent database

If you want to make sure that the data in the database persists even if the database container is deleted, add a file named `docker-compose.override.yml` in the project root with the following contents.

```
version: "3.7"

services:
  mysql:
    volumes:
    - mysql:/var/lib/mysql

volumes:
  mysql:
```

Then run the following.

```
docker-compose stop \
  && docker-compose rm -f mysql \
  && docker-compose up -d
```

## Usage

### Database Setup

This app uses MySQL.

### Migrations

1. To access the running container (in this case “assignment01-laravel”), in the project root, run:

```
docker exec -it assignment01-laravel bash
```

2. To create all the necessary tables and columns, run the following

```
php artisan migrate
```

### Seeding The Database

To add the dummy titles and author, run:

```
php artisan db:seed
```

## Running the tests

1. To access the running container (in this case “`assignment01-laravel`”), in the project root, run:

```
docker exec -it assignment01-laravel bash
```

2. Always clear configuration cache before running tests:

```
php artisan config:clear
```

3. Run PHPUnit tests by:

```
./vendor/bin/phpunit
```

This should look like the image below:
Todo

## Deployment

Todo

## Built With

- [Laravel Framework 6.18.0](https://laravel.com/docs/6.x/releases)
- [Tailwind CSS](https://tailwindcss.com/docs/installation/play-cdn)
