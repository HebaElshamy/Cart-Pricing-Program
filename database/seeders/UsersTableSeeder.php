<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // حقن بيانات افتراضية
        User::create([
            'name' => 'User1',
            'email' => 'user1@example.com',
            'password' => bcrypt('123456789'),
        ]);
        User::create([
            'name' => 'User2',
            'email' => 'user2@example.com',
            'password' => bcrypt('123456789'),
        ]);


        // يمكنك إضافة المزيد من السجلات حسب الحاجة
    }
}

