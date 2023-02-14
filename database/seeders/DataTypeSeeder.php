<?php

namespace Database\Seeders;

use App\Models\Master_DataType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class DataTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Master_DataType::create(['name' => 'Text',      'created_by' => 'seed', 'updated_by' => 'seed', 'data_type' => 'VARCHAR(255)']);
        Master_DataType::create(['name' => 'Longtext',  'created_by' => 'seed', 'updated_by' => 'seed', 'data_type' => 'TEXT']);
        Master_DataType::create(['name' => 'Number',    'created_by' => 'seed', 'updated_by' => 'seed', 'data_type' => 'BIGINT(20)']);
        Master_DataType::create(['name' => 'Time',      'created_by' => 'seed', 'updated_by' => 'seed', 'data_type' => 'TIME']);
        Master_DataType::create(['name' => 'Date',      'created_by' => 'seed', 'updated_by' => 'seed', 'data_type' => 'DATE']);
        Master_DataType::create(['name' => 'Yes/No',    'created_by' => 'seed', 'updated_by' => 'seed', 'data_type' => 'VARCHAR(1)']);
        Master_DataType::create(['name' => 'File',      'created_by' => 'seed', 'updated_by' => 'seed', 'data_type' => 'VARCHAR(255)']);
        Master_DataType::create(['name' => 'Checklist', 'created_by' => 'seed', 'updated_by' => 'seed', 'data_type' => 'TEXT']);
        Master_DataType::create(['name' => 'Today Date','created_by' => 'seed', 'updated_by' => 'seed', 'data_type' => 'DATE']);
    }
}
