
plugin.tx_tp3mods_tp3micro {
    view {
        templateRootPaths.0 = EXT:tp3mods/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_tp3mods_tp3micro.view.templateRootPath}
        partialRootPaths.0 = EXT:tp3mods/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_tp3mods_tp3micro.view.partialRootPath}
        layoutRootPaths.0 = EXT:tp3mods/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_tp3mods_tp3micro.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_tp3mods_tp3micro.persistence.storagePid}
        #recursive = 1
    }
    features {
        #skipDefaultArguments = 1
        # if set to 1, the enable fields are ignored in BE context
        ignoreAllEnableFieldsInBe = 0
        # Should be on by default, but can be disabled if all action in the plugin are uncached
        requireCHashArgumentForActionArguments = 1
    }
    mvc {
        #callDefaultActionIfActionCantBeResolved = 1
    }
}

# these classes are only used in auto-generated templates
plugin.tx_tp3mods._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-tp3mods table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-tp3mods table th {
        font-weight:bold;
    }

    .tx-tp3mods table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)

# Module configuration
module.tx_tp3mods_tools_tp3modstp3backend {
    persistence {
        storagePid = {$module.tx_tp3mods_tp3backend.persistence.storagePid}
    }
    view {
        templateRootPaths.0 = EXT:tp3mods/Resources/Private/Backend/Templates/
        templateRootPaths.1 = {$module.tx_tp3mods_tp3backend.view.templateRootPath}
        partialRootPaths.0 = EXT:tp3mods/Resources/Private/Backend/Partials/
        partialRootPaths.1 = {$module.tx_tp3mods_tp3backend.view.partialRootPath}
        layoutRootPaths.0 = EXT:tp3mods/Resources/Private/Backend/Layouts/
        layoutRootPaths.1 = {$module.tx_tp3mods_tp3backend.view.layoutRootPath}
    }
}
