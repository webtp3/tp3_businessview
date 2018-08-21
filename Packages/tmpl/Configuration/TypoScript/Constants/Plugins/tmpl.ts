#
# Templates and settings for EXT:tmpl based plugins
#
plugin.tx_tmpl {
	view {
		# cat=plugin.tx_tmpl/file; type=string; label=Path to template root (FE)
		templateRootPath = EXT:tmpl/Resources/Private/Extensions/Tmpl/Templates/
		# cat=plugin.tx_tmpl/file; type=string; label=Path to template partials (FE)
		partialRootPath = EXT:tmpl/Resources/Private/Extensions/Tmpl/Partials/
		# cat=plugin.tx_tmpl/file; type=string; label=Path to template layouts (FE)
		layoutRootPath = EXT:tmpl/Resources/Private/Extensions/Tmpl/Layouts/
	}
	persistence {
		# cat=plugin.tx_tmpl//a; type=string; label=Default storage PID
		storagePid =
	}
}
