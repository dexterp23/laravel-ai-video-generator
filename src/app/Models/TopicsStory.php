<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicsStory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'topics_story';

    protected $fillable = [
        'viral_id',
        'title',
        'description',
        'hashtags',
        'script',
        'video_path',
        'video_status'
    ];

    protected $casts = [
        'script' => 'array',
    ];

    public function viral()
    {
        return $this->belongsTo(TopicsViral::class, 'viral_id');
    }
}
