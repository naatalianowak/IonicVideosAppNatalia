<?php

namespace Database\Factories;

use App\Models\Multimedia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Multimedia>
 */
class MultimediaFactory extends Factory
{
    protected $model = Multimedia::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['video', 'photo']);
        $fileExtension = $type === 'video' ? 'mp4' : 'jpg';
        $filePath = "multimedia/{$this->faker->uuid}.{$fileExtension}";

        return [
            'title' => $this->faker->sentence(3), // Genera un títol de 3 paraules
            'file_path' => $filePath, // Simula un camí d'arxiu
            'type' => $type, // 'video' o 'photo'
            'user_id' => User::factory(), // Crea un usuari associat
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
