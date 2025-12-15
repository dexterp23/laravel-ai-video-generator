<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CronLock extends Model
{

    protected $table = 'cron_lock';

    public $timestamps = false;

    protected $fillable = [
        'table',
        'date',
    ];
}
