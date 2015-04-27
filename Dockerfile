FROM debian:wheezy
MAINTAINER zham <zha_ming@163.com>

#php
RUN \
apt-get update && \
apt-get install -y php5-cli php5-curl php5-fpm php5-gd php5-mcrypt php5-mysqlnd php5-pgsql php5-sqlite php5-intl php5-memcache && \
sed -i -e 's/;date.timezone =/date.timezone = Asia\/Chongqing/' /etc/php5/fpm/php.ini && \
sed -i -e 's/session.gc_probability = 0/session.gc_probability = 1/' /etc/php5/fpm/php.ini && \
ln -sf /dev/stdout /var/log/php5-fpm.log
ADD build/php5-eaccelerator.wheezy_amd64.deb /tmp/php5-eaccelerator.wheezy_amd64.deb
RUN dpkg -i /tmp/php5-eaccelerator.wheezy_amd64.deb

#nginx
RUN \
apt-get install -y nginx && \
sed -i -e '20a \        client_max_body_size 10m;' /etc/nginx/nginx.conf && \
sed -i -e 's/#\ server_names_hash_bucket_size/server_names_hash_bucket_size/' /etc/nginx/nginx.conf && \
sed -i -e 's/\/usr\/share\/nginx\/www/\/opt\/www/' /etc/nginx/sites-available/default && \
sed -i -e 's/index.html\ index.htm/index.html\ index.htm\ index.php/' /etc/nginx/sites-available/default && \
ln -sf /dev/stdout /var/log/nginx/access.log && \
ln -sf /dev/stderr /var/log/nginx/error.log

#supervisor
RUN apt-get update && apt-get install -y supervisor
ADD build/supervisor/* /etc/supervisor/conf.d/
ADD build/start.sh /bin/start.sh
RUN chmod 755 /bin/start.sh && rm -rf /var/lib/apt/lists/* /tmp/*

VOLUME ["/opt/www"]
EXPOSE 80 443
CMD ["/bin/start.sh"]