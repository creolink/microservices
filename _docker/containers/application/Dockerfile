FROM php:7.2.2-fpm

ADD entrypoint.sh /usr/local/bin/folders.sh
RUN chmod +x /usr/local/bin/folders.sh

RUN usermod -u 1000 www-data

ENTRYPOINT ["/usr/local/bin/folders.sh"]