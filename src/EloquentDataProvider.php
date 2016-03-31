<?php

namespace ViewComponents\Eloquent;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use ViewComponents\Eloquent\Exception\InvalidDataSourceException;
use ViewComponents\ViewComponents\Data\AbstractDataProvider;
use ViewComponents\ViewComponents\Data\Operation\OperationInterface;

class EloquentDataProvider extends AbstractDataProvider
{
    /**
     * Constructor.
     *
     * @param Builder|EloquentBuilder|string $src Illuminate\Database\Eloquent\Builder instance
     *                                            or Illuminate\Database\Query\Builder instance
     *                                            or class name of target Eloquent model
     * @param OperationInterface[] $operations
     */
    public function __construct($src, array $operations = [])
    {
        $src = $this->validateSource($src);
        $this->operations()->set($operations);
        $this->processingService = new EloquentProcessingService(
            new EloquentProcessorResolver(),
            $this->operations(),
            $src
        );
    }

    protected function validateSource($src)
    {
        if ($src instanceof EloquentBuilder || $src instanceof Builder) {
            return $src;
        }

        if (is_string($src) && class_exists($src) && is_a($src, Model::class, true)) {
            /** @var  Model $model */
            $model = new $src;
            return $model->newQuery();
        }

        throw InvalidDataSourceException::forSrc($src);
    }
}
