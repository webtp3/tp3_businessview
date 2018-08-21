
# adjust field config and labels for content elements
TCEFORM {
    tt_content {

        # let's have good headline options and labels
        header_layout {
            removeItems := addToList(0,5)
            altLabels {
                1 = H1
                2 = H2
                3 = H3
                4 = H4
                100 = Hide headline
            }
        }
    }

}

# some default values for content elements
#TCAdefaults.tt_content {
#	header_layout = 2
#    image_zoom = 0
#    imageorient = 18
#    imagecols = 1
#}

# set default values of fce "main slider" inline slides (tt_content)
[page|uid = 1]
#TCAdefaults.tt_content.pid = 22
#TCAdefaults.tt_content.CType = slider_content
[global]