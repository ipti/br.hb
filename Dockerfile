FROM ipti/yii2:7.4-fpm
COPY . /app
RUN chown -R www-data:www-data /usr/local/bin/composer
RUN chmod 777 /usr/local/bin/composer
RUN chmod 777 /usr/local/bin/docker-run.sh
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer self-update
RUN composer global update
RUN composer update with the "--no-plugins"
RUN composer install
# RUN composer update yiisoft/yii2-composer --no-plugins
# RUN composer global require "fxp/composer-asset-plugin:^1.2.0"
RUN chown -R www-data:www-data /app/runtime/ \
&& chown -R www-data:www-data /app/web/assets
