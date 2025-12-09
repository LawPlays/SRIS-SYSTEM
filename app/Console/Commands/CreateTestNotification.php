<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Notification;

class CreateTestNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test notifications for students';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $students = User::where('role', 'student')->get();
        
        if ($students->isEmpty()) {
            $this->error('No students found in the database.');
            return;
        }
        
        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'title' => 'Welcome to SRIS',
                'message' => 'Your account has been created successfully. You can now access all student features.',
                'type' => 'info',
                'is_read' => false
            ]);
            
            Notification::create([
                'user_id' => $student->id,
                'title' => 'New Announcement',
                'message' => 'A new announcement has been posted. Please check the announcements section.',
                'type' => 'announcement',
                'is_read' => false
            ]);
        }
        
        $this->info('Test notifications created for ' . $students->count() . ' student(s).');
    }
}
