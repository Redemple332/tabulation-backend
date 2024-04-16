<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        $u = new User();
        $u->id = "9955ffde-c38c-449a-9a27-3ebac65d405c";
        $u->first_name = 'Redemple';
        $u->last_name = 'Marcelo';
        $u->email = 'redemple@gmail.com';
        $u->password = '12345678';
        $u->role_id = '8787fc94-01e7-4f3b-a988-3b29409d0b76';
        $u->save();

        $u = new User();
        $u->id = "9955ffde-c38c-449a-9a27-3ebac65d405d";
        $u->first_name = 'Steven Kyle';
        $u->last_name = 'Evio';
        $u->email = 'steven@gmail.com';
        $u->password = '12345678';
        $u->role_id = '34300bad-3e5d-4511-b04f-721c2dc8e0e7';
        $u->save();

        $u = new User();
        $u->id = "9955ffde-c38c-449a-9a27-3ebac65d406d";
        $u->first_name = 'Judge';
        $u->last_name = '1';
        $u->judge_no = 1;
        $u->email = 'judge1@gmail.com';
        $u->password = '12345678';
        $u->role_id = 'b9612992-1e02-4572-b618-6bcd60d651ac';
        $u->save();

        $u = new User();
        $u->id = "9955ffde-c38c-449a-9a27-3ebac65d407d";
        $u->first_name = 'Judge';
        $u->last_name = '2';
        $u->judge_no = 2;
        $u->email = 'judge2@gmail.com';
        $u->password = '12345678';
        $u->role_id = 'b9612992-1e02-4572-b618-6bcd60d651ac';
        $u->save();


        $u = new User();
        $u->id = "9955ffde-c38c-449a-9a27-3ebac65d408d";
        $u->first_name = 'Judge';
        $u->last_name = '3';
        $u->judge_no = 3;
        $u->email = 'judge3@gmail.com';
        $u->password = '12345678';
        $u->role_id = 'b9612992-1e02-4572-b618-6bcd60d651ac';
        $u->save();
    }
}
