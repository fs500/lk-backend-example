#!/usr/bin/env bash

# update default values of PAM environment variables (used by CRON scripts)
env | while read -r line; do  # read STDIN by line
    # split LINE by "="
    IFS="=" read var val <<< ${line}
    # remove existing definition of environment variable, ignoring exit code
    sed --in-place "/^${var}[[:blank:]=]/d" /etc/security/pam_env.conf || true
    # append new default value of environment variable
    echo "${var} DEFAULT=\"${val}\"" >> /etc/security/pam_env.conf
done


/etc/init.d/php7.4-fpm start
nginx -g "daemon off;" &
nginx_pid=$!

cron -f &
cron_pid=$!

trap "service php7.4-fpm stop; kill $nginx_pid; kill $cron_pid; exit" SIGINT SIGTERM

su -c '/www/app/bin/console doctrine:migrations:migrate --env=prod --no-interaction' -s /bin/bash nginx
su -c '/www/app/bin/console cache:clear --env=prod' -s /bin/bash nginx

chown -R nginx:nginx /www/app

wait $nginx_pid