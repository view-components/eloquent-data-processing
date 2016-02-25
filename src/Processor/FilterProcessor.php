<?php

namespace ViewComponents\Eloquent\Processor;

use Illuminate\Database\Eloquent\Builder;
use ViewComponents\ViewComponents\Data\Operation\FilterOperation;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;
use ViewComponents\ViewComponents\Data\Processor\ProcessorInterface;

class FilterProcessor implements ProcessorInterface
{
    /**
     * @param Builder $src
     * @param OperationInterface|FilterOperation $operation
     * @return mixed
     */
    public function process($src, OperationInterface $operation)
    {
        $value = $operation->getValue();
        $operator = $operation->getOperator();
        $field = $operation->getField();
        $src->where($field, $operator, $value);
        return $src;
    }
}
