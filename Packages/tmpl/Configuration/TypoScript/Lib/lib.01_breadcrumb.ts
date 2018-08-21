lib.breadcrumb = COA
lib.breadcrumb {
    wrap = <nav id="breadcrumbs-navi" aria-label="You are here:" role="navigation"><div class="row"><div class="large-12 medium-12 small-12 columns">|</div></div></nav>

    10 = HMENU
    10 {
        special = rootline

        # zeige komplette rootline an
        special.range = 0|-1
        includeNotInMenu = 1

        wrap.cObject = COA
        wrap.cObject {
            10 = TEXT
            10.value = <ul class="breadcrumbs">
            20 = TEXT
            20.value = |
            40 = TEXT
            40.value = </ul>
        }

        # Text vor dem Rootline Menue
        1 = TMENU
        1.target = _top
        1 {
            NO {
                stdWrap.htmlSpecialChars = 1
                wrapItemAndSub = <li>|</li>
                doNotLinkIt = 0
            }

            CUR = 1
            CUR {
                #                    doNotLinkIt = 1
                wrapItemAndSub = <li class="active">|</li>
            }
        }
    }
}

[globalVar = TSFE:id = {$tmpl.pids.pages.startpage}]
    lib.breadcrumb >
[end]