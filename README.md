# Rosmaro and Symfony
[![travis](https://travis-ci.org/lukaszmakuch/rosmaro-sf.svg)](https://travis-ci.org/lukaszmakuch/rosmaro-sf)
## RosmaroSfSessionStorage
Store all information about states in a session managed by the HttpFoundation component.
```php
use \lukaszmakuch\RosmaroSf\RosmaroSfSessionStorage;

$storage = new RosmaroSfSessionStorage(
    $symfonySessionObject,
    "used_prefix"
);
```
## Composer
```
$ composer require lukaszmakuch/rosmaro-sf
```
