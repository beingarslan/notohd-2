<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        // photo category
        $photo = Category::create([
            'title' => 'Photo',
            'description' => $faker->text,
            'slug' => 'photo',
            'image' => 'default.png',
            'parent_id' => null,
            'status' => 1,
        ]);
        // photo categories
        $photo_categories = [
            'Nature',
            'Portrait',
            'Wildlife',
            'Travel',
            'Architecture',
            'Food',
            'Fashion',
            'People',
            'Animal',
        ];
        foreach ($photo_categories as $category) {
            Category::create([
                'title' => $category,
                'description' => $faker->text,
                'slug' => Str::slug($category),
                'image' => 'default.png',
                'parent_id' => $photo->id,
                'status' => 1,
            ]);
        }

        // video
        $video = [
            'title' => 'Video',
            'description' => $faker->text,
            'slug' => 'video',
            'parent_id' => null,
            'status' => 1,
        ];
        $video_id = Category::create($video)->id;

        // video categories
        $video_categories = [
            'Music',
            'Sports',
            'Travel',
            'Entertainment',
            'Education',
            'News',
            'Lifestyle',
            'Health',
            'Fashion',
            'People',
            'Animal',
        ];
        foreach ($video_categories as $category) {
            Category::create([
                'title' => $category,
                'description' => $faker->text,
                'slug' => Str::slug($category),
                'image' => 'default.png',
                'parent_id' => $video_id,
                'status' => 1,
            ]);
        }
    }
}
