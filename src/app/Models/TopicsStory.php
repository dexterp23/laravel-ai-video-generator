<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicsStory extends Model
{
    use HasFactory, SoftDeletes;

    public const VIDEO_STATUS_NO_GENERATION = 1;
    public const VIDEO_STATUS_FOR_GENERATION = 10;
    public const VIDEO_STATUS_SENT_FOR_GENERATION = 20;
    public const VIDEO_STATUS_GENERATED = 30;

    public const VIDEO_STATUS = [
        self::VIDEO_STATUS_NO_GENERATION => 'No Generation',
        self::VIDEO_STATUS_FOR_GENERATION => 'For Generation',
        self::VIDEO_STATUS_SENT_FOR_GENERATION => 'Sent for Generation',
        self::VIDEO_STATUS_GENERATED => 'Generated',
    ];

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
