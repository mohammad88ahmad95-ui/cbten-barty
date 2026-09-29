<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory {
    protected $model = User::class;
    public function definition(): array {
        return ['id' => (string) Str::uuid(),
            'phone' => '+9639' . $this->faker->numberBetween(10000000, 99999999),
            'status' => 'active', 'locale' => 'ar'];
    }
}
