<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory()->count(10)->create();
        $users->each(function (User $user) {
            $post = Post::factory()->create([
                "user_id" => $user->id,
                'created_at' => fake()->dateTime()
            ]);
            Comment::factory()->create([
                "user_id" => $user->id,
                "post_id" => $post->id
            ]);
        });

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
