FROM php:7.2-fpm


RUN apt-get update -y \
    && apt-get install -y nginx

RUN apt-get install nano -y

# PHP_CPPFLAGS are used by the docker-php-ext-* scripts
ENV PHP_CPPFLAGS="$PHP_CPPFLAGS -std=c++11"

RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install opcache \
    && apt-get install libicu-dev -y \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && apt-get remove libicu-dev icu-devtools -y
RUN { \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=8'; \
        echo 'opcache.max_accelerated_files=4000'; \
        echo 'opcache.revalidate_freq=2'; \
        echo 'opcache.fast_shutdown=1'; \
        echo 'opcache.enable_cli=1'; \
    } > /usr/local/etc/php/conf.d/php-opocache-cfg.ini

RUN rm /etc/nginx/sites-enabled/default

COPY configs/nginx/default.conf /etc/nginx/conf.d/default.conf

COPY entrypoint.sh /etc/entrypoint.sh

COPY ./application/ /var/www/html

WORKDIR /var/www/html

EXPOSE 80 443

ENTRYPOINT ["/etc/entrypoint.sh"]
