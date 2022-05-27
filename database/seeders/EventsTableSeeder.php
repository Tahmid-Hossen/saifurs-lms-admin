<?php

namespace Database\Seeders;

use App\Models\Backend\Event\Event;
use App\Models\Backend\User\Company;
use App\Support\Configs\Constants;
use Faker\Factory;
use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Factory::create();
        $timestamp = date( 'Y-m-d H:i:s' );
        $status = Constants::$user_active_status;
        $saifursGroupCompany = Company::where( 'company_email', '=', 'info@saifursgroup.com' )->first();
        $aleshaTechCompany = Company::where( 'company_email', '=', 'info@aleshatech.com' )->first();
        $event_starts = $faker->dateTimeBetween( 'this week', '+6 days' );
        $event_ends = $faker->dateTimeBetween( $event_starts, $event_starts->format( 'Y-m-d H:i:s' ) . ' +5 hours' );
        $events = [
            [
                'company_id'        => $aleshaTechCompany->id,
                'event_type'        => "review",
                'event_title'       => "D.M. Black and Robert Chandler on Dante",
                'event_description' => "Dante’s Purgatorio is as much an allegory of spiritual transformation as it is one of psychological rebirth, personal healing, and self-transcendence. Combining a graceful lyricism with decades of study, D.M. Black’s translation and commentary reveal new dimensions in Dante’s many portraits of people trying to find their way through life and what comes after. This fresh, bilingual edition of Purgatorio will be published on September 14th, the 700th anniversary of Dante’s death. To celebrate this new edition, Black will be in conversation with Robert Chandler at the London Review Bookshop.",
                'event_image'       => '/assets/img/static/event.jpg',
                'event_link'        => "https://zoom.us/test",
                'event_start'       => $event_starts,
                'event_end'         => $event_ends,
                'event_featured'    => "YES",
                'event_status'      => $status,
                'created_at'        => $timestamp,
                'updated_at'        => $timestamp,
            ],
            [
                'company_id'        => $saifursGroupCompany->id,
                'event_type'        => "announcement",
                'event_title'       => "New Course on IELTS",
                'event_description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa, rem perferendis, amet reprehenderit blanditiis facilis tempora nulla ducimus autem expedita fugiat impedit hic, doloremque exercitationem itaque aspernatur sequi corrupti. Nesciunt ducimus ratione accusamus blanditiis maxime, eum animi excepturi. Natus tenetur laboriosam rerum enim, sapiente deserunt. Porro, eligendi vero! Vero suscipit molestiae minus voluptas ad incidunt doloribus id. Debitis reiciendis earum excepturi impedit non vitae ipsum nam perferendis minus libero fuga corrupti itaque, at voluptates pariatur! Voluptatibus, aliquid quod, facilis odio sed, atque sint id veniam vel error quae asperiores quisquam? Dolores, sed sapiente aperiam placeat dolorum exercitationem, eveniet iure nostrum corporis repellendus accusantium adipisci officia culpa at obcaecati vero debitis nulla officiis non. Adipisci quidem voluptas animi excepturi iste ratione nobis quo molestiae non perspiciatis natus nostrum, porro autem distinctio omnis tenetur aliquid hic accusantium rerum officiis. Vel nemo eligendi enim officia voluptatibus commodi corporis, in ipsum esse amet aliquid fugiat minima odio, iusto sint laudantium quas nulla laboriosam, tempore pariatur modi? Veritatis voluptates odio molestias voluptate quae facilis possimus, perspiciatis magnam at, odit illo repellat? Corrupti mollitia esse, amet numquam aut tenetur est itaque odio, minus nemo dolore ullam? Maxime, illum sint nisi recusandae voluptates quam porro debitis iure eum aut quaerat perferendis iste magnam voluptatum qui, repudiandae atque incidunt vitae libero, neque sit. Aspernatur iste harum dolor unde numquam, nulla libero amet eveniet facere nesciunt quae ratione veniam natus eum nobis dolores itaque? Dolorem labore distinctio corporis culpa quaerat minima, maxime sapiente tempore blanditiis, porro consequatur nobis, vero beatae laudantium expedita laborum repellat ea. Quae odit dolore atque quis accusantium est nemo laboriosam explicabo repudiandae molestias voluptatum expedita quidem quod, quasi consequuntur eveniet ullam rerum id mollitia dignissimos rem deserunt provident tenetur libero? Eos natus enim, corrupti, facere cum, officia dolorum eius explicabo velit necessitatibus numquam voluptas placeat!',
                'event_image'       => '/assets/img/static/event.jpg',
                'event_link'        => "https://zoom.us/test",
                'event_start'       => $event_starts,
                'event_end'         => $event_ends,
                'event_featured'    => "YES",
                'event_status'      => $status,
                'created_at'        => $timestamp,
                'updated_at'        => $timestamp,
            ],
            [
                'company_id'        => $aleshaTechCompany->id,
                'event_type'        => "announcement",
                'event_title'       => "New Course on IELTS",
                'event_description' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa, rem perferendis, amet reprehenderit blanditiis facilis tempora nulla ducimus autem expedita fugiat impedit hic, doloremque exercitationem itaque aspernatur sequi corrupti. Nesciunt ducimus ratione accusamus blanditiis maxime, eum animi excepturi. Natus tenetur laboriosam rerum enim, sapiente deserunt. Porro, eligendi vero! Vero suscipit molestiae minus voluptas ad incidunt doloribus id. Debitis reiciendis earum excepturi impedit non vitae ipsum nam perferendis minus libero fuga corrupti itaque, at voluptates pariatur! Voluptatibus, aliquid quod, facilis odio sed, atque sint id veniam vel error quae asperiores quisquam? Dolores, sed sapiente aperiam placeat dolorum exercitationem, eveniet iure nostrum corporis repellendus accusantium adipisci officia culpa at obcaecati vero debitis nulla officiis non. Adipisci quidem voluptas animi excepturi iste ratione nobis quo molestiae non perspiciatis natus nostrum, porro autem distinctio omnis tenetur aliquid hic accusantium rerum officiis. Vel nemo eligendi enim officia voluptatibus commodi corporis, in ipsum esse amet aliquid fugiat minima odio, iusto sint laudantium quas nulla laboriosam, tempore pariatur modi? Veritatis voluptates odio molestias voluptate quae facilis possimus, perspiciatis magnam at, odit illo repellat? Corrupti mollitia esse, amet numquam aut tenetur est itaque odio, minus nemo dolore ullam? Maxime, illum sint nisi recusandae voluptates quam porro debitis iure eum aut quaerat perferendis iste magnam voluptatum qui, repudiandae atque incidunt vitae libero, neque sit. Aspernatur iste harum dolor unde numquam, nulla libero amet eveniet facere nesciunt quae ratione veniam natus eum nobis dolores itaque? Dolorem labore distinctio corporis culpa quaerat minima, maxime sapiente tempore blanditiis, porro consequatur nobis, vero beatae laudantium expedita laborum repellat ea. Quae odit dolore atque quis accusantium est nemo laboriosam explicabo repudiandae molestias voluptatum expedita quidem quod, quasi consequuntur eveniet ullam rerum id mollitia dignissimos rem deserunt provident tenetur libero? Eos natus enim, corrupti, facere cum, officia dolorum eius explicabo velit necessitatibus numquam voluptas placeat!',
                'event_image'       => '/assets/img/static/event.jpg',
                'event_link'        => "https://zoom.us/test",
                'event_start'       => $event_starts,
                'event_end'         => $event_ends,
                'event_featured'    => "YES",
                'event_status'      => $status,
                'created_at'        => $timestamp,
                'updated_at'        => $timestamp,
            ],
            [
                'company_id'        => $saifursGroupCompany->id,
                'event_type'        => "review",
                'event_title'       => "D.M. Black and Robert Chandler on Dante",
                'event_description' => "Dante’s Purgatorio is as much an allegory of spiritual transformation as it is one of psychological rebirth, personal healing, and self-transcendence. Combining a graceful lyricism with decades of study, D.M. Black’s translation and commentary reveal new dimensions in Dante’s many portraits of people trying to find their way through life and what comes after. This fresh, bilingual edition of Purgatorio will be published on September 14th, the 700th anniversary of Dante’s death. To celebrate this new edition, Black will be in conversation with Robert Chandler at the London Review Bookshop.",
                'event_image'       => '/assets/img/static/event.jpg',
                'event_link'        => "https://zoom.us/test",
                'event_start'       => $event_starts,
                'event_end'         => $event_ends,
                'event_featured'    => "YES",
                'event_status'      => $status,
                'created_at'        => $timestamp,
                'updated_at'        => $timestamp,
            ],
        ];
        foreach ( $events as $event ) {
            try {
                Event::create( $event );
            } catch ( \PDOException $exception ) {
                throw new \PDOException( $exception->getMessage() );
            }
        }
    }
}
