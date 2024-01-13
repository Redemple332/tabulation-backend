FROM richarvey/nginx-php-fpm:latest

COPY . .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_KEY base64:Fu6lOrU7wx2kGSCWae2Lth4aVFiRC60pLhRupoK7PpY=
ENV APP_ENV production
ENV APP_DEBUG true

ENV DB_CONNECTION pgsql
ENV DB_HOST dpg-clb3skunt67s73f8ll5g-a
ENV DB_PORT 5432
ENV DB_DATABASE ecom_server
ENV DB_USERNAME root
ENV DB_PASSWORD 2NpFHxqNJBL4YmEeP8K0qEFT8r1Tfyh8

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]
