<?php

namespace Database\Factories;

use App\Models\BarangKategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangKategoriFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BarangKategori::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_toko' => $this->faker->randomDigitNotNull,
        'kode' => $this->faker->word,
        'kategori' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
