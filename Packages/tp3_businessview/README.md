# TYPO3 Extension ``tp3businessview``
[![Latest Stable Version](https://poser.pugx.org/web-tp3/tp3businessview/v/stable)](https://packagist.org/packages/web-tp3/tp3businessview)
[![Daily Downloads](https://poser.pugx.org/web-tp3/tp3businessview/d/daily)](https://packagist.org/packages/web-tp3/tp3businessview)
[![Total Downloads](https://poser.pugx.org/web-tp3/tp3businessview/downloads)](https://packagist.org/packages/web-tp3/tp3businessview)
[![License](https://poser.pugx.org/web-tp3/tp3businessview/license)](https://packagist.org/packages/web-tp3/tp3businessview)

[Manual](https://web.tp3.de/manual/tp3businessview.html)

[Repository](https://bitbucket.org/web-tp3/tp3_businessview)

## Installation

### Using Composer

The recommended way to install the extension is by using (Composer)
[1]. In your Composer based TYPO3 project root, just do `composer require web-tp3/tp3businessview`. 
[2]. Create a businessview record.
[3]. Use the PanoDesigner to find your location or add an tt_address record with cid
[4]. Use the PanoDesigner to design your Tp3BusinessView tour


### As extension from TYPO3 Extension Repository (TER)

Download and install the extension with the extension manager module.

## Minimal setup

1) Include the static TypoScript of the extension. **Optional:** If you are templates are based on Twitter Bootstrap, add the TWB styles as well to get optimized templates.
2) Create some tp3businessview records on a sysfolder.
3) Create a plugin on a page and select at least the sysfolder as startingpoint.

## Administration corner

### Versions and support

| tp3businessview           | TYPO3      | PHP       | Support/Development                          |
| --------------------------| ---------- | ----------|--------------------------------------------- |
| 2.x                       | 9.5        | 7.2 - 7.3 | Bugfixes, Security Updates, Feature Updates, |
|                           |            |           | POI Integration, VR Support                  |
| 1.x                       | 8.7        | 7.0 - 7.2 | Bugfixes, Security Updates                   |

### Contribution

**Forks**, **Pull requests** or **Commits** to support develop are welcome in general! Nevertheless please don't forget to add an issue and connect it to your pull requests. This
is very helpful to understand what kind of issue the **PR** is going to solve.

- Bugfixes: Please describe what kind of bug your fix solve and give us feedback how to reproduce the issue. We're going
to accept only bugfixes if I can reproduce the issue.
- Features: Not every feature is relevant for the bulk of powermail users. In addition: We don't want to make powermail
even more complicated in usability for an edge case feature. Please discuss a new feature before.

[1]: https://getcomposer.org/

[Manual](https://web.tp3.de/manual/tp3businessview.html)

[Repository](https://bitbucket.org/web-tp3/tp3_businessview)
