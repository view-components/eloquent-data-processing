<?php

namespace ViewComponents\Eloquent;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use ViewComponents\ViewComponents\Data\AbstractDataProvider;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;

class EloquentDataProvider extends AbstractDataProvider
{
    /**
     *
     * @param Builder|EloquentBuilder $src
     * @param OperationInterface[] $operations
     */
    public function __construct($src, array $operations = [])
    {
        $this->operations()->set($operations);
        $this->processingService = new EloquentProcessingService(
            new EloquentProcessorResolver(),
            $this->operations(),
            $src
        );
    }
}
