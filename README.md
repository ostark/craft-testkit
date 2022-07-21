# 🦠🧑‍🔬 Craft Testkit 

### An opinionated toolset for testing Craft Plugins and Modules

Under the hood 

* Mockery
* PestPHP

---

TODO: 
* Review / refactor the interfaces
* Consider to move the current code under `Mock` namespace
* Add support to test Events
* Add support to test Queue / Jobs



---

It's made for plugins or modules that do not touch the database heavily. In contrast to [fixtures](https://craftcms.com/docs/4.x/testing/testing-craft/fixtures.html) that define a consistent and predictable state of your test dataset, with mocking you can test different scenarios more easily with less setup efforts.

Please mind, if your code relies heavily on database CRUD operations, this is probably not the right tool for your test.

## Setup 

```
cd projects/your-plugin
composer require --dev fortrabbit/craft-testkit
php vendor/bin/testkit-init (TBD)
```

Make sure to load this [tests/_bootstrap.php file](_bootstrap.example.php) with your tests. For PHPUnit your define it in phpunit.xml using the `bootstrap` property or in Codeception your .yml files.


## Write your first test

```php

test('plugin initialize', function () {
    $plugin = plugin(MyPluginClass:class);
    $handle = $plugin->handle;
    
    expect($handle)->toBe('my-handle');
});

test('numberService::rand() returns expected result', function () {
    $plugin = plugin(MyPluginClass:class);
    $result = $plugin->numberService->rand(1, 300);
    
    expect($result)->toBeInt();
    expect($result)->toBeGreaterThanOrEqual(1);
    expect($result)->toBeLessThanOrEqual(300);
});

test('rendered twig template matches snapshot', function () {
    $twig = twig('path/to/partial.twig')
        ->setEvironment(...)
        ->setVars(['x' => 'c'])
        ->setEntry();
        
    $rendered = $twig->render();  
    
    expect($rendered)->toMatchSnapshot()
});


test('events has been fired', function () {
    EventTester::on('*', );
        
    // exec code 
    
    EventTester::assertTrigger(Some::class, Some::EVENT_NAME);
    EventTester::assertHandler(Some::class, Some::EVENT_NAME);
    
});

```

## Helper functions

* `plugin(sting $class)` to initialize your main plugin class
* `twig(string $path)` to render twig pages or partials
* `event()` to test events
* `queue()` to test queue
* `overload()` to mock a class instance that is hardcoded and not injectable

## Mocking

what and why

### Mock Elements

```
fortrabbit\TestKit\Element::make(\craft\elements\Entry::class);
fortrabbit\TestKit\Element::make(\craft\elements\Category::class);

// better interface?
CategoryModel::mock()->using('expectations/Category.php');
CategoryModel::mock()->setExpectations([
    'save' => fn($value) => false,
    'getFoo' => 'foo,  
])

```

### Mock Records

```
fortrabbit\TestKit\Record::make(\craft\elements\Entry::class);
fortrabbit\TestKit\Record::make(\craft\elements\Category::class);
```

### Mock Services  

```
fortrabbit\TestKit\Service::all();
```


### Mock Queries  

```
\fortrabbit\TestKit\Query::make(\craft\db\Query::class);

// better interface?
EntryQuery::mock()->using('expectations/EntryQuery.php');
EntryQuery::mock()->setExpectations([
    'save' => fn($value) => false,
    'getFoo' => 'foo,  
])

```

### Expectations

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
