<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (!DB::table('users')->whereEmail('admin@keiron.com')->exists()) {
            $user = new User;
            $user->email = 'admin@keiron.com';
            $user->password = bcrypt('secret');
            $user->type_user_id = 1;
            $user->name = 'Keiron';
            $user->email_verified_at = now();
            $user->remember_token = Str::random(10);
            $user->save();
        }

    }
}
