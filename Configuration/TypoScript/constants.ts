
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
}
