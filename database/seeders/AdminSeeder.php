<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$admin = User::where('email','kagimujayp01@gmail.com')->first();
    	if(!$admin){
        	$admin = new User;
        }
        $admin->name = "Kagimu Jay P";
        $admin->email = "kagimujayp01@gmail.com";
        $admin->password = Hash::make("12345");
        $admin->position = 'Senior Developer';
        $admin->role = "admin";
        $admin->save();

        $admin2 = User::where('email','joseprincempoza@gmail.com ')->first();
        if(!$admin2){
            $admin2 = new User;
        }
        $admin2->name = "Joseph Prince";
        $admin2->email = "joseprincempoza@gmail.com ";
        $admin2->password = Hash::make("12345");
        $admin2->role = "admin";
        $admin2->position = "administrator";
        $admin2->save();

        $admin3 = User::where('email','mugishad43@gmail.com ')->first();
        if(!$admin3){
            $admin3 = new User;
        }
        $admin3->name = "Mugisha David";
        $admin3->email = "mugishad43@gmail.com ";
        $admin3->password = Hash::make("12345");
        $admin3->role = "admin";
        $admin3->position = "administrator";
        $admin3->save();
    }
}
