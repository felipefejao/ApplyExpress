release: php artisan migrate --force
web: vendor/bin/heroku-php-apache2 public/
worker: php artisan queue:work --verbose --tries=3 --timeout=90
scheduler: php artisan schedule:work
