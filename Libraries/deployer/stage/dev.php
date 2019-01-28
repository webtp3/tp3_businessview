<?php
/*
 * host('domain.com')
    ->user('name')
    ->port(22)
    ->configFile('~/.ssh/config')
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no');
 */
server('dev', 'localdev.tp3.de', 22)
    ->user('dev')
    ->configFile('~/.ssh/config')
    ->identityFile('config/keys/id_rsa')
    ->stage('dev')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->set('deploy_path', '/develop/dev-rp/private/')
    ->set('branch', 'develop')
    ;
