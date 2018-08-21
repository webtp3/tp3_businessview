#
# Config, changing and extending content elements, and system inherent typoscript
#

##
# Setting additional content element template paths for EXT:fluid_styled_content
lib.contentElement.templateRootPaths.10 = EXT:tmpl/Resources/Private/Content/Templates/
lib.contentElement.partialRootPaths.10 = EXT:tmpl/Resources/Private/Content/Partials/
lib.contentElement.layoutRootPaths.10 = EXT:tmpl/Resources/Private/Content/Layouts/


#tt_content.fluidcontent_content {
#    stdWrap {
#        dataWrap = <div id="c{field:uid}" class="ce row">|</div>
#        dataWrap.override = <div id="c{field:uid}" class="ce row expanded">|</div>
#        dataWrap.override.if {
#            equals.field = layout
#            value = 1
#        }
#    }
#}
