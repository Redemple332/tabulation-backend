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
ENV DB_HOST dpg-cmh1fhfqd2ns73fneg30-a
ENV DB_PORT 5432
ENV DB_DATABASE tabulation
ENV DB_USERNAME tabulation_user
ENV DB_PASSWORD VdXd0N2uIMzpv9WgMSDuEdXULIiGFVwu

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]
