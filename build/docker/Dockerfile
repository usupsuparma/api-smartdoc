################################################################################
# Dockerfile for Lumen Docker
################################################################################

FROM aelgees/lumen-v6:1.0.0


WORKDIR /srv/www

ADD . /srv/www

COPY ./cron/crontab.txt /etc/crontabs/root

RUN mkdir -p /srv/www/storage && \
    chmod -R 777 storage/

RUN apk add php7-ftp

CMD ["exec", "crond", "-f"]

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
