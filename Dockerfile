FROM dunglas/frankenphp:latest-alpine

RUN set -eux; \
	install-php-extensions \
    @composer \
    pdo_pgsql \
;