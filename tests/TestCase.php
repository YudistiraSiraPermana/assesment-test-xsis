<?php

namespace Tests;

use App\Traits\PrepareForUnitTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase, WithFaker, PrepareForUnitTest;

    /**
     * @throws Exception
     */
    protected function tearDown(): void
    {
        // Truncate All Tables
        $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($tableNames as $name) {
            //if you don't want to truncate migrations
            if ($name == 'migrations') {
                continue;
            }
            $this->truncateTable($name);
        }

        parent::tearDown();
    }
}
