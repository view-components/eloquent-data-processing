<?php

namespace ViewComponents\Eloquent\Processor;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use ViewComponents\ViewComponents\Data\Operation\PaginateOperation;
use ViewComponents\ViewComponents\Data\Processor\AbstractPaginateProcessor;

class PaginateProcessor extends AbstractPaginateProcessor
{
    /**
     * @param Builder|EloquentBuilder $src
     * @param OperationInterface|PaginateOperation $operation
     * @return mixed
     */
    public function process($src, OperationInterface $operation)
    {

        $src->limit($operation->getPageSize())
            ->offset($this->getOffset($operation));
        return $src;
    }
}
