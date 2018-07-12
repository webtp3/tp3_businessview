FROM webtp3/docker

ADD . /var/www/html
# start composer install
RUN  composer --dev install -d  /var/www/html/

