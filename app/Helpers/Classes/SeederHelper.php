<?php namespace App\Helpers\Classes;

use Carbon, DB;
use Illuminate\Database\Seeder;

/**
 * Seeder Helper save or update data in table fill created at and updated at
 *
 * Class SeederHelper
 */
class SeederHelper extends Seeder
{

    /**
     * Save or update database records
     *
     * @param $table
     * @param $attributes
     */
    public function saveOrUpdate($table, $attributes)
    {
        foreach ($attributes as $attr) {
            $record = DB::table($table)->find($attr['id']);

            if ($record != null) {
                $attr['updated_at'] = Carbon::now();
                if ($record->created_at == null) {
                    $attr['created_at'] = Carbon::now();
                }

                DB::table($table)->updateOrInsert(['id' => $attr['id']], $attr);
            } else {
                $attr['created_at'] = Carbon::now();

                DB::table($table)->updateOrInsert(['id' => $attr['id']], $attr);
            }
        }
    }
}
