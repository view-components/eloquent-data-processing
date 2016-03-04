<?php

namespace ViewComponents\Eloquent;

use ViewComponents\Eloquent\Processor\FilterProcessor;
use ViewComponents\Eloquent\Processor\PaginateProcessor;
use ViewComponents\Eloquent\Processor\SortProcessor;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Data\Operation\PaginateOperation;
use ViewComponents\ViewComponents\Data\Operation\SortOperation;
use ViewComponents\ViewComponents\Data\ProcessorResolver\ProcessorResolver;

class EloquentProcessorResolver extends ProcessorResolver
{
    public function __construct()
    {
        $this
            ->register(SortOperation::class, SortProcessor::class)
            ->register(FilterOperation::class, FilterProcessor::class)
            ->register(PaginateOperation::class, PaginateProcessor::class)
        ;
    }
}
