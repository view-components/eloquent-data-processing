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
        switch ($operator) {
            case FilterOperation::OPERATOR_STR_STARTS_WITH:
                $operator = FilterOperation::OPERATOR_LIKE;
                $value .= '%';
                break;
            case FilterOperation::OPERATOR_STR_ENDS_WITH:
                $operator = FilterOperation::OPERATOR_LIKE;
                $value = '%' . $value;
                break;
            case FilterOperation::OPERATOR_STR_CONTAINS:
                $operator = FilterOperation::OPERATOR_LIKE;
                $value = '%' . $value . '%';
                break;
            case FilterOperation::OPERATOR_SET_CONTAINS:
                $values = is_array($value)
                    ? $value
                    : array_map(function($value){
                        return trim($value);
                    }, preg_split('/[\n\t\,\|\s]+/', trim($value))
                );

                $src->whereIn($field, $values);
                return $src;
        }
        $src->where($field, $operator, $value);
        return $src;
    }
}
