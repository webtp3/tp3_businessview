TCEMAIN {
    # Owner be_groups UID for new pages:
    permissions {
        groupid = 1

        # Group can do anything
        # (normally "delete" is disabled)
        group = 31

        # Everybody can at least see the page
        # (normally everybody can do nothing)
        everybody = show
    }

    # preview setup for records to be saved and viewed
    preview {

        # preview config for publications
#        tx_wka_domain_model_seminar {
#            previewPageId = 8
#            fieldToParameterMap {
#                uid = tx_wka_seminar[seminar]
#            }
#        }
    }
}