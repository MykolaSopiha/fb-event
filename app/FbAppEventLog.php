<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FbAppEventLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'desc',
        'status',
        'json_content',
        'json_response',
        'fb_app_event_id',
    ];

    protected $casts = [
        'json_content' => 'array',
        'json_response' => 'array',
    ];
}
