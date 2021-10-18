# How to use

## Production

-   Docker and docker-compose must be installed
-   Change `ELASTIC_HOST`, db credentials and others in .env
-   Change `docker-compose.prod.yml` and update `UID` of the user.
-   Run - `docker-compose -f docker-compose.prod.yml up -d`
-   Run these inside `app` container

```bash
docker-compose exec app composer install
# create tables
docker-compose exec app php artisan migrate
# seed the database with sample icon.json
docker-compose exec app php artisan db:seed IconSeeder
# index all icons in elasticsearch cluster
docker-compose exec app php artisan elastic:index-all
```

## Development

-   Put `ELASTIC_HOST` credentails in .env
-   Check your db credentials
-   Run `/vendor/bin/sail up`
-   Get a shell to docker container
-   Run `php artisan migrate`
-   Seed the db with sample data. Run `php artisan db:seed IconSeeder`
-   Index these data to elasticsearch. Run `php artisan elastic:index-all`

# Yo

-   [x] Model Database
-   [x] Api Authentication
-   [x] Integrate AdminLTE
-   [x] Create ElasticSearch Model
-   [x] Add observers on Icon model
-   [x] Update elastic index in observer events
-   [x] Dockerize
-   [x] Design nice UI
