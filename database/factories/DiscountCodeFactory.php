<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DiscountCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $code = 'JQKA'.rand(1,30);
        $type = rand(0, 1);
        $discount_amount = rand(10,40);
        $min_amount = $discount_amount;
        $now = Carbon::now();
        $starts_at = Carbon::createFromFormat('Y-m-d H:i:m', $now);
        $expires_at = Carbon::now()->addDays(2);
        return [
            'code' => $code,
            'name' => "Dummy pro",
            'description' => 'Event Test',
            'max_uses' => 10,
            'max_uses_user' => 10,
            'type' => $type == 0 ? "fixed" : "percent",
            'discount_amount' => $discount_amount,
            'min_amount' => $min_amount,
            'status' => rand(0,1),
            'starts_at' => $starts_at,
            'expires_at' => $expires_at,
        ];
    }
}
