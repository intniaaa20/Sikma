<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignAdminRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-admin-role {email : The email of the user to assign the admin role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign the admin role to a user by email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1; // Indicate error
        }

        // Find or create the admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Assign the role
        $user->assignRole($adminRole);

        $this->info("Admin role assigned successfully to user '{$user->name}' ({$email}).");

        // Optional: Clear cache
        $this->call('permission:cache-reset');
        $this->info('Permission cache reset.');

        return 0; // Indicate success
    }
}
