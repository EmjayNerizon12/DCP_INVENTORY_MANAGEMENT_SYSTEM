<?php

namespace App\Console\Commands;

use App\Models\SchoolUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class SyncAdminAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-admin-account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update the default admin account in school_users';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $username = 'normanflores@gmail.com';
        $plainPassword = 'normanflores';

        $attributes = [
            'username' => $username,
        ];

        $values = [
            'password' => Hash::make($plainPassword),
            'default_password' => $plainPassword,
        ];

        if (Schema::hasColumn('school_users', 'email')) {
            $values['email'] = $username;
        }

        SchoolUser::query()->updateOrCreate($attributes, $values);

        $this->info('Admin SchoolUser account synced successfully.');

        return self::SUCCESS;
    }
}
