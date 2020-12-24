<?php
return [
    'section(foo).all()' => [
        'result for: section(foo).all()'
    ],
    'id(3).one()' => [
        'result for: id(3).one()'
    ],
    'where({id:[1,2,3],status:2}).all()' => [
        'result for: where({id:[1,2,3],status:2}).all()'
    ],
    'one()' => entry([
        'id' => 99,
        'siteId' => '123',
        'title' => 'fake'
    ]),

];
