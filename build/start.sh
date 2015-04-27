#!/bin/bash
#do something before running
chown -R www-data:www-data /opt/www

#run supervisor in foreground
exec supervisord -n