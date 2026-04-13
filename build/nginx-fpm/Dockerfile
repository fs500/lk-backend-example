FROM nginx

ARG workdir=/www/app

RUN mkdir -p $workdir

WORKDIR $workdir

RUN apt-get update -q -y \
    && apt-get install -q -y \
        gnupg2 \
        ca-certificates \
        apt-transport-https \
        curl \
        git \
        unzip \
        wget \
        cron \
        make \
        jpegoptim \
        g++ \
        sendmail \
        inkscape \
    && wget http://mirrors.kernel.org/ubuntu/pool/main/libf/libffi/libffi6_3.2.1-8_amd64.deb \
    && dpkg -i libffi6_3.2.1-8_amd64.deb \
    && wget -q https://packages.sury.org/php/apt.gpg -O- | apt-key add - \
    && echo "deb https://packages.sury.org/php/ buster main" | tee /etc/apt/sources.list.d/php.list \
    && apt-get update -q -y \
    && apt-get install -q -y \
        php7.4-cli \
        php7.4-fpm \
        php7.4-common \
        php7.4-curl \
        php7.4-mbstring \
        php7.4-mysql \
        php7.4-xml \
        php7.4-zip \
        php7.4-bcmath \ 
        php7.4-gd \
        php7.4-redis \
        php7.4-intl \
        php7.4-amqp \
        python2.7

RUN ln -s /usr/bin/python2.7 /usr/bin/python2

RUN curl -sL https://deb.nodesource.com/setup_15.x | bash -
RUN apt-get install -y nodejs 
RUN npm install --global yarn

# composer
RUN curl -o /usr/local/bin/composer https://getcomposer.org/composer.phar
RUN chmod +x /usr/local/bin/composer

RUN mkdir -p ~/.ssh/
RUN ssh-keyscan -H github.com >> ~/.ssh/known_hosts

ADD . $workdir
RUN ln -s /www/app/env/.env.local $workdir/.env.local

RUN rm -f  /etc/nginx/conf.d/default.conf
COPY ./build/nginx-fpm/nginx.conf /etc/nginx/conf.d/nginx.conf

RUN rm -f  /etc/php/7.4/fpm/pool.d/www.conf
COPY ./build/nginx-fpm/fpm.conf /etc/php/7.4/fpm/pool.d/fpm.conf

# crontab
COPY ./build/nginx-fpm/crontab /var/spool/cron/crontabs/nginx
RUN chmod 0600 /var/spool/cron/crontabs/nginx
RUN chown nginx:crontab /var/spool/cron/crontabs/nginx

# entrypoint
COPY ./build/nginx-fpm/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

RUN  chown -R nginx: $workdir

#RUN su -c 'composer install --no-scripts' -s /bin/bash nginx
RUN su -c 'composer install --no-scripts --no-dev' -s /bin/bash nginx
#RUN su -c 'composer dumpautoload' -s /bin/bash nginx

RUN su -c 'bin/console assets:install --env=prod' -s /bin/bash nginx
RUN yarn install
RUN yarn encore prod

CMD ["/entrypoint.sh"]


#EXPOSE 80
