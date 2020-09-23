<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class FbApp
 *
 * @package App
 * @mixin Eloquent
 * @property string name
 * @property number fb_id
 * @property string key
 */
class FbApp extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            /** @var FbApp $model */

            do {
                $appKey = Str::random();
            } while (FbApp::where('key', $appKey)->first() instanceof FbApp);

            $model->key = $appKey;
        });
    }

    protected $fillable = [
        'name',
        'fb_id',
        'key'
    ];

    public function fbEvents()
    {
        return $this->belongsToMany(FbEvent::class, 'fb_app_events')
            ->withPivot('value_to_sum', 'parameters');
    }

    public static function getRules($mode = 'save')
    {
        $rules = [
            'name' => 'required|string',
            'fb_id' => 'required|numeric',
        ];

        if ($mode === 'update') {
            $rules['user_id'] = 'required|exists:users,id';
        }

        return $rules;
    }

    public function fbAppEvents()
    {
        return $this->hasMany(FbAppEvent::class);
    }

    public function fbAppEventLogs()
    {
        return $this->hasManyThrough(FbAppEventLog::class, FbAppEvent::class);
    }
}
