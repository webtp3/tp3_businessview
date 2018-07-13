FROM webtp3/docker:16.4-stable

ADD . /var/www/html
# start composer install
RUN composer config  repositories.local path 'Packages/*' -d  /var/www/html/
RUN composer update -d  /var/www/html/

# Expose environment variables for automated setup
ENV DB_HOST **LinkMe**
ENV DB_PORT **LinkMe**
ENV DB_NAME typo3
ENV DB_USER root
ENV DB_PASS my-secret-pw
ENV INSTALL_TOOL_PASSWORD password
ADD AdditionalConfiguration.php /var/www/html/web/typo3conf/

#webroot is in /var/www/html/web we use the vendor dir for that
# for productive enviroment we recommend to ouse the flag --no-dev