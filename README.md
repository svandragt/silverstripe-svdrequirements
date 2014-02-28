SvdRequirements
============================
This is a convenience extension enforcing best practices for using Requirements.

## Features:

* Combine a mixed list of JS / CSS assets using a single method.
* Access to the `$this->theme_dir` variable in your page controllers.

SvdRequirements will seperate the js from the css files, and combine them for each controller.

## Usage:

1. Install using composer: `composer require "svandragt/silverstripe-svdrequirements:*"`

Example: you might have a `Page` and `HomePage extends Page` class, each with dozen JS and CSS requirements. Add
`SvdRequirements::combine($assets);` to each init method.

Done!

In our example the site will now have the following files:
```
page_controller.css
homepage_controller.css
page_controller.js
homepage_controller.js
```

## Quick access to theme folder

This optional SvdRequirementsExtension (enabled by default) adds a shortcut to the theme folder by setting a `$theme_dir` property to the Page_controller which you can access through `$this->theme_dir` - which would return 'themes/simple' for example. 

You can convert the simple theme to use requirements in 2 steps:

1. Remove all calls to CSS and JS from the templates. 
2. to the Page's init() method add the following code:

```php
		$assets = array(
			"{$this->theme_dir}/css/reset.css",
			"{$this->theme_dir}/css/layout.css",
			"{$this->theme_dir}/css/typography.css",
			"{$this->theme_dir}/css/form.css",
			"{$this->theme_dir}/javscript/script.js",
		);
		SvdRequirements::combine($assets);
```

I keep a [list of known bugs](https://github.com/svandragt/silverstripe-svdrequirements/issues).


