# How to use

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
-   [ ] Design nice UI
