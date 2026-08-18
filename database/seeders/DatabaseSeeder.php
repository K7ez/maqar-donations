<?php

namespace Database\Seeders;

use App\Models\BeneficiaryFamily;
use App\Models\Donor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'مدير النظام',
            'email' => 'admin@maqar.org',
            'password' => 'password',
        ]);
        $admin->role = 'admin';
        $admin->save();

        $staff = User::factory()->create([
            'name' => 'موظف النظام',
            'email' => 'staff@maqar.org',
            'password' => 'password',
        ]);
        $staff->role = 'staff';
        $staff->save();

        $donors = Donor::factory(150)->create([
            'created_by' => $admin->id,
        ]);

        $this->seedDeductions($donors, $admin, $staff);

        BeneficiaryFamily::factory(60)->create();
    }

    /**
     * بذر استقطاع واحد لكل شهر من آخر 12 شهراً لكل متبرع نشط،
     * عبر إدراج مجمّع (chunked) لتفادي بطء الإدراج الفردي.
     */
    protected function seedDeductions($donors, User $admin, User $staff): void
    {
        $now = now()->toDateTimeString();
        $rows = [];

        foreach ($donors->where('status', 'active') as $donor) {
            for ($i = 11; $i >= 0; $i--) {
                $month = Carbon::now()->startOfMonth()->subMonths($i);
                $dueDate = $month->copy()->addMonth()->day(5);

                $roll = fake()->numberBetween(1, 100);
                $status = match (true) {
                    $roll <= 70 => 'paid',
                    $roll <= 90 => 'pending',
                    default => 'late',
                };

                $isPaid = $status === 'paid';

                $rows[] = [
                    'donor_id' => $donor->id,
                    'month' => $month->toDateString(),
                    'amount' => $donor->amount,
                    'due_date' => $dueDate->toDateString(),
                    'status' => $status,
                    'paid_at' => $isPaid ? $now : null,
                    'confirmed_by' => $isPaid ? fake()->randomElement([$admin->id, $staff->id]) : null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        collect($rows)->chunk(500)->each(
            fn ($chunk) => DB::table('deductions')->insert($chunk->toArray())
        );
    }
}
