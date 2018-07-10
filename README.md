# tp3_installer

Install typo3 
- develop
- stage
- production

This is an installer for typo3 dev environment with unit, functional and acceptance  testing and developer tools
```bash
 composer --dev --stability=dev create-project web-tp3/tp3_installer:dev-8.x-dev 
```

You can pick a Version/Branch of typo3 within the the Installer 
dev-master (9.x-dev) 
dev-8.x-dev (8.x-dev)
Dependiencies will be maintained within the different Versions. So think about disconnecting your git.

Simply installs typo3 out of following composer.json for typo3 LTS 8.x -> dev-8.x-dev 
  
```json
{
	"name": "web-tp3/tp3_installer",
	"description": "testing typo3",
	"type": "project",
	"minimum-stability": "dev",
	"version": "1.0.0",
	"license": "GPL-3.0+",
	"authors": [
		{
			"name": "Jochen Rieger",
			"email": "j.rieger@connecta.ag"
		},
		{
			"name": "Thomas Ruta",
			"email": "email@thomasruta.de"
		},
		{
			"name": "Matthias Krams",
			"email": "m.krams@connecta.ag"
		}
	],
	"repositories": [
		{
			"type": "composer",
			"url": "https://composer.typo3.org/"
		}
	],
	"require": {
		"typo3/cms": "dev-TYPO3_8-7",
		"helhum/typo3-console": "^5",
		"helhum/dotenv-connector": "^2",
		"helhum/config-loader": "^0.8",
		"ext-gd": "*",
		"ext-fileinfo": "*",
		"ext-zlib": "*",
		"ext-openssl": "*",
		"ext-zip": "*",
		"ext-mysqli": "*",
		"typo3/cms-cli": "*",
		"typo3/class-alias-loader": "*",
		"typo3/cms-composer-installers": "*",
		"psr/http-message": "~1.0",
		"cogpowered/finediff": "~0.3.1",
		"guzzlehttp/guzzle": "^6.3.0",
		"web-tp3/tp3_installer":"1.0.0"
	},
	"require-dev": {
		"deployer/deployer": "^6",
		"consolidation/robo": "^1",
		"codeception/codeception":"*",
		"typo3/testing-framework": "8.x-dev",
		"friendsofphp/php-cs-fixer": "^2.13@dev",
		"se/selenium-server-standalone":"~2.53",
		"typo3/cms-styleguide" :"~8.0.8",
		"ext-soap": "*",
		"phpunit/php-invoker":"^1.1",
		"enm1989/chromedriver": "~2.30",
		"fiunchinho/phpunit-randomizer": "~3.0.0",
		"phpunit/phpunit": "*",
		"nimut/testing-framework": "^3.0@dev"

	},
	"autoload": {
		"psr-4": {
		}
	},
	"extra": {
		"typo3/cms": {
			"cms-package-dir": "{$vendor-dir}/typo3/cms",
			"web-dir": "web"
		},
		"helhum/typo3-console": {
			"install-extension-dummy": false
		},
		"helhum/dotenv-connector": {
			"cache-dir": "var/cache"
		},
		"branch-alias": {
			"dev-TYPO3_8-7": "8.x-dev"
		}
	},
	"non-feature-branches": [
	"TYPO3_.+"
	]

}
```
 
Feel free to edit the piplines for automated deployment For the first test we suite this package with a docker image running with all needed php features to get started with testing.

Combined you can make automated tests before deployment.

https://bitbucket.org/web-tp3/docker