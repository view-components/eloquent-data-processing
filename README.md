 ![Logo](https://raw.githubusercontent.com/view-components/logo/master/view-components-logo-without-text-42.png) ViewComponents\EloquentDataProcessing
=====

[![Release](https://img.shields.io/packagist/v/view-components/eloquent-data-processing.svg)](https://packagist.org/packages/view-components/eloquent-data-processing)
[![Build Status](https://travis-ci.org/view-components/eloquent-data-processing.svg?branch=master)](https://travis-ci.org/view-components/eloquent-data-processing)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/view-components/eloquent-data-processing/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/view-components/eloquent-data-processing/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/view-components/eloquent-data-processing/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/view-components/eloquent-data-processing/?branch=master)

Eloquent ORM support for ViewComponents


## Table of Contents
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [Testing](#testing)
- [Security](#security)
- [License](#license)


## Requirements

* PHP 5.5+ (hhvm & php7 are supported)


## Installation

The recommended way of installing the component is through [Composer](https://getcomposer.org).

Run following command:

```bash
composer require view-components/eloquent-data-processing
```

## Usage

### Creating Data Provider

EloquentDataProvider supports 3 types of data sources:

- Illuminate\Database\Eloquent\Builder instance (database query builder created from model)
- Illuminate\Database\Query\Builder instance (standard database query builder, don't know about models)
- Class name of Eloquent model

#### Using Class Name of Eloquent Model as Data Source

```php
use MyApp\UserModel;
use ViewComponents\Eloquent\EloquentDataProvider;
$provider = new EloquentDataProvider(UserModel::class);
```

If you use class name of Eloquent model as data source,
the only way to modify database query is specifying data provider operations:


```php
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;

$provider->operations()->add(
    new FilterOperation('role', FilterOperation::OPERATOR_EQ, 'Manager')
);
```
#### Using Illuminate\Database\Eloquent\Builder as Data Source

```php
use ViewComponents\Eloquent\EloquentDataProvider;

$provider = new EloquentDataProvider((new MyApp\UserModel)->newQuery());
```

It's possible to specify query parts before creating EloquentDataProvider
but note that some parts of query may be changed by data provider operations. 

```php
use ViewComponents\Eloquent\EloquentDataProvider;

$query = MyApp\UserModel
            ::where('role', '=', 'Manager')
            ->where('company', '=', 'Facebook')
            ->orderBy('id');

$provider = new EloquentDataProvider($query);
```

#### Using Illuminate\Database\Query\Builder as Data Source

It's possible to use EloquentDataProvider if you not deal with Eloquent models.

```php
use DB;
use ViewComponents\Eloquent\EloquentDataProvider;

$provider = new EloquentDataProvider(
    DB::table('users')->where('name', '=', 'David')
);
```

### Data Provider Operations

Eloquent Data provider modifies database query when it has operations.

Use operations() method for accessing operations collection.

Documentation related to collections can be found [here](https://github.com/Nayjest/Collection).

Example of adding operation:

```php
$provider
    ->operations()
    ->add(new SortOperation('id', SortOperation::ASC));

```

Also operations can be specified on data provider creation:

```php

use MyApp\UserModel;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;

$provider = new EloquentDataProvider(
    UserModel::class
    [
        new FilterOperation('role', FilterOperation::OPERATOR_EQ, 'Manager')
        new SortOperation('id', SortOperation::DESC),
    ]
);
```

### Extracting data

Data providers implements IteratorAggregate interface, so you can iterate it like array:
```php

use MyApp\UserModel;
use ViewComponents\Eloquent\EloquentDataProvider;

$provider = new EloquentDataProvider(UserModel::class);
foreach ($provider as $user) {
   var_dump($user); // instance of UserModel
}

```
Data provider executes DB query when getIterator() method is called or when iteration begins in case if data is not loaded yet,
i. e. calling getIterator() twice will not produce 2 database queries.
But changing operations collection will cause resetting cache:

```php

use MyApp\UserModel;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;

$provider = new EloquentDataProvider(UserModel::class);
// databse query will be executed 
$provider->getIterator();

// databse query will not be executed again, iterating over same data 
$provider->getIterator();

$provider->operations->add(
  new FilterOperation('id', FilterOperation::OPERATOR_LTE, 5)
)
// databse query will be executed again
$provider->getIterator();

```


## Contributing

Please see [Contributing Guidelines](contributing.md) and [Code of Conduct](code_of_conduct.md) for details.


## Testing

This package bundled with unit tests (PHPUnit).

To run tests locally, you must install this package as stand-alone project with dev-dependencies:

```bash
composer create-project view-components/eloquent-data-processing
```

Command for running tests:

```bash
composer test
```


## Security

If you discover any security related issues, please email mail@vitaliy.in instead of using the issue tracker.


## License

© 2015 &mdash; 2016 Vitalii Stepanenko

Licensed under the MIT License.

Please see [License File](LICENSE) for more information.
