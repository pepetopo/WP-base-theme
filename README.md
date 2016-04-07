# WP NordStarter

## Installation/Usage

1. Clone the repo to WP `themes`-dir, rename the cloned dir, `cd` into and remove `.git`
2. Search-and-replace all occurences on `NordStarter` (the package name) and `nord_` (the function-prefix) to something project-specific
3. Change `package.json` config-section to suit your needs. The `themeHeader` will be injected to `style.css` and is responsible for registering and naming the theme in WP-admin:

```json
"config": {
  "paths": {
    "build": "./assets/build",
    "source": "./assets"
  },
  "devUrl": "http://mylocalurl.dev",
  "themeHeader": [
    "/*",
    "Theme Name: WP-NordStarter",
    "Theme URI: http://nordsoftware.com",
    "Author: Nord Sorftware",
    "Author URI: http://nordsoftware.com",
    "Description: WP-NordStarter",
    "Version: 1.0",
    "License: GNU General Public License v2 or later",
    "License URI: http://www.gnu.org/licenses/gpl-2.0.html",
    "Tags: none",
    "Text Domain: nord",
    "*/"
  ]
},
```

4. Run `npm install && bower install` to install front-end-depencies
5. Run `npm start` to start `gulp` to watch & rebuild on asset changes. Navigate to http://localhost:3000 to see it in action (You have to configure the configs `devUrl` to correctly proxy to `http://localhost:3000`).

## Folder Structure

```
├── 1. assets
│   ├── admin
│   │   ├── backend.js
│   │   └── backend.scss
│   ├── build
│   ├── images
│   ├── js
│   │   ├── main
│   │   └── vendor
│   ├── styles
│   │   ├── common
│   │   ├── components
│   │   ├── layouts
│   │   ├── vendor
│   │   ├── editor-style.scss
│   │   └── main.scss
|
├── 2. library
│   ├── classes
│   │   ├── wordpress-bem
│   │   ├── Breadcrumbs.php
│   │   ├── CPT-base.php
│   │   ├── Hooks.php
│   │   ├── Initalization.php
│   │   ├── Settings.php
│   │   ├── Utils.php
│   │   └── WP-navwalker.php
│   ├── custom-posts
│   ├── functions
│   ├── lang
│   ├── metaboxes
│   ├── tasks
│   └── widgets
|
├── 3. partials
│   ├── components
│   ├── content-excerpt.php
│   ├── content-page.php
│   ├── content-search.php
│   ├── content-single.php
│   ├── content.php
│   ├── no-results-404.php
│   ├── no-results-search.php
│   └── no-results.php
|
├── 4. templates
├── .bowerrc
├── .jcsrc
├── .jshintrc
├── 404.php
├── archive.php
├── bower.json
├── editor-style.css
├── footer.php
├── functions.php
├── gulpfile.js
├── header.php
├── index.php
├── package.json
├── page.php
├── screenshot.png
├── search.php
├── searchfrom.php
├── sidebar.php
├── single.php
└── style.css
```

**1. assets**
Place your images, styles & javascripts here (they get smushed and build to `build`-folder on gulp-process). Javascripts are build to `backend.min.js` (WP-admin-scripts), `vendor.min.js` (the vendor files from bower and `js/vendor`-dir) and `main.js.min` (the main js-file).

`styles`-dir is divided into smaller sections, each with it's responsibilities:
* `common`: Global functions, settings, mixins & fonts
* `components`: Single components, e.g. buttons, breadcrumbs, paginations etc.
* `layouts`: General layouts for header, different pages, sidebar(s), footer etc.
* `vendor`: 3rd. party components etc. which are not installed through bower or npm.

**2. library**
* `classes`: Holds the helper & utility-classes and is autorequired in `functions.php`
* `custom-posts`: Place your custom posts here. See example usage in `books.php.tpl`
* `functions`: Misc. helper functions can be added here
* `lang`: i18n for the theme
* `metaboxes`: Metabox-logic (CMB2 etc.) which is not tied to post-types can be added here
* `tasks`: Gulp-tasks
* `widgets`: WP-nav menus & widgets

**3. partials**
Partial files used by wrappers. Place additional partial components to `components`-folder

**4. templates**
Add your custom WP template-files here.

## Build
Build the front-end depencies without sourcemaps by running `npm run build`.

## Support

If you run any trouble, ask ville.ristimaki@nordsoftware.com. He should know the correct answers. If not, you can always ask Niklas. He knows everything.
