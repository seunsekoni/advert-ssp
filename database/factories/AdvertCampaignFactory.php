<?php

namespace Database\Factories;

use App\Models\AdvertCampaign;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertCampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdvertCampaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'start_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'end_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'total_budget' => 1200,
            'daily_budget' => 240000,
        ];
    }
}
