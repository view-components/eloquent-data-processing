<?php

namespace ViewComponents\Eloquent\Processor;

use Illuminate\Database\Eloquent\Builder;
use Presentation\Framework\Data\Operation\FilterOperation;
use Presentation\Framework\Data\Operation\OperationInterface;
use Presentation\Framework\Data\Processor\ProcessorInterface;

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
