<?php

namespace App\Jobs\Facebook;

use App\FbApp;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAppEvents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $appKey;

    /**
     * Create a new job instance.
     *
     * @param string $appKey
     * @return void
     */
    public function __construct(string $appKey)
    {
        $this->appKey = $appKey;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $fbApp = FbApp::where('key', $this->appKey)
            ->with(['fbAppEvents', 'fbAppEvents.fbEvent'])
            ->firstOrCreate();

        $client = new Client();

        $apiUrl = config('services.facebook.api_url') . '/' . $fbApp->fb_id . '/activities';

        foreach ($fbApp->fbAppEvents as $appEvent) {

            $response = $client->post($apiUrl, [
                'query' => [
                    'event' => 'CUSTOM_APP_EVENTS'
                ],
                'form_params' => [
                    'advertiser_tracking_enabled' => 1,
                    'application_tracking_enabled' => 1,
                    'custom_events' => array_merge(
                        $appEvent->parameters,
                        [
                            '_eventName' => $appEvent->fbEvent->name,
                            '_valueToSum' => $appEvent->value_to_sum
                        ]
                    ),
                    // TODO: where can I take this param?
                    'advertiser_id' => '1111-1111-1111-1111'
                ]
            ]);

            dd($response->getBody()->getContents());
        }
    }
}
