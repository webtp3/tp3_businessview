FROM webtp3/docker:16.4-stable

ADD . /var/www/html
# start composer install
RUN  composer --dev install -d  /var/www/html/

