Class Requirements (silverstripe-svdrequirements)
============================
This is a functionality to make better use of the Requirements functions to include javascript and css assets.
It aims to minimize the number of HTTP requests and maximize caching opportunities whilst making Requirements less confusing to use.

What Class Requirements does is make available two methods on the page types:

1. `ClassRequirement(String $class, String $file)`
2. `ClassRequirements(String $class, Array $files)` (wrapper around 1)

## Usage:

1. Extract / clone the package.
2. By default the ClassRequirementsExtension is attached to Page_Controller, through the config.yml file. 

For example you might have a `Page` and `HomePage extends Page` class, each with requirements. On each you run
`$this->ClassRequirements(__CLASS__, $files);` in the `init()` method (`$files` can be a mix of js and css files).

This will then result in page_controller.css, homepage_controller.css, page_controller.js and homepage_controller.js

When the user browser to subsequent pages they will have already downloaded most stylesheets and javascript.

## Benefits
 
It will manage requirements and after all requirements are collected it will 
create a combined file for each class and each extension.

This optimizes performance as on subsequent pages the requirement for the base class have
already been cached, but still benefits from minimal http requests using combined_files.

It also allows module developers to hook their requirements into the pagetypes using the following syntax:

```
$this->owner->ClassRequirements(get_class($this->owner), $files);
```

## Watch out

You can overrule the configuration but pay attention to the order, by default the extension is loaded before mysite, ironically this means that onAfterInit is ran after all other onAfterInits which may add requirements.




I keep a [list of known bugs](https://github.com/svandragt/silverstripe-svdrequirements/issues).


