<?php

namespace Database\Seeders;

use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Database\Seeder;

class LoginHistorySeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UsersSeeder first.');
            return;
        }

        $ipAddresses = [
            '192.168.1.100', '192.168.1.101', '192.168.1.102', '10.0.0.50', '172.16.0.10',
            '192.168.0.25', '10.0.1.100', '172.16.1.50', '192.168.2.10', '10.0.2.200'
        ];

        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15',
            'Mozilla/5.0 (Android 10; Mobile) AppleWebKit/537.36'
        ];
        
        for ($i = 0; $i < 15; $i++) {
            $user = $users->random();
            $loggedInAt = now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            $loggedOutAt = $loggedInAt->copy()->addHours(rand(1, 8));
            
            LoginHistory::create([
                'user_id' => $user->id,
                'ip_address' => $ipAddresses[array_rand($ipAddresses)],
                'user_agent' => $userAgents[array_rand($userAgents)],
                'logged_in_at' => $loggedInAt,
                'logged_out_at' => rand(0, 1) ? $loggedOutAt : null,
            ]);
        }
    }
}
