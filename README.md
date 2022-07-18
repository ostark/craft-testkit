# 🦠🧑‍🔬 Testkit is an opinionated toolset for Craft Plugins and Modules 

Under the hood 

* Mockery
* PestPHP

...

It's made for plugins or modules that do not touch the database heavily. In contrast to [fixtures](https://craftcms.com/docs/3.x/testing/testing-craft/fixtures.html) that define a consistent and predictable state of your test dataset, with mocking you can test different scenarios more easily with less setup efforts.

Please mind, if your code relies heavily on database CRUD operations, this is probably not the right tool for your test.

## Setup 

```
cd projects/your-plugin
composer require --dev fortrabbit/craft-mockery
```

Make sure to load this [tests/_bootstrap.php file](_bootstrap.example.php) with your tests. For PHPUnit your define it in phpunit.xml using the `bootstrap` property or in Codeception your .yml files.

## Mock Elements

```
fortrabbit\TestKit\Element::make(\craft\elements\Entry::class);
fortrabbit\TestKit\Element::make(\craft\elements\Category::class);

// better interface?
CategoryModel::mock();
CategoryModel::mock()->using('expectations/Category.php');
CategoryModel::mock()->setExpectations([
    'save' => fn($value) => false,
    'getFoo' => 'foo,  
])

```

## Mock Records

```
fortrabbit\TestKit\Record::make(\craft\elements\Entry::class);
fortrabbit\TestKit\Record::make(\craft\elements\Category::class);
```

## Mock Services  

```
fortrabbit\TestKit\Service::all();
```


## Mock Queries  

```
\fortrabbit\TestKit\Query::make(\craft\db\Query::class);

// better interface?
EntryQuery:mock();
EntryQuery::mock()->using('expectations/EntryQuery.php');
EntryQuery::mock()->setExpectations([
    'save' => fn($value) => false,
    'getFoo' => 'foo,  
])

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
