<?php

namespace ViewComponents\Eloquent\Test\Processor;

use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Eloquent\Test\Mock\TestUser;
use ViewComponents\ViewComponents\Test\Data\AbstractFilterTest;

require __DIR__ .'/../../../vendor/view-components/view-components/tests/phpunit/Data/AbstractFilterTest.php';

class FilterProcessorTest extends AbstractFilterTest
{
    protected function getDataProvider()
    {
        return new EloquentDataProvider(TestUser::class);
    }
}