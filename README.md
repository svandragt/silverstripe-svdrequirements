Controller Requirements (silverstripe-svdrequirements)
============================
THIS CODE IS NOT PRODUCTION TESTED; but feedback on existing developments is welcomed.

This is a wrapper around the included Requirements class that allows any code to inject CSS/Javascript references into a Controller class, even from an Extension.

It minimizes the number of HTTP requests / maximizes caching opportunities compared to plain `Requirements::combine_files()` by deferring the combine_files() method and eases implementation by only having to use a single method.

What Controller Requirements does is make available two methods on page type controllers:

1. `$this->AddRequirement(String $class, String $file)`
2. `$this->AddRequirements(String $class, Array $files)` (wrapper around 1)

## Usage:

1. Extract / clone the package.
2. By default the ControllerRequirementsExtension is attached to Page_Controller, through the config.yml file. 

For example you might have a `Page` and `HomePage extends Page` class, each with requirements. On each you run
`$this->AddRequirements(__CLASS__, $files);` in the `init()` method (`$files` can be a mix of js and css files).

Done!

Controller Requirements will seperate the js from the css files, and combine them on a controller class basis. In our example the site will include the following files:
```
page_controller.css
homepage_controller.css
page_controller.js
homepage_controller.js
```

When the user browser to subsequent pages they will have already downloaded most stylesheets and javascript. For example when navigating to a `Section extends Page`, the browser will have cached the page_controller.* requirements and will only have to download the Section specific assets.

## Module developers
 
When using plain Requirements::combine_files() at the end of the Controller's init() method, no additional requirements can be added afterwards.
This is a problem because now any module with css/js assets will generate their own files.

Instead, Controller Requirements allows module developers to hook their requirements into the pagetypes it is attached to using the following syntax:

```
$this->owner->AddRequirements(get_class($this->owner), $files);
```

## Configuration changes

By default the extension is loaded before mysite which results in the extension's onAfterInit() method to run after  other onAfterInits() in other modules.

You can overrule this configuration but pay attention to the order in which the .yml files are loaded.

I keep a [list of known bugs](https://github.com/svandragt/silverstripe-svdrequirements/issues).


