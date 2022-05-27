<?php

namespace Database\Seeders;

use App\Models\Backend\Event\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = Event::all();
        $users = User::all()->pluck('id');

        foreach ($events as $event) {
            $event->getEnrolledUsersList()->attach($users, ['event_user_status' => 'confirmed', 'remarks' => 'testing']);
        }
    }
}
