<?php

namespace Database\Factories;

use App\Models\Deduction;
use App\Models\Donor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Deduction>
 */
class DeductionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * لا يُولَّد "month" هنا عشوائياً؛ يجب أن يمرّره الاستدعاء صراحةً
     * (donor_id وmonth) لتفادي خرق القيد الفريد المركّب (donor_id, month).
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'donor_id' => Donor::factory(),
            'month' => now()->startOfMonth(),
            'amount' => fake()->numberBetween(2, 40) * 50,
            'due_date' => now()->startOfMonth()->addMonth()->day(5),
            'status' => 'pending',
            'paid_at' => null,
            'confirmed_by' => null,
        ];
    }

    /**
     * حالة استقطاع مدفوع.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'paid_at' => now(),
            'confirmed_by' => User::factory(),
        ]);
    }
}
