FROM webtp3/typo3:16.4-bundle

ADD . /var/www/html/


# Expose environment variables for automated setup
ENV DB_HOST = localhost
ENV DB_PORT = 3306
ENV ADMIN_USER = tp3min
ENV ADMIN_PASS = Init1111
ENV DB_NAME typo3
ENV DB_USER root
ENV DB_PASS my-secret-pw
ENV INSTALL_TOOL_PASSWORD password
#ADD AdditionalConfiguration.php /var/www/html/web/typo3conf/git pull

# start composer install
RUN composer config  repositories.local path 'Packages/*' -d  /var/www/html/
RUN composer --dev install -d  /var/www/html/
RUN chown -R 1000:33 /var/www/html/ && chmod -R 775 /var/www/html/


#webroot is in /var/www/html/web we use the vendor dir for that
# for productive enviroment we recommend to ouse the flag --no-dev
