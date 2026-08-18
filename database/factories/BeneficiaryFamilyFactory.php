<?php

namespace Database\Factories;

use App\Models\BeneficiaryFamily;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BeneficiaryFamily>
 */
class BeneficiaryFamilyFactory extends Factory
{
    /**
     * أسماء العائلات.
     *
     * @var array<int, string>
     */
    protected static array $familyNames = [
        'القحطاني', 'الغامدي', 'العتيبي', 'الدوسري', 'الحربي', 'المطيري',
        'الشمري', 'الزهراني', 'العنزي', 'السبيعي', 'الشهري', 'البقمي',
        'الجهني', 'السلمي', 'العمري', 'الشريف',
    ];

    /**
     * عدّاد ثابت لضمان تفرد رقم الهوية الوطنية.
     */
    protected static int $nationalIdSequence = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'family_name' => 'أسرة '.fake()->randomElement(static::$familyNames),
            'national_id' => $this->generateNationalId(),
            'members_count' => fake()->numberBetween(2, 12),
            'housing_program' => fake()->randomElement(['ترميم', 'بناء ذاتي', 'إيجار مدعوم', 'وحدة سكنية']),
            'status' => fake()->boolean(85) ? 'active' : 'inactive',
        ];
    }

    /**
     * توليد رقم هوية وطنية من عشر خانات مضمون التفرد.
     */
    protected function generateNationalId(): string
    {
        static::$nationalIdSequence++;

        $prefix = fake()->randomElement(['1', '2']);

        return $prefix.str_pad((string) static::$nationalIdSequence, 9, '0', STR_PAD_LEFT);
    }
}
