<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null value_to_sum
 * @property mixed|null parameters
 * @property int fb_application_id
 * @property int fb_event_id
 */
class FbAppEvent extends Model
{
    protected $fillable = [
        'value_to_sum',
        'parameters',
        'fb_application_id',
        'fb_event_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'parameters' => 'array',
    ];

    public static function getRules()
    {
        return [
            'fb_event_id' => 'required|exists:fb_events,id',
            'fb_application_id' => 'required|exists:fb_applications,id',
            'valueToSum' => 'string|nullable',
        ];
    }

    public function fbApplication()
    {
        return $this->belongsTo(FbApp::class);
    }

    public function fbEvent()
    {
        return $this->belongsTo(FbEvent::class);
    }
}
