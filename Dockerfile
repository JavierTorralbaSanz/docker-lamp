FROM php:7.2.2-apache
RUN docker-php-ext-install mysqli
RUN a2enmod rewrite

#Cambiar los permisos de access.txt , hay que hacer docker-compose up --build
COPY ./app /var/www/html
RUN chmod o+rw /var/www/html/access.txt
CMD ["sh", "-c", "chmod o+rw /var/www/html/access.txt && apache2-foreground"]

RUN echo "ServerTokens Prod" >> /etc/apache2/apache2.conf
RUN echo "expose_php = Off" >> /usr/local/etc/php/php.ini
RUN echo "session.cookie_samesite = 'Strict'" >> /usr/local/etc/php/php.ini
RUN echo "session.cookie_secure = 1" >> /usr/local/etc/php/php.ini
RUN echo "session.cookie_httponly = 1" >> /usr/local/etc/php/php.ini
