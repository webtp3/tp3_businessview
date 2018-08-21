#
# Templates and settings for EXT:tmpl based plugins
#
plugin.tx_tmpl {
  view {
    templateRootPaths.0 = {$plugin.tx_tmpl.view.templateRootPath}
    partialRootPaths.0 = {$plugin.tx_tmpl.view.partialRootPath}
    layoutRootPaths.0 = {$plugin.tx_tmpl.view.layoutRootPath}
  }

  persistence {
    storagePid = {$plugin.tx_tmpl.persistence.storagePid}
  }

  features {
    # uncomment the following line to enable the new Property Mapper.
    # rewrittenPropertyMapper = 1
  }
}
