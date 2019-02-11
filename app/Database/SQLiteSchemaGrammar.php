<?php

namespace App\Database;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\SQLiteGrammar as BaseSQLiteGrammar;
use Illuminate\Support\Fluent;

class SQLiteSchemaGrammar extends BaseSQLiteGrammar
{
    public function __construct()
    {
        $this->modifiers[] = 'String';
    }

    /**
     * Make all strings in migration case insensitive on search
     *
     * @param \Illuminate\Database\Schema\Blueprint $blueprint
     * @param \Illuminate\Support\Fluent            $column
     *
     * @return string|null
     */
    public function modifyString(Blueprint $blueprint, Fluent $column)
    {
        if ($column->type === 'string') {
            return ' COLLATE NOCASE';
        }
    }
}
