FROM yiisoftware/yii2-php:7.4-apache
COPY . /app
RUN chown -R www-data:www-data /usr/local/bin/composer
RUN chmod 777 /usr/local/bin/composer
RUN chmod 777 /usr/local/bin/docker-run.sh
# RUN composer self-update
RUN composer global update
# RUN composer update
RUN composer update "--no-plugins"
# RUN composer update with the "--no-plugins"
RUN composer install
# RUN composer update yiisoft/yii2-composer --no-plugins
# RUN composer global require "fxp/composer-asset-plugin:^1.2.0"
RUN chown -R www-data:www-data /app/runtime/ \
&& chown -R www-data:www-data /app/web/assets

