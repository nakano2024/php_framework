FROM php:8.0.7-apache
COPY ./php/php.ini /usr/local/etc/php/conf.d/
COPY ./apache/my.conf /etc/apache2/conf-enabled/my.conf
RUN apt-get update \ 
&& apt-get install -y vim \ 
&& docker-php-ext-install pdo_mysql \ 
&& mv /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled \
&& cd / \
&& apt-get install -y zip unzip \
&& curl -zsS https://getcomposer.org/installer | php \
&& php composer.phar require --dev phpunit/phpunit
#phpunitのパスを通す
ENV PATH $PATH:/vendor/bin
