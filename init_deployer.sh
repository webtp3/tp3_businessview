#!/usr/bin/env bash

mkdir shared
cd shared/
ln -s ../config/local.settings.yaml
cd ..
rm web
mkdir web
mv  ../web/* web/
cd ../web/
ln -s ../private/web/index.php
ln -s ../private/web/fileadmin/
ln -s ../private/web/typo3
ln -s ../private/web/typo3conf
ln -s ../private/web/typo3temp
ln -s ../private/web/uploads
rm  typo3conf/ext/*

bin/typo3cms extension:activate realurl
bin/typo3cms extension:activate tt_address
bin/typo3cms extension:activate static_info_tables
bin/typo3cms extension:activate static_info_tables_de
bin/typo3cms extension:activate bootstrap_package
bin/typo3cms extension:activate tp3mods
bin/typo3cms extension:activate yoast_seo
bin/typo3cms extension:activate wec_map
bin/typo3cms extension:activate vidi
bin/typo3cms extension:activate tp3ratings
bin/typo3cms extension:activate tp3_social
bin/typo3cms extension:activate tp3_openhours
bin/typo3cms extension:activate tp3_news_extend
bin/typo3cms extension:activate tp3_jobs
bin/typo3cms extension:activate tp3_businessview
bin/typo3cms extension:activate sr_feuser_register
bin/typo3cms extension:activate news
bin/typo3cms extension:activate media
bin/typo3cms extension:activate gridelements
bin/typo3cms extension:activate bootstrap_grids
bin/typo3cms extension:activate dd_googlesitemap
bin/typo3cms extension:activate bootstrap_grids
bin/typo3cms extension:activate additional_reports
bin/typo3cms extension:activate extractor
bin/typo3cms extension:activate cal

rm -R AdditionalConfiguration.php bin bitbucket-pipelines.yml.dist Build composer.json composer.lock docker-compose.yml Dockerfile Libraries Migrations Packages README.md RoboFile.php Tests -rf
