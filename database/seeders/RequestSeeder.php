<?php

namespace Database\Seeders;

use App\Models\Request as RequestModel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * The RequestSeeder creates sample request data for the application.
 * 
 * This seeder creates various types of requests with different priorities
 * and assigns them to different users for testing purposes.
 */
class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $types = ['service', 'maintenance'];
        $priorities = ['low', 'medium', 'high'];
        $statuses = ['pending', 'in_progress', 'completed'];
        
        // Create 20 sample requests
        for ($i = 0; $i < 20; $i++) {
            $requestedBy = $users->random()->id;
            $dueDate = now()->addDays(rand(1, 30));
            
            RequestModel::create([
                'title' => 'Sample Request ' . ($i + 1),
                'description' => 'This is a sample request description. It contains details about what is needed.',
                'type' => $types[array_rand($types)],
                'priority' => $priorities[array_rand($priorities)],
                'status' => $statuses[array_rand($statuses)],
                'requested_by' => $requestedBy,
                'due_date' => $dueDate,
            ]);
        }
    }
}
