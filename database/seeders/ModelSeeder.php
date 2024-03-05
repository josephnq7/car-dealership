<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

abstract class ModelSeeder extends Seeder
{
    protected int $count = 50;
    protected string $model;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->model::factory()->count($this->count)->create();
    }

}
