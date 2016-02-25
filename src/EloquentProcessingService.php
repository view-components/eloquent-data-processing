<?php

namespace ViewComponents\Eloquent;

use ArrayIterator;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use RuntimeException;
use Traversable;
use ViewComponents\ViewComponents\Data\ProcessingService\AbstractProcessingService;

/**
 * Class DbTableProcessingManager.
 */
class EloquentProcessingService extends AbstractProcessingService
{
    /**
     * @param Builder|EloquentBuilder $data
     * @return Traversable
     */
    protected function afterOperations($data)
    {
        if ($data instanceof EloquentBuilder) {
            return $data->get();
        } elseif ($data instanceof Builder) {
            return new ArrayIterator($data->get());
        }
        throw new RuntimeException('Unsupported type of data source.');
    }

    /**
     * @param Builder|EloquentBuilder $data
     * @return Builder|EloquentBuilder
     */
    protected function beforeOperations($data)
    {
        return clone $data;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->applyOperations(
            $this->beforeOperations($this->dataSource)
        )->count();
    }
}
