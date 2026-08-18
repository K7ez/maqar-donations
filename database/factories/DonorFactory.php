<?php

namespace Database\Factories;

use App\Models\Donor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Donor>
 */
class DonorFactory extends Factory
{
    /**
     * أسماء أولى سعودية شائعة.
     *
     * @var array<int, string>
     */
    protected static array $firstNames = [
        'محمد', 'عبدالله', 'أحمد', 'خالد', 'سعد', 'فهد', 'عبدالعزيز', 'تركي',
        'ماجد', 'بندر', 'سلطان', 'ناصر', 'عمر', 'يوسف', 'إبراهيم', 'عبدالرحمن',
        'فيصل', 'سعود', 'مشعل', 'نايف', 'فوزية', 'نورة', 'سارة', 'منيرة', 'هند',
    ];

    /**
     * أسماء الأب.
     *
     * @var array<int, string>
     */
    protected static array $fatherNames = [
        'عبدالله', 'محمد', 'أحمد', 'سعد', 'فهد', 'خالد', 'إبراهيم', 'سليمان',
        'عبدالعزيز', 'ناصر',
    ];

    /**
     * أسماء العائلات.
     *
     * @var array<int, string>
     */
    protected static array $familyNames = [
        'القحطاني', 'الغامدي', 'العتيبي', 'الدوسري', 'الحربي', 'المطيري',
        'الشمري', 'الزهراني', 'العنزي', 'السبيعي', 'الشهري', 'البقمي',
        'الجهني', 'السلمي', 'العمري',
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
            'full_name' => fake()->randomElement(static::$firstNames).' '
                .fake()->randomElement(static::$fatherNames).' '
                .fake()->randomElement(static::$familyNames),
            'national_id' => $this->generateNationalId(),
            'phone' => '05'.fake()->numerify('########'),
            'deduction_type' => fake()->randomElement(['راتب', 'تحويل بنكي', 'نقدي']),
            'amount' => fake()->numberBetween(2, 40) * 50,
            'status' => fake()->boolean(90) ? 'active' : 'suspended',
            'notes' => fake()->boolean(30) ? fake()->sentence() : null,
            'created_by' => null,
        ];
    }

    /**
     * توليد رقم هوية وطنية من عشر خانات يبدأ بـ 1 أو 2 ومضمون التفرد.
     */
    protected function generateNationalId(): string
    {
        static::$nationalIdSequence++;

        $prefix = fake()->randomElement(['1', '2']);

        return $prefix.str_pad((string) static::$nationalIdSequence, 9, '0', STR_PAD_LEFT);
    }
}
