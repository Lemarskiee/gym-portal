<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\MembershipPlan;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\TrainerAssignment;
use App\Models\BillingLog;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // MEMBERSHIP PLANS

        $basic = MembershipPlan::create([
            'name' => 'Basic',
            'duration_months' => 1,
            'price' => 800
        ]);

        $vip = MembershipPlan::create([
            'name' => 'VIP',
            'duration_months' => 1,
            'price' => 1500
        ]);

        $annual = MembershipPlan::create([
            'name' => 'Annual',
            'duration_months' => 12,
            'price' => 10000
        ]);

        // TRAINERS

        $trainer1 = Trainer::create([
            'full_name' => 'John Reyes',
            'specialty' => 'Weight Training',
            'phone' => '09171234567'
        ]);

        $trainer2 = Trainer::create([
            'full_name' => 'Maria Santos',
            'specialty' => 'Cardio Fitness',
            'phone' => '09179876543'
        ]);

        $trainer3 = Trainer::create([
            'full_name' => 'Kevin Cruz',
            'specialty' => 'Strength & Conditioning',
            'phone' => '09175551234'
        ]);

        // MEMBERS

        $firstNames = [
            'Carlo','Angela','Joshua','Nicole','David',
            'Mark','John','Paolo','Miguel','Andrei',
            'Rafael','Kurt','Jasper','Luis','Gabriel',
            'Princess','Andrea','Bea','Kim','Janine',
            'Pauline','Stefan','Ethan','Jason','Kevin',
            'Miguel','Aaron','Justin','Adrian','Bryan'
        ];

        $lastNames = [
            'Mendoza','Lim','Tan','Uy','Go',
            'Reyes','Santos','Cruz','Garcia','Dela Cruz',
            'Navarro','Aquino','Flores','Ramos','Castillo',
            'Villanueva','Alvarez','Torres','Ramirez','Gonzales',
            'Lopez','Diaz','Morales','Fernandez','Rivera',
            'Bautista','Sison','Ang','Chua','Sy'
        ];

        for ($i = 0; $i < 30; $i++) {

            $first = $firstNames[$i];
            $last = $lastNames[$i];

            $plan = MembershipPlan::inRandomOrder()->first();

            $member = Member::create([
                'first_name' => $first,
                'last_name' => $last,
                'email' => strtolower($first . $last . $i . '@gym.com'),
                'phone' => '09' . rand(100000000, 999999999),
                'start_date' => now()->subDays(rand(1, 180)),
                'membership_plan_id' => $plan->id
            ]);

            // Trainer Assignment
            TrainerAssignment::create([
                'member_id' => $member->id,
                'trainer_id' => rand(1, 3),
                'assigned_from' => now()->subDays(rand(1, 30)),
                'assigned_to' => now()->addMonths(1)
            ]);

            // Billing Logs (1–3 months history)
            $months = rand(1, 3);

            for ($m = 0; $m < $months; $m++) {

                $statusChance = rand(0, 100);

                BillingLog::create([
                    'member_id' => $member->id,
                    'billing_month' => now()->subMonths($m),
                    'amount_due' => $plan->price,
                    'due_date' => now()->subMonths($m)->addDays(7),
                    'status' => $statusChance > 60 ? 'paid' : 'unpaid'
                ]);
            }
        }
    }
}