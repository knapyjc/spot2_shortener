<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShortUrlFactory extends Factory
{
    protected $model = \App\Models\ShortUrl::class;

    public function definition()
    {
        return [
            'original_url' => $this->faker->url,
            'short_code' => Str::random(8),
            'clicks' => 0,
        ];
    }
}
