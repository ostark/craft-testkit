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

```
ostark\CraftMockery\Element::make(\craft\elements\Entry::class);
ostark\CraftMockery\Element::make(\craft\elements\Category::class);
```

## Mock Records

```
ostark\CraftMockery\Record::make(\craft\elements\Entry::class);
ostark\CraftMockery\Record::make(\craft\elements\Category::class);
```

## Mock Services  

```
ostark\CraftMockery\Service::all();
```


## Mock Queries  

```
\ostark\CraftMockery\Query::make(\craft\db\Query::class);
```

## Expectations

The actual results are stored in simple php files which named after the class name.
The location for these files is `tests/expectations`. Here is an example of an `Entry.php` file:

```php
<?php

return [
    'section(foo).all()' => [
        entry([
            'id' => 1,
            'title' => 'Fake title'
        ]),
        entry([
            'id' => 2,
            'title' => 'Another fake title'
        ])
    ],
    'one()' => entry([
        'id' => 99,
        'siteId' => 123,
        'title' => 'fake'
    ]),
];
```

The keys in this array match with the chained methods of the query. To construct the values which are model objects, there are helper functions available:
`entry()` and `record()`.
