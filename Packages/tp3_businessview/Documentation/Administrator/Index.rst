.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _admin-manual:

Administrator Manual
====================

Target group: **Administrators**

.. _admin-installation:

Installation
------------

the extention can be installed from the ter tp3_businessview
https://extensions.typo3.org/extension/tp3_businessview/

To install the extension, perform the following steps:

#. Go to the Extension Manager
#. afterwards you should include the static template tp3_businessview or add the tssetup manualy

After the installation you need to register API Keys at google - they are needed places search in the backend.

https://console.developers.google.com/apis/

these Apis are recomended:

Google Maps JavaScript API
Google Maps Geocoding API
Google Street View Image API
Street View Publish API (upcomming features)

the key goes into the constants - if you want one for be and one for fe

If you need accistance or have questions or suggestions dont hesitate to contact me mith an email@thomasruta.de

Before you can add your Views to the page the should be available on google. Best if you let them make by an google certified fotographer else you can use you smartphone or do it your self.




.. figure:: ../Images/ExtManager.png
   :alt: Extension Manager
   :width: 1020px

   Extension Manager (tp3_businessview)


.. _admin-configuration:

Configuration
-------------

After setting the api key - define a Storage pid where the Panaramas and BusinessView models entries are stored.
Overlay colors and text-colors can be set here too.

.. code-block:: typoscript

     plugin.tx_tp3businessview_tp3businessview {
        view {
          # cat=plugin.tx_tp3businessview_tp3businessview/file; type=string; label=Path to template root (FE)
          templateRootPath = EXT:tp3_businessview/Resources/Private/Templates/
          # cat=plugin.tx_tp3businessview_tp3businessview/file; type=string; label=Path to template partials (FE)
          partialRootPath = EXT:tp3_businessview/Resources/Private/Partials/
          # cat=plugin.tx_tp3businessview_tp3businessview/file; type=string; label=Path to template layouts (FE)
          layoutRootPath = EXT:tp3_businessview/Resources/Private/Layouts/
        }
        persistence {
          # cat=plugin.tx_tp3businessview_tp3businessview//a; type=string; label=Default storage PID
          storagePid =
        }
        settings{
          # cat=plugin.tx_tp3businessview_tp3businessview//a; type=string; label=google api key (FE) https://console.developers.google.com/apis/
          googleMapsJavaScriptApiKey = needaownone
          # cat=plugin.tx_tp3businessview_tp3businessview//a; type=bolean; label=load maps api from google in (FE)
          loadApi= false
          # cat=plugin.tx_tp3businessview_tp3businessview//a; type=string; label=overlay color
          color=orange
          # cat=plugin.tx_tp3businessview_tp3businessview//a; type=string; label=overlay backgroundColor
          backgroundColor=#F0AD4E
          # cat=plugin.tx_tp3businessview_tp3businessview//a; type=string; label=overlay textColor
          textColor=#FFF
          # cat=plugin.tx_tp3businessview_tp3businessview//a; type=string; label=overlay align
          align=right
        }

      }

      module.tx_tp3businessview_web_tp3businessviewmodule {
        view {
          # cat=module.tx_tp3businessview_web_tp3businessviewmodule/file; type=string; label=Path to template root (BE)
          templateRootPath = EXT:tp3_businessview/Resources/Private/Templates/BusinessView/
          # cat=module.tx_tp3businessview_web_tp3businessviewmodule/file; type=string; label=Path to template partials (BE)
          partialRootPath = EXT:tp3_businessview/Resources/Private/Partials/BusinessView/
          # cat=module.tx_tp3businessview_web_tp3businessviewmodule/file; type=string; label=Path to template layouts (BE)
          layoutRootPath = EXT:tp3_businessview/Resources/Private/Layouts/BusinessView/
        }
        persistence {
          # cat=module.tx_tp3businessview_web_tp3businessviewmodule//a; type=string; label=Default storage PID
          storagePid = {$plugin.tx_tp3businessview_tp3businessview.persistence.storagePid}
        }
        settings{
          # cat=module.tx_tp3businessview_web_tp3businessviewmodule/file; type=string; label=Maps api key for (BE) https://console.developers.google.com/apis/
          googleMapsJavaScriptApiKey = {$plugin.tx_tp3businessview_tp3businessview.settings.googleMapsJavaScriptApiKey}

        }
      }

.. _admin-faq:

FAQ
---

Possible subsection: FAQ

so questions asked yet.
email@thomasruta.de

Subsection
^^^^^^^^^^

Some subsection

Sub-subsection
""""""""""""""

Deeper into the structure...
