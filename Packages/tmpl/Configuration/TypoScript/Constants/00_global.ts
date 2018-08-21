#
# Defining some general constants
#

# basic config options
config {

  language = de
  locale = de_DE.UTF-8
  sys_language_uid = 0

}

# some options for the page object, meta data, etc.
page {

  meta {

    # cat=EXT:tmpl: basic/120/100; type=string; label=Description: Enter a short description of the page. It will be displayed in the result lists of most search engines.
    description =
    # cat=EXT:tmpl: basic/120/110; type=string; label=Author: Enter the page author's name.
    author =
    # cat=EXT:tmpl: basic/120/120; type=string; label=Keywords: Enter keywords for the page separated by commas. You may also use short phrases.
    keywords =
    # cat=EXT:tmpl: advanced/120/100; type=string; label=viewport
    viewport = width=device-width, initial-scale=1
    # cat=EXT:tmpl: advanced/120/110; type=string; label=robots
    robots = index, follow
    # cat=EXT:tmpl: advanced/120/120; type=string; label=apple-mobile-web-app-capable
    apple-mobile-web-app-capable = no
    # cat=EXT:tmpl: advanced/120/130; type=string; label=compatible
    compatible = IE=edge
    # cat=EXT:tmpl: advanced/120/140; type=string; label=google
    google = notranslate

  }
}

tmpl {

  defaultPageTitle =

  pids {
    pages {
      startpage = 1
    }

    models {
      #            seminar = 6
      #            person = 9
      #            location = 17
      #            fieldOfLaw = 18
      #            bookingRequest = 29
    }
  }

}
