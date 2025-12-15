<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topics extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'topics';

    protected $fillable = [
        'group_id',
        'title',
        'description',
        'is_active',
        'create_video',
        'cron_lock',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'create_video' => 'boolean',
        'cron_lock' => 'boolean',
    ];

    public function group()
    {
        return $this->belongsTo(TopicsGroup::class, 'group_id');
    }

    public function virals()
    {
        return $this->hasMany(TopicsViral::class, 'topic_id');
    }
}
