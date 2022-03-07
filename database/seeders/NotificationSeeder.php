<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = User::whereEmail('superadmin@laraveltemplate.com')->first()->id ?? 1;
        foreach (range(1, 20) as $i) {
            Notification::create([
                'title'             => 'Test title',
                'content'           => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima doloremque, ullam pariatur vero beatae tempora dolor qui autem, similique consequatur iure explicabo. Magnam temporibus blanditiis, nesciunt iusto eius explicabo quae?',
                'user_id'           => $userId,
                'is_read'           => false,
                'notification_type' => 'transaksi masuk',
            ]);
        }
    }
}
