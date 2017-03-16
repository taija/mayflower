=== Mayflower ===
Contributors: Bellevue College Integration Team
Tags: blue, white, two-columns, three-columns, left-sidebar, right-sidebar, responsive-layout, custom-background, custom-header, custom-menu, editor-style, featured-images, flexible-header, full-width-template, post-formats, theme-options, accessibility-ready
Requires at least: 4.4
Tested up to: 4.6.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Mayflower is a WordPress theme created by Bellevue College as a unified theme for all college units.

= Special Features =
Mayflower has the following dependencies:

1. [WordPress Multisite](http://codex.wordpress.org/Create_A_Network)
2. Globals Style Library (must be available on the same server)
3. [Compass](http://compass-style.org/) installed on development systems

Specific configuration and release information is available in [Bellevue College Docs](https://github.com/BellevueCollege/docs/tree/master/mayflower). 

== Changelog ==
= 2.14 =
* Fetch CE Course information via AJAX

= 2.13 =
* Add 'none' option when selecting navigation in Mayflower branded
* Convert README.md to WordPress-spec README.txt

= 2.12 =
* Refactored sidebar CSS
* Added collapsing submenus to sidebar
* Allowed globals settings to be set in single site
* Added styles to visual editor

= 2.11 =
* Change location of hidden search label
* Standardize site titles as <p> tags instead of <h1>

= 2.10 =
* Fix bug where date was not showing for posts made
  on the same day
* Fix bug where Simple Page Sidebars were not working
  on homepages with blog posts enabled
* Revise CEPrograms description
* Limit length of search query field
* Add hidden label to search in Mayflower lite

= 2.9 =
* Allow extention of sidebar/widget areas
  * Add mayflower_register_sidebar hook
  * Add mayflower_display_sidebar hook
  * Add mayflower_active_sidebar filter
* Highlight ancestor in nav bar for CPTs
* Prevent display of submenus in top nav
* CE Programs Custom Post Type fixes
  * A11y fix on more buttob
  * Properly handle absence of data
  * Balance HTML elements
  * Add Simple Page Sidebar support
* Beta version of Experts template (UNTESTED!)

= 2.8 =
* Add templates to support CE programs post type
* Move Admin Only options to Customizer
* Refactor Mayflower options to use Customizer directly
* Only display Customizer Mayflower Homepage Options
  when Mayflower Homepage is actually visable
* Allow for search scope configuration
* Use HTML5 Image Tags and Galleries
* Use consistent styles for all images
* Use Flexbox for image galleries (fluid layout)
* Staff and Slider interfaces: fix re-order icons
* Slider interface: fix slider preview images
* Slider interface: add slider titles to re-order screen
* Add option to hide post date for posts
* Add option to show post author for posts
* Fix pagination to match Bootstrap styles
* Display 'last updated' date on all pages
* Alt Text enforcement from WP-Accessibility plugin
* Add support for Asides to templates
  (requires plugin for use)

= 2.7 =
* Make bc_footer() and mayflower_body_class_ia()
  functions pluggable
* Remove homepage specific styles

= 2.6.2 =
* Allow templates to display on home page
* Switch to full-width slideshow if no sidebar content

= 2.6.1 =
Fix post display on site and post homepages

= 2.6 =
* Moved to WordPress standard template heirarchy
* Removed homesite specific templates and functions
* Added link to site title on Branded
* Fixed sidebar bug in Grid Navigation Page template
* Changed unchartered club notice color in Student Clubs temp

= 2.5 =
* Remove ~20,000 lines of depricated code
* Add lead class to Visual editor
* Clean up how alert classes are inserted
  from Visual editor
* Remove theme options interface
* Move mayflower customizer options to new panel
* Remove 404 page email code
* Add cute messages to 404 page
* Set default image insertion options to small + left
* Default Globals settings to Globals 3
* Force small images to break text above and below
  on small screen devices

= 2.4 =
* Add page templates to support student-programs plugin
* Added archive page template to support
  trustees-agenda plugin
* Remove lead styles from Mayflower
* Accessibility and styling updates to captions
* Update default News Site ID to match production
* Add is_multisite_home() function
* Enqueue scripts and styles
* Add multisite home specific legal bar
* Responsive image gallery fixes
* Add attachment page templates
* Whitespace cleanup

= 2.3 =
* Changed template parts to be loaded automatically based on page name
* Changed template part names to match new standard
* Added template parts for Student Clubs plugin
* Added template parts for Trustees Agenda plugin

= 2.2.1 =
* Remove Gravity Forms Button Styling
* Fix Issue Where Posts Could Not Be Clicked

= 2.2 =
* Restyle Gravity Forms elements to better match Bootstrap
* Fix or remove malformed switch statements
  (duplicate default cases)
* Update staff page layouts for better presentation
* Fix lite header to display better on mobile devices
* Remove date from home page apply button

= 2.1.1 =
* Updated date on apply button on homepage for spring 2015

= 2.1 =
* Updates to how 404 is handled
* Add responsive wrapper around embed video
* Update search box with label for accessibility
* remove references to deprecated skins functionality
* protocol agnostic changes to resource urls
* added deadline to admission btn on home page
* fixed sorting on sub-nav pages
* fixed staff grid view layout
* ascending order by default on page nav grid view
* Change size of featured-full to 1170x488
* Fix header logo responsiveness on lite

= 2.0.1 =
* Update location where custom editor styles point to
* Add back part-flexnav.php to git

= 2.0 =
* This is a major release
* Updated grid system for Bootstrap 3
* Updated nav page list view
* Remove all "Read More" links in the theme
* Fix breakpoints on menus for home page
* Make form actions protocol indpendent
* Remove color scheme option from theme options

= 1.7 =
 Removed rave alert notifcation html.
 Removed links of alert-notification file in function.php.
 Moved Rave alert functionality into a plugin.
 Removed cron job and rave alert functionality from the theme.
 Made Links on home page consistent.
 Added www to all the links that were missing that.
 Updated Google Analytics to Universal analytics.
 Updated serachform.php to fix to missing label connection in Search
  for lite branded sites.
 Add hook to mayflower to allow 'Tabs Shortcode' to run off Bootstrap
 Styles.

= 1.6 =
* Fixed staff grid view
    * Staff now display in a proper grid with hyperlinks on the thumbnail and
      the name (title)
* Cleanup display of Staff listings
    * Removed double title on staff pages
    * Removed meta data display on grid view
* Added list view page template for nav pages.
    * Nav pages can now be either list or grid. This is to accommodate the
      display of content in a way that lines up with how it currently displays
      on the home site.
* Added ability to hide search form via Appearance > Mayflower Admin Only
  Settings
    * There is a new option to toggle the search form. This was made
      specifically for the LMC site, but can be used by all mayflower sites
      using the Lite version of the theme in situations when multiple search
      forms on a page could cause confusion. Only super admins have access to
      hide the search form.
* Cleanup numerous php notices, php warnings & deprecated WP functions
    * Used http://www.themecheck.org to determine fixes for php notices, php
      warnings, deprecated WordPress functions and other errors or problems
      with our theme.  Theme check is what WordPress.org uses to decide whether
      or not to allow themes or plugins to be uploaded to the public WordPress
      theme/plugin repository.
* Added framework for comments template
    * As per requirements of Theme Check, our theme needs to have a comments
      template.
* Cleaned up Alert Notification functionality
* Removed Multiple Content Blocks functionality
    * This was an early attempt at handling asides. The method was very crude.
      The code was removed because we will go in a different direction when we
      introduce asides.
* Other minor bug fixes and code cleanup


== Upgrade Notice ==
= 2.14 =
Use AJAX to fetch CE course information from CampusCE

= 2.13 =
Adds a 'none' option when selecting top navigation in Mayflower Branded
