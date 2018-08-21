lib.header = COA
lib.header {

    10 = COA
    10 {
        wrap = <div class="row">|</div>
        10 = TEXT
        10 {
            wrap = <div class="large-9 medium-8 small-6 columns">|</div>
            value = <img src="/assets/Images/logo.png" alt="Logo">
            typolink {
                parameter = {$tmpl.pids.pages.startpage}
                ATagParams = id="logo" class="navbar-brand navbar-brand-image"
            }
        }
        20 = TEXT
        20 {
            value (
                <div class="large-3 medium-3 small-1 columns show-for-small-only">
                    <a class="mobile-menu--button" data-toggle="offCanvas">
                        <span class="mobile-menu--burger"><span></span></span>
                    </a>
                </div>
            )
        }
    }

    20 = COA
    20 {
        wrap = <nav id="main-navi" class="top-bar show-for-medium" data-topbar role="navigation"><div class="row">|</div></nav>

        # main menu
        10 = COA
        10.wrap = <div class="large-10 medium-10 small-9 columns">|</div>
        10 {
            10 < lib.menu
        }
    }

    30 < lib.breadcrumb
}