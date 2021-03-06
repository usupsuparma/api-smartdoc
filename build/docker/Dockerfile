################################################################################
# Dockerfile for Lumen Docker
################################################################################

FROM aelgees/lumen-v6:1.0.0

WORKDIR /srv/www

ADD . /srv/www

RUN mkdir -p /srv/www/storage && \
    chmod -R 777 storage/

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]