FROM php:7.2.2-apache
RUN docker-php-ext-install mysqli
RUN a2enmod rewrite

#Cambiar los permisos de access.txt , hay que hacer docker-compose up --build
COPY ./app /var/www/html
RUN chmod o+rw /var/www/html/access.txt
CMD ["sh", "-c", "chmod o+rw /var/www/html/access.txt && apache2-foreground"]
