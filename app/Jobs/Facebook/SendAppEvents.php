<?php

namespace App\Jobs\Facebook;

use App\FbApp;
use App\FbAppEventLog;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
     * @return bool
     */
    public function handle()
    {
        $fbApp = FbApp::where('key', $this->appKey)
            ->with(['fbAppEvents', 'fbAppEvents.fbEvent'])
            ->firstOrFail();

        $client = new Client();

        $apiUrl = config('services.facebook.api_url') . '/' . $fbApp->fb_id . '/activities';

        foreach ($fbApp->fbAppEvents as $appEvent) {
            $data = [
                'query' => [
                    'event' => 'CUSTOM_APP_EVENTS'
                ],
                'form_params' => [
                    'advertiser_tracking_enabled' => 1,
                    'application_tracking_enabled' => 1,
                    'custom_events' => array_merge(
                        json_decode($appEvent->parameters, JSON_OBJECT_AS_ARRAY),
                        [
                            '_eventName' => $appEvent->fbEvent->name,
                            '_valueToSum' => $appEvent->value_to_sum
                        ]
                    ),
                    // TODO: where can I take this param?
                    'advertiser_id' => '1111-1111-1111-1111'
                ]
            ];

            try {
                $response = $client->post($apiUrl, $data);
            } catch (GuzzleException $e) {
                $eventLog = new FbAppEventLog();
                $eventLog->desc = $e->getResponse()->getReasonPhrase();
                $eventLog->status = $e->getResponse()->getStatusCode();
                $eventLog->json_content = json_encode($data);
                $eventLog->fb_app_event_id = $appEvent->id;
                $eventLog->save();

                Log::error($e->getMessage());

                return false;
            }

            $responseDecoded = json_decode($response->getBody(), true);

            $eventLog = new FbAppEventLog();
            $eventLog->desc = $response->getReasonPhrase();
            $eventLog->status = $response->getStatusCode();
            $eventLog->json_content = json_encode($data);
            $eventLog->json_response = json_encode($responseDecoded);
            $eventLog->fb_app_event_id = $appEvent->id;
            $eventLog->save();
        }

        return true;
    }
}
