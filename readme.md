# Book Planet

<p align="center"> <img src="https://github.com/Monika171/Book-Planet/blob/assignment01/src/public/images/book-planet.png" width=750> </p>

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

<p align="center"> <img src="https://github.com/Monika171/Book-Planet/blob/assignment01/src/public/images/book_planet_test_output.png" width=750> </p>

## Deployment

### Hosting over [InfinityFree](https://www.infinityfree.com/)

1. Sign up or Log in.

1. Navigate to account section called `Hosting Accounts`, and `Create Account` where <i>subdomain</i> and <i>domain extension</i> will be registered based on availability.

1. Click on account created and go to the `Control Panel`. Approve and proceed.

1. In `DATABASES` click on `MySQL Databases` and create a database.

1. [Download](https://filezilla-project.org/download.php) and open FileZilla (from `Free FTP Software` in cpanel).

   - Inside the application, go to `File` and create a `New site` from `Site Manager` with cpanel account FTP HostName, Port `21`, FTP Username, Logon Type `Normal` and FTP Password.
     - <i>Please reset FTP password in case it doesn’t work the first time.</i>

1. After successful connection, directory `/` should appear, which has `htdocs` inside it.

1. Inside htdocs, create a new directory (for example say: `laravel`)

1. Go to the laravel project to be deployed on the left.

1. Upload the contents of the `public` directory of the project to `htdocs` on the right and rest of the contents except 'public' (and '.git' if exists) directory to that new directory which was created in step 7 (‘`laravel`’ in this example)

1. Once uploaded, go to `control panel` again from step 3.

1. Click on `Online File Manager` in FILES and then `htdocs`. Edit and update the paths in `index.php` file for new folder name (for example here `laravel`)  
   Example below:  
   <u>Before</u>:

   ```
   __DIR__.'/../storage/framework/maintenance.php'
   ```

   <u>After</u>:

   ```
   __DIR__.'/laravel/storage/framework/maintenance.php'
   ```

1. Delete `config.php` (if exists) from `/htdocs/laravel/bootstrap/cache`

1. Update contents of `.env` file inside `/htdocs/laravel` with the right data for db host, port, database name, username and password which were created earlier.

1. From local environment database `export` all tables.

1. In cpanel, go to `MySQL Databases` in DATABASES again and click on `Admin`. Click on `Import` from top toolbar and select the exported file from the previous step.

1. The laravel project should work now.

## App Info

### Built With

- [Laravel Framework 6.18.0](https://laravel.com/docs/6.x/releases)
- [Tailwind CSS](https://tailwindcss.com/docs/installation/play-cdn)

### Version

1.0.0

### Author

Monika Rabha
