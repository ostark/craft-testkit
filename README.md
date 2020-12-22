# Mockery for Craft Plugins and Modules

This package helps with mocking objects in Craft using Mockery.
It's made for plugins or modules that do not touch the database heavily. In contrast to [fixtures](https://craftcms.com/docs/3.x/testing/testing-craft/fixtures.html) that define a consistent and predictable state of your test dataset, with mocking you can test different scenarios more easily with less setup efforts.

Please mind, if your code relies heavily on database CRUD operations, this is probably not the right tool for your test.

## Setup 

```
cd projects/your-plugin
composer require --dev ostark/craft-mockery
```

Make sure to load this [tests/_bootstrap.php file](_bootstrap.example.php) with your tests. For PHPUnit your define it in phpunit.xml using the `bootstrap` property or in Codeception your .yml files.

## Mock Elements

Assuming you have a class `NavigationService` with a method `getTopLevelCategories()`. Within this method you call
`$categories = \craft\elements\Category::find().level(1).all();` 

```
```


## Mock Records

```
```

## Mock Services  

```
```


# WIP 

* spies
* flexible path
