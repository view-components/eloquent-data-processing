<?php

namespace ViewComponents\Eloquent\Test;

use PHPUnit_Framework_TestCase;
use ViewComponents\Eloquent\EloquentDataProvider;
use ViewComponents\Eloquent\Test\Mock\TestUser;
use ViewComponents\TestingHelpers\Test\DefaultFixture;
use Illuminate\Database\Capsule\Manager as DB;

class DataSourceSupportTest extends PHPUnit_Framework_TestCase
{
    public function testNewEloquentBuilder()
    {
        $provider = new EloquentDataProvider((new TestUser())->newQuery());
        self::assertEquals(
            DefaultFixture::getTotalCount(),
            $provider->count()
        );
    }

    public function testEloquentBuilderWithPreCondition()
    {
        $provider = new EloquentDataProvider(TestUser::where('name', '=', 'David'));
        self::assertEquals(
            1,
            $provider->count()
        );
    }

    public function testModelName()
    {
        $provider = new EloquentDataProvider(TestUser::class);
        self::assertEquals(
            DefaultFixture::getTotalCount(),
            $provider->count()
        );
    }

    public function testDatabaseQueryBuilder()
    {
        $provider = new EloquentDataProvider(DB::table('test_users'));
        self::assertEquals(
            DefaultFixture::getTotalCount(),
            $provider->count()
        );
    }

    public function testDatabaseQueryBuilderWithPreCondition()
    {
        $provider = new EloquentDataProvider(
            DB
                ::table('test_users')
                ->where('name', '=', 'David')
                ->orderBy('id')
        );
        self::assertEquals(
            1,
            $provider->count()
        );
    }
}
