FROM richarvey/nginx-php-fpm:latest

COPY . .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1


ENV APP_URL=https://tabulation-backend.onrender.com
# Laravel config
ENV APP_KEY base64:Fu6lOrU7wx2kGSCWae2Lth4aVFiRC60pLhRupoK7PpY=
ENV APP_ENV production
ENV APP_DEBUG true

ENV DB_CONNECTION pgsql
ENV DB_HOST dpg-d6gji7ua2pns73fvlou0-a.oregon-postgres.render.com
ENV DB_PORT 5432
ENV DB_DATABASE tabulation_p5j3
ENV DB_USERNAME tabulation_p5j3_user
ENV DB_PASSWORD JMXn17xAnH6B8PKmsjZQoc7zhX3OgeAk

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]
# PGPASSWORD=JMXn17xAnH6B8PKmsjZQoc7zhX3OgeAk psql -h dpg-d6gji7ua2pns73fvlou0-a.oregon-postgres.render.com -U tabulation_p5j3_user tabulation_p5j3