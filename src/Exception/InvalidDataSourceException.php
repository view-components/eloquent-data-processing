<?php

namespace ViewComponents\Eloquent\Exception;

use InvalidArgumentException;

class InvalidDataSourceException extends InvalidArgumentException implements EloquentDataProcessingExceptionInterface
{
    public static function forSrc($src)
    {
        if (is_string($src)) {
            $srcName = $src;
        } elseif (is_object($src)) {
            $srcName = get_class($src) . ' instance';
        } else {
            $srcName = gettype($src);
        }
        return new static(
            'Invalid data source, EloquentDataProvider constructor should be used with'
            . ' Illuminate\Database\Eloquent\Builder instance'
            . ' or Illuminate\Database\Query\Builder instance'
            . ' or class name of target Eloquent model'
            . "($srcName given)."
        );
    }
}
