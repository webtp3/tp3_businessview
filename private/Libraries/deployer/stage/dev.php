<?php

server('dev-svr', 'localdev.tp3.de', 22)
    ->user('dev')
    ->forwardAgent()
    ->stage(['dev'])
    ->set('deploy_path', '/develop/tests')
    ->set('branch', 'develop')
    ;
