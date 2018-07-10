# tp3_tests

This is an installer for typo3 dev environment with unit, functional and acceptance  testing and developer tools
```bash
 composer --dev --stability=dev create-project web-tp3/tp3_installer:dev-8.x-dev 
```

You can pick a Version/Branch of typo3 within the the Installer 
dev-master (9.x-dev) 
dev-8.x-dev (8.x-dev)
Dependiencies will be maintained within the different Versions. So think about disconnecting your git.

Simply installs typo3 out of following composer.json for typo3 LTS 8.x -> dev-8.x-dev 
  
Feel free to edit the piplines for automated deployment For the first test we suite this package with a docker image running with all needed php features to get started with testing.

Combined you can make automated tests before deployment.

https://bitbucket.org/web-tp3/docker