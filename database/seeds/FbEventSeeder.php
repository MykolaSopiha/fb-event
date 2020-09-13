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

            foreach ($parameters as $parameter) {
                $fbEvent = FbEventParameter::updateOrCreate([
                    'name' => $parameter['name'],
                    'type' => $parameter['type'],
                    'fb_event_id' => $fbEvent->id,
                    'description' => $parameter['description'],
                ]);
            }
        }
    }

    public static function getData(): array
    {
        return [
            'fb_mobile_tutorial_completion' => [
                [
                    'name' => 'fb_success',
                    'type' => 'logical',
                    'description' => '1 = "да", 0 = "нет"',
                ],
                [
                    'name' => 'fb_content_id',
                    'type' => 'string',
                    'description' => 'Международный артикул (EAN), если применяется, или другой идентификатор товара или контента. Для разных ID продуктов: например, "[\"1234\",\"5678\"]"',
                ]
            ]
        ];
    }
}
