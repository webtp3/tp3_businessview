FROM webtp3/docker:16.4-stable

ADD . /var/www/html/


# Expose environment variables for automated setup
ENV DB_HOST db
ENV DB_PORT 3306
ENV ADMIN_USER tp3min
ENV ADMIN_PASS Init1111
ENV DB_NAME typo3
ENV DB_USER root
ENV DB_PASS my-secret-pw
ENV INSTALL_TOOL_PASSWORD password
ENV TYPO3_INSTALL_DB_UNIX_SOCKET /run/mysqld/mysqld.sock
ENV TYPO3_PATH_ROOT = /var/www/html/web/
ENV TYPO3_INSTALL_DB_USE_EXISTING false
ENV TYPO3_INSTALL_SITE_NAME  'tp3 TYPO3 testing Suite'
ENV TYPO3_INSTALL_SITE_SETUP_TYPE no
ENV typo3DatabaseName $DB_NAME
ENV typo3DatabaseHost $DB_HOST
ENV typo3DatabaseUsername $DB_USER
ENV typo3DatabasePassword $DB_PASS
ENV typo3DatabasePort $DB_PORT

#ADD AdditionalConfiguration.php /var/www/html/web/typo3conf/

# start composer install
RUN composer config  repositories.local path 'Packages/*' -d  /var/www/html/
RUN chown -R www-data:www-data /var/www/html/ && chmod -R 775 /var/www/html/
#RUN composer --dev install -d  /var/www/html/
#RUN bash /var/www/cgi-bin/run-typo3.sh
#CMD ["bash", "-c", "/var/www/cgi-bin/run-typo3.sh"]

#webroot is in /var/www/html/web we use the vendor dir for that
# for productive enviroment we recommend to ouse the flag --no-dev
