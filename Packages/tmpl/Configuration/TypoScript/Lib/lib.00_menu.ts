lib.menu = COA
lib.menu {
    wrap = <ul class="menu">|</ul>

    10 = TEXT
    10 {
        wrap = <li>|</li>
        typolink {
            parameter = {$tmpl.pids.pages.startpage}
        }
    }
    20 = HMENU
    20 {

        special = directory
        special.value = 1
        1 = TMENU
        1 {
            expAll = 1
            NO = 1
            NO {
                wrapItemAndSub = <li class="name">|</li>
            }

            IFSUB < .NO
            ACT < .NO
            ACTIFSUB < .ACT
        }

        2 < .1
    }
}

