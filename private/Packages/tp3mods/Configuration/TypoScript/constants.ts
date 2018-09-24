
plugin.tx_tp3mods_tp3micro {
    view {
        # cat=plugin.tx_tp3mods_tp3micro/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:tp3mods/Resources/Private/Templates/
        # cat=plugin.tx_tp3mods_tp3micro/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:tp3mods/Resources/Private/Partials/
        # cat=plugin.tx_tp3mods_tp3micro/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:tp3mods/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_tp3mods_tp3micro//a; type=string; label=Default storage PID
        storagePid =
    }
}

module.tx_tp3mods_tp3backend {
    view {
        # cat=module.tx_tp3mods_tp3backend/file; type=string; label=Path to template root (BE)
        templateRootPath = EXT:tp3mods/Resources/Private/Backend/Templates/
        # cat=module.tx_tp3mods_tp3backend/file; type=string; label=Path to template partials (BE)
        partialRootPath = EXT:tp3mods/Resources/Private/Backend/Partials/
        # cat=module.tx_tp3mods_tp3backend/file; type=string; label=Path to template layouts (BE)
        layoutRootPath = EXT:tp3mods/Resources/Private/Backend/Layouts/
    }
    persistence {
        # cat=module.tx_tp3mods_tp3backend//a; type=string; label=Default storage PID
        storagePid =
    }
}
