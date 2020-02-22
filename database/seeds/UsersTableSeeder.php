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
        $admin = new User();
	    $admin->name = 'Admin';
	    $admin->email = 'admin@admin.com';
	    $admin->password = Hash::make('admin');
	    $admin->is_admin = 1;
	    $admin->save();

	    $user = new User();
	    $user->name = 'User';
	    $user->email = 'user@user.com';
	    $user->password = Hash::make('user');
	    $user->is_admin = 0;
	    $user->save();
    }
}
