<?php

server('dev', 'localdev.tp3.de', 22)
    ->user('dev')
    ->forwardAgent()
    ->stage(['dev'])
    ->set('deploy_path', '/develop/dev-rp/private/')
    ->set('branch', 'develop')
    ;
