<?php

use Illuminate\Database\Seeder;
use App\Enums\FieldType;

class FieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $types = FieldType::getValues();
        foreach ($types as $type) {
            factory(App\Field::class, [
                'type' => $type,
            ])->create();
        }
    }
}
