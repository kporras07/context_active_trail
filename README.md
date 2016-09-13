# Context Active Trail

Context Active Trail sets the active trail and breadcrumbs for a page based on the context it is in. For example, you can make every node of type _article_ appear to live under the _Blog_ menu item.

## Why you should use this module

By default, Drupal 8 only sets the active trail for page that are in a menu. This is great for pages like _About Us_, that will almost always be in a menu. However, this doesn't usually help for types of content that are created often. It's rare to put every single news item or blog post in your menus, even though they logically belong under _News_ or _Blog_.

In Drupal 7, it was common to use the [Context](https://www.drupal.org/project/context) module to set up rules for assigning active trails to each page. So every blog page might appear under _Blog_, or every page with a path like `/contact/*` might appear under _Contact_. This module brings the same functionality to Drupal 8.

## Configuration

You define which contexts are active for each request using the existing [Context UI](https://www.drupal.org/project/context) module. Just go to `admin/structure/context`, and add some contexts! You can use the same sorts of conditions for contexts as you are used to using for block visibility, eg:

* Content type of the current page
* Current path (including wildcards)
* Current language
* Roles of the current user

For each context, this module lets you add a _Reaction_ called _Active trail_. You can choose which menu link should be the active trail for pages that are in this context.

Optionally, you can also allow this module to set the breadcrumbs. If a context puts the page _My blog post_ under _Blog_, the breadcrumb will be set to _Home -> Blog -> My blog post_.

Developers may define new subclasses of [ConditionPluginBase](https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Core%21Condition%21ConditionPluginBase.php/class/ConditionPluginBase/8.2.x) and [ContextProviderInterface](https://api.drupal.org/api/drupal/core!lib!Drupal!Core!Plugin!Context!ContextProviderInterface.php/interface/ContextProviderInterface/8.2.x) to create new types of conditions that can be used by all contexts.

## Limitations

Only a single active trail per context is supported by this module. If for some reason you want the same page to be active in multiple menus (eg: both _Main navigation_ and _Footer_), you'll have to setup multiple contexts.

The breadcrumbs this module generates are not configurable. But maybe you don't want "Home" to appear at the start, or you don't want the current page's title to appear. In that case, you can implement [hook\_system\_breadcrumb\_alter](https://api.drupal.org/api/drupal/core!lib!Drupal!Core!Menu!menu.api.php/function/hook_system_breadcrumb_alter/8.2.x) to modify the breadcrumbs. Alternatively, you can just turn off breadcrumb generation per-context, and use another module or custom code to handle your breadcrumbs.

Drupal 8 only allows a single service to be in charge of active trails. If you use another module that takes over the `menu.active_trail` service, it will likely conflict with this module.

## Relationship to other modules

* [Context and Context UI](https://www.drupal.org/project/context)

    In Drupal 7, these modules allowed you to set the active trail and breadcrumbs based on contexts. But in Drupal 8, they are slimmer modules without that functionality.
    
    Context Active Trail fills that void, as a reaction plugin for Context in Drupal 8. It depends on Context, and is configurable with Context UI. 

* [Menu Position](https://www.drupal.org/project/menu_position)

    This was an alternative module often used to set active trails in Drupal 7. It has not yet been ported to Drupal 8.

* [Menu Trail By Path](https://www.drupal.org/project/menu_trail_by_path)

    This is an alternative to Context Active Trail. It requires no direct configuration at all, but instead relies on the path to figure out what each page's parent is. Usually this requires configuring [Pathauto](https://www.drupal.org/project/pathauto) to generate the paths. This module is very convenient if the paths are strictly hierarchical, but can't handle other cases.
    
    Unfortunately, this module can't be used together with Context Active Trail, since they both want to control the active trails service.
    
* [Menu Breadcrumb](https://www.drupal.org/project/menu_breadcrumb)

    This module offers a more configurable way to set breadcrumbs based on active trails. It can work well together with the active trail part of Context Active Trail.

## Author

This module was developed by Dave Vasilevsky at Evolving Web.
