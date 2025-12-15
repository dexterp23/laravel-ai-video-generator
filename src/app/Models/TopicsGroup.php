<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicsGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'topics_group';

    protected $fillable = [
        'title',
    ];

    public function topics()
    {
        return $this->hasMany(Topics::class, 'group_id');
    }
}
