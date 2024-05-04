<?php

use Illuminate\Support\Facades\DB;

if (! function_exists('verificationForeign')) {
    function verificationForeign($column, $id)
   {

        $tables = "SELECT tablename FROM pg_tables WHERE schemaname = 'public';";

        $tables = DB::select( $tables );

        foreach ($tables as $table) {
            $schema = "SELECT count(*) as qtd
                        FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '$table->tablename' AND column_name = '$column';";
            $schema = DB::select( $schema );

            if (!empty($schema[0]->qtd)) {
                return true;
            }

        }

        return false;

    }
}