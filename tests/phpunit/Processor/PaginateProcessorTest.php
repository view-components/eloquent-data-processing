<?php

namespace ViewComponents\Eloquent\Test\Processor;

use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Eloquent\Test\Mock\TestUser;
use ViewComponents\ViewComponents\Data\Operation\PaginateOperation;
use Illuminate\Database\Capsule\Manager as DB;

class PaginateProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $recordsQty = TestUser::all()->count();
        if ($recordsQty <= 5) {
            throw new \Exception("Can't test PaginateProcessor: not enough fixture data");
        }
        $provider =  new EloquentDataProvider(TestUser::class);
        $provider->operations()->add(new PaginateOperation(1,3));
        $data = iterator_to_array($provider);
        $id1 = array_first($data)->id;
        self::assertEquals(3, count($data));

        $provider =  new EloquentDataProvider(DB::table((new TestUser)->getTable()));
        $provider->operations()->add(new PaginateOperation(2,2));
        $data = iterator_to_array($provider);
        self::assertEquals(2, count($data));

        $id2 = array_first($data)->id;
        self::assertTrue($id2 > 0 && $id2 > 0 && $id1 !== $id2);
    }
}
