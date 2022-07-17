<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\UserComponent;
use App\Models\User;

class UserComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $component = array(
            'admin-component',
            'user-component',
        );

        $users = User::get();

        foreach ($users as $user) {
            $user_components = UserComponent::create([
                'components' => rand(1, 2) == 1 ? 'admin-component' : 'user-component',
                'user_id' => $user->id
            ]);
        }
    }
}
