<?php

namespace Database\Factories;

use App\Models\Cargo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CargoFactory extends Factory
{
    protected $model = Cargo::class;

    public function definition()
    {
        return [
			'nombre' => $this->faker->name,
			'descripción' => $this->faker->name,
			'salario' => $this->faker->name,
			'empleado_id' => $this->faker->name,
        ];
    }
}
