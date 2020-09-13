<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FbEventParameter extends Model
{
    protected $fillable = [
        'name',
        'type',
        'fb_event_id',
        'description',
    ];

    public const types = ['int', 'float', 'string', 'logical'];

    public static function getRules()
    {
        return [
            'name' => 'required|string',
            'type'=> 'required|in:'.implode(',', self::types),
            'fb_event_id' => 'required|exists:fb_events,id',
        ];
    }

    public function fbEvent()
    {
        return $this->belongsTo(FbEvent::class);
    }
}
