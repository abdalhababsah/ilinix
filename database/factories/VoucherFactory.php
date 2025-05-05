<?php
namespace Database\Factories;

use App\Models\Voucher;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoucherFactory extends Factory
{
    protected $model = Voucher::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->bothify('VOUCHER-####')),
            'provider' => $this->faker->company,
            'issued_to_id' => User::factory(),
            'issued_at' => now()->subDays(3),
            'used' => $this->faker->boolean,
            'used_at' => $this->faker->boolean ? now() : null,
            'notes' => $this->faker->sentence,
        ];
    }
}