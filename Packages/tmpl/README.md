# CAG Basis Extension

Dies ist die CAG Basis-Extension zur Einbindung in neuen Projekten. Um den vollen Feature-Umfang nutzen können (z.B. automatische Environment-basierte Config), sollte sie in [cag_project](https://bitbucket.org/connecta-ag/cag_project) eingebettet sein.

## Die Features

* Grundlegende Ordnerstrukturen zur Ablage von Klassen, Templates, Assets, Konfigurationen
* Ein Basis-Set an TypoScript und TS Config Optionen
* PHP Klassen und Config basierend auf [cag_project's AdditionalConf](https://bitbucket.org/connecta-ag/cag_project/src/49e384e2ee48110558c7cefd5152911201479881/web/typo3conf/AdditionalConfiguration.php?at=master&fileviewer=file-view-default) für
    + Besseres Exception Handling + Logging nach [PROJECT/var/log](https://bitbucket.org/connecta-ag/cag_project/src/49e384e2ee48110558c7cefd5152911201479881/var/log/?at=master)
    + Dynamisches Laden von Config-Optionen (z.B. DB-Credentials) via *.env* - siehe [.env.example](https://bitbucket.org/connecta-ag/cag_project/src/49e384e2ee48110558c7cefd5152911201479881/.env.example?at=master)
* Context-abhängige Debugging- und Caching-Einstellungen - siehe [Typo3ConfVars](https://bitbucket.org/connecta-ag/tmpl/src/4b886c998dfbf8cfcea75c9b4277396548ef84f0/Configuration/Typo3ConfVars/?at=master)
* Optimierte Ordnerstruktur für Assets und deren Source-Dateien - siehe auch [cag_project/package.json](https://bitbucket.org/connecta-ag/cag_project/src/49e384e2ee48110558c7cefd5152911201479881/package.json?at=master&fileviewer=file-view-default)

## Einbinden der Basis Extension

**TODO:** überarbeiten und mit cag_project abgleichen!

Zur Einbindung der Extension muss diese einfach in das Projekt eingefügt werden.

> **Note:**

> - git clone git@bitbucket.org:connecta-ag/tmpl.git
> - mv tmpl --your-project-ext-folder--
> - Im TYPO3-Backend die Basis Extension Root TS Template als Include Static einbinden.

## Enthaltene Funktionalitäten
### Frontend Toolchain

Die Frontend Toolchain (via npm Task Runner) wurde ins generall CAG
[Projekt-Template](https://bitbucket.org/connecta-ag/cag_project) überführt.

### Page Templates

#### Layout
Definition des Standard-Layouts unter: *EXT:tmpl/Resources/Private/Pages/Layouts/Default.html*

#### Standard-Template
Es ist ein einspaltiges standard Fluid-Template enthalten unter: *EXT:Tmpl/Templates/Page/00_Standard.html*

### Partial "Image Responsive"
Zur einheitlichen Ausgabe der Bilder ist das Partial "Image Responsive" enthalten. Es stehen verschiedene Ratios zur Verfügung:

 - figure__16-9
 - figure__4-3
 - figure__wide
 - figure__ultra-wide
 - figure__no-ratio

### Page not found handling

Im Pfad *EXT:tmpl/Classes/Utility/PageNotFoundHandling.php* liegt die die Klasse zur Erweiterung des 404-Handlings.
Standardmäßig wirft TYPO3 bei Zugriff einer zugriffgeschützten Seite den Status "404 - Seite nicht gefunden". Gewöhnlich möchte man den Benutzer in diesem Fall allerdings zum Loginformular führen.
Folgende Konfiguration müssen hinzugefügt werden:
```php
$GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling'] = 'USER_FUNCTION:EXT:tmpl/Classes/Utility/PageNotFoundHandling.php:user_pageNotFound->pageNotFound';

// Custom configuration for multi-language 404 page, see EXT:tmpl/Classes/Utility/PageNotFoundHandling.php
// ID of the page to redirect to if page was not found
$GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling_redirectPageID'] = 123;
// ID of the page to redirect to if current page is access protected
$GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFound_handling_loginPageID'] = 789;
```

In der RealUrl-Konfiguration muss mindestens das leere preVars-Array angelegt sein.
```php
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl']['_DEFAULT']['preVars'] = [];
``` 