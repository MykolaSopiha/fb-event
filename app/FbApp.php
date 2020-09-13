<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FbApp extends Model
{
    protected $fillable = [
        'name',
        'fb_id',
        'key'
    ];

    public function events()
    {
        return $this->belongsToMany(FbEvent::class, 'fb_application_events')
            ->withPivot('value_to_sum', 'parameters');
    }

    public static function getRules()
    {
        return [
            'name' => 'required|string',
            'fb_id' => 'required|numeric',
        ];
    }

    public function fbApplicationEvents()
    {
        return $this->hasMany(FbAppEvent::class);
    }
}
