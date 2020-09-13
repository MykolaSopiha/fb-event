<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FbEvent extends Model
{
    protected $fillable = [
        'name',
    ];

    public static function getRules()
    {
        return [
            'name' => 'required|string'
        ];
    }

    public function fbApps()
    {
        return $this->belongsToMany(FbApp::class, 'fb_app_event')
            ->withPivot('value_to_sum', 'parameters');
    }

    public function parameters()
    {
        return $this->hasMany(FbEventParameter::class);
    }
}
