<?php

namespace Database\Factories;

use App\Models\SiteMap;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class SiteMapFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SiteMap::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;
        $slug = Str::slug($title);
        return [
            'title' => $title,
            'slug'  => $slug,
            'body'  => $this->faker->paragraph(10) 
        ];
    }
}
