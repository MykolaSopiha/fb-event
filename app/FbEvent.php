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

    public function applications()
    {
        return $this->belongsToMany(FbApp::class, 'fb_application_event')
            ->withPivot('value_to_sum', 'parameters');
    }

    public function parameters()
    {
        return $this->hasMany(FbEventParameter::class);
    }
}
