<?php

use Illuminate\Database\Seeder;

use App\TypeUser;

class TypeUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(App\TypeUser::class)->create([
            'name' => TypeUser::USER_ADMIN  
        ]);

        factory(App\TypeUser::class)->create([
            'name' => TypeUser::USER_REGULAR
        ]);

    }
}
