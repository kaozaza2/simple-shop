<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->count(5)
            ->sequence([
                'name' => 'นกพิราบ ผักกาดดองเค็มฮั่วน่ำฉ่าย ฝาดึง 230 ก.',
                'image' => '45fe22c8279a6159060df89cfeba4ee3.jpg',
                'price' => 26
            ], [
                'name' => 'มาม่าบะหมี่กึ่งสำเร็จรูปคัพรสต้มยํากุ้ง 60กรัม',
                'image' => '120182_010_04.jpg',
                'price' => 13
            ], [
                'name' => 'มาม่าบะหมี่กึ่งสำเร็จรูปรสต้มยำกุ้ง 55กรัม',
                'image' => 'ShotType1_540x540.jpg',
                'price' => 6
            ], [
                'name' => 'โรซ่าปลาซาร์ดีนในซอสมะเขือเทศ 155กรัม',
                'image' => 'ShotType2_540x540.jpg',
                'price' => 18
            ], [
                'name' => 'ซูเปอร์ซีเชฟปลาแมคเคอเรลซอสมะเขือเทศ 155กรัม',
                'image' => '394560_010_Supermarket.jpg',
                'price' => 18
            ])
            ->create();
    }
}
