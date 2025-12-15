<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicsViral extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'topics_viral';

    protected $fillable = [
        'topic_id',
        'title',
        'description',
        'is_active',
        'cron_lock',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'cron_lock' => 'boolean',
    ];

    public function topic()
    {
        return $this->belongsTo(Topics::class, 'topic_id');
    }

    public function stories()
    {
        return $this->hasMany(TopicsStory::class, 'viral_id');
    }
}
