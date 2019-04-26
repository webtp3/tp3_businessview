#!/usr/bin/env bash

#after 7
bin/typo3cms upgrade:all


##ggf
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
bin/typo3cms extension:activate recycler
bin/typo3cms extension:activate rte_ckeditor
bin/typo3cms extension:activate setup
bin/typo3cms extension:activate sys_action
bin/typo3cms extension:activate tscobj
bin/typo3cms extension:activate wizard_sortpages
bin/typo3cms extension:activate workspaces
bin/typo3cms extension:activate yoast_news
bin/typo3cms extension:activate yoast_seo
bin/typo3cms extension:activate bootstrap_package
bin/typo3cms extension:activate gridelements
bin/typo3cms extension:activate tt_address
bin/typo3cms extension:activate cal


bin/typo3cms extension:activate tp3_googlemaps
bin/typo3cms extension:activate tp3_ddgooglesitemap_extend
bin/typo3cms extension:activate tp3_hessenfilm
bin/typo3cms extension:activate xqueue_subscribe
bin/typo3cms extension:activate locationupdate
bin/typo3cms extension:activate html5videoplayer
bin/typo3cms extension:activate filmcomission


bin/typo3cms language:update locationupdate


bin/typo3cms language:update backend
bin/typo3cms language:update beuser
bin/typo3cms language:update core
bin/typo3cms language:update dd_googlesitemap
bin/typo3cms language:update extractor
bin/typo3cms language:update feedit
bin/typo3cms language:update form
bin/typo3cms language:update gridelements
bin/typo3cms language:update powermail
bin/typo3cms language:update bootstrap_grids
bin/typo3cms language:update bootstrap_package
bin/typo3cms language:update tp3_businessview
bin/typo3cms language:update sr_feuser_register
bin/typo3cms language:update bootstrap_grids
bin/typo3cms language:update tt_address
bin/typo3cms language:update wec_map
bin/typo3cms language:update yoast_seo
bin/typo3cms language:update tp3_jobs
bin/typo3cms language:update tp3_news_extend
bin/typo3cms language:update tp3_facebook
bin/typo3cms language:update tp3_openhours
bin/typo3cms language:update tp3_social
bin/typo3cms language:update setup
bin/typo3cms language:update sys_action
bin/typo3cms language:update tp3ratings
bin/typo3cms language:update workspaces
bin/typo3cms language:update media
bin/typo3cms language:update news

