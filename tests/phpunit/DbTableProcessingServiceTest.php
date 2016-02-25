<?php

namespace ViewComponents\Eloquent\Test;

use ViewComponents\Eloquent\EloquentProcessingService;
use ViewComponents\Eloquent\EloquentProcessorResolver;
use ViewComponents\Eloquent\Test\Mock\TestUser;
use ViewComponents\ViewComponents\Data\OperationCollection;
use ViewComponents\ViewComponents\Test\Data\AbstractProcessingServiceTest;

require __DIR__ .'/../../vendor/view-components/view-components/tests/phpunit/Data/AbstractProcessingServiceTest.php';

class DbTableProcessingServiceTest extends AbstractProcessingServiceTest
{
    public function setUp()
    {
        $this->data = (new TestUser())->newQuery();
        $this->operations = new OperationCollection();
        $this->service = new EloquentProcessingService(
            new EloquentProcessorResolver(),
            $this->operations,
            $this->data
        );
        $this->totalCount =  (new TestUser())->newQuery()->get()->count();
    }
}