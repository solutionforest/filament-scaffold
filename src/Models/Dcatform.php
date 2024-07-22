<?php

namespace Solutionforest\FilamentScaffold\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dcatform extends Model
{
    use HasFactory;

    public static function getAllTableNames()
    {
        $tables = DB::select('SHOW TABLES');

        return array_map('current', $tables);
    }
}
