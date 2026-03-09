<?php

use App\Models\SchoolUser;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('school-user:create-admin', function () {
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

    $this->info('Admin SchoolUser account created/updated.');
    $this->line('username: '.$username);
    $this->line('password: '.$plainPassword);
    $this->line('default_password: '.$plainPassword);
})->purpose('Create or update the default admin account in school_users');
