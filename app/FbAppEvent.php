<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null value_to_sum
 * @property mixed|null parameters
 * @property int fb_app_id
 * @property int fb_event_id
 */
class FbAppEvent extends Model
{
    protected $fillable = [
        'value_to_sum',
        'parameters',
        'fb_app_id',
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
            'fb_app_id' => 'required|exists:fb_apps,id',
            'valueToSum' => 'string|nullable',
        ];
    }

    public function fbApp()
    {
        return $this->belongsTo(FbApp::class);
    }

    public function fbEvent()
    {
        return $this->belongsTo(FbEvent::class);
    }

    public function fbAppEventLogs()
    {
        return $this->hasMany(FbAppEventLog::class);
    }
}
