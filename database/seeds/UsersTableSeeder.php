<?php

use StreetWorks\Models\Car;
use StreetWorks\Models\Post;
use StreetWorks\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create()->each(function ($u) {
//            $u->posts()->save(factory(Post::class)->make());
            $u->cars()->save(factory(Car::class)->make());
        });
    }
}
