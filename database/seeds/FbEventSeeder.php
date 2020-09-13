<?php

use App\FbEvent;
use App\FbEventParameter;
use Illuminate\Database\Seeder;

class FbEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::getData() as $eventName => $parameters) {
            $fbEvent = FbEvent::firstOrCreate([
                'name' => $eventName
            ]);

            foreach ($parameters as $parameterName => $type) {
                $fbEvent = FbEventParameter::updateOrCreate([
                    'name' => $parameterName,
                    'type' => $type,
                    'fb_event_id' => $fbEvent->id
                ]);
            }
        }
    }

    public static function getData(): array
    {
        return [
            'fb_mobile_tutorial_completion' => [
                'fb_success' => 'logical',
                'fb_content_id' =>'string'
            ]
        ];
    }
}
