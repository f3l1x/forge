FROM dockette/alpine:3.8

RUN apk update && \
    apk upgrade && \
    apk --no-cache add curl git

RUN echo '@community http://nl.alpinelinux.org/alpine/v3.8/community' >> /etc/apk/repositories && \
    apk update && \
        apk --no-cache add \
        php7@community \
        php7-json@community \
        php7-tokenizer@community \
        php7-phar@community \
        php7-iconv@community \
        php7-mbstring@community \
        php7-pdo@community \
        php7-openssl@community \
        php7-session@community

RUN	curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer create-project nette/sandbox /srv

RUN apk del git curl && \
	rm -rf /var/cache/apk/*

CMD php -S 0.0.0.0:3000 -t /srv/www
