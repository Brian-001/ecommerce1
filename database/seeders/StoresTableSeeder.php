<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::info('StoresTableSeeder is running');

        
        //Fetch all users
        $users = User::all();
        if($users->isEmpty()){
            Log::warning('No users found, cannot create stores');
            return;
        }
        //Create 5 stores associating them with existing users
        foreach($users->take(50) as $user)
        {
            Store::factory()->create(['user_id' => $user->id]);
        }
    }
}
