#
# The main page object and its most basic properties
#
page = PAGE
page {

  typeNum = 0

	# include css
	includeCSS {
		00_style = /assets/css/style.min.css
	}

	# include js
	includeJS {
		00_main = /assets/js/main.min.js
	}

  # connect the HTML files
  10 = FLUIDTEMPLATE
  10 {
    layoutRootPath = EXT:tmpl/Resources/Private/Pages/Layouts/
    partialRootPath = EXT:tmpl/Resources/Private/Pages/Partials/
    file {
      cObject = CASE
      cObject {
        key {
          field = backend_layout
          ifEmpty.data = levelfield:-2, backend_layout_next_level, slide
        }

        # our very basic default page template
        default = TEXT
        default.value = typo3conf/ext/tmpl/Resources/Private/Pages/Templates/Default.html
      }
    }
  }
}


#########################
##### DEVELOPMENT - Start

[applicationContext = Development]
	page.includeCSS.00_style = /assets/css/style.css
  page.includeJS.00_main = /assets/js/main.js
[end]

##### DEVELOPMENT - End
#########################
