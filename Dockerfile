FROM ipti/yii2
RUN apk add --no-cache \
        libssl1.1 \
&& apk --update --virtual build-deps add \
        autoconf \
        make \
        gcc \
        g++ \
        openssl-dev \
        libtool && \
apk del build-deps
COPY . /app
RUN chown -R www-data:www-data /usr/local/bin/composer
RUN chmod 777 /usr/local/bin/composer
RUN chmod 777 /usr/local/bin/docker-run.sh
#RUN composer self-update
RUN composer update yiisoft/yii2-composer --no-plugins
RUN composer global require "fxp/composer-asset-plugin:^1.2.0"
#RUN composer global update
RUN composer install
#RUN composer update
RUN chown -R www-data:www-data /app/runtime/ \
&& chown -R www-data:www-data /app/web/assets
