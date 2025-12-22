<?php

namespace Database\Factories;

use App\Models\Office;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropertyFactory extends Factory
{
    public function definition(): array
    {
        $isSell = $this->faker->boolean(70);
        $isRent = !$isSell || $this->faker->boolean(30);

        return [
            'ulid' => (string) Str::ulid(),
            'intern_reference' => 'REF-' . strtoupper($this->faker->bothify('??###')),
            'title' => $this->faker->sentence(3),
            'street' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'zip_code' => $this->faker->postcode(),
            'is_active' => $this->faker->boolean(90),
            'is_sell' => $isSell,
            'is_rent' => $isRent,
            'sell_price' => $isSell ? $this->faker->numberBetween(80000, 800000) : null,
            'rental_price' => $isRent ? $this->faker->numberBetween(500, 3000) : null,
            'built_m2' => $this->faker->numberBetween(40, 300),
            'office_id' => Office::inRandomOrder()->first()->id ?? 1,
            'property_type_id' => PropertyType::inRandomOrder()->first()->id ?? 1,
            'user_id' => User::inRandomOrder()->first()->id ?? 1,
            'location_id' => \App\Models\Location::factory(),
            'region_id' => \App\Models\Region::factory(),
            'municipality_id' => \App\Models\Municipality::factory(),
            'district_id' => \App\Models\District::factory(),
            'neighborhood_id' => \App\Models\Neighborhood::factory(),
        ];
    }
}
