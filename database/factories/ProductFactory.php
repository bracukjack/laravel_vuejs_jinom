<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama'          => $this->faker->name(),
            'keterangan'    => $this->faker->paragraph(10),
            'harga'         => $this->faker->randomNumber(7, true),
        ];
    }
}
