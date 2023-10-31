<?php

namespace App\Traits;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait PrepareForUnitTest
{
    /**
     * @param string $table
     * @return void
     */
    protected function truncateTable($table): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table($table)->truncate();
        Schema::enableForeignKeyConstraints();
    }
}
