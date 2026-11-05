<?php

namespace App\Modules\TvIntervention\Models;

use Illuminate\Database\Eloquent\Model;

class TvQuestion extends Model
{
    protected $table = 'tv_questions';

    protected $fillable = [
        'grade',
        'category',
        'question_text',
        'speech_text',
        'options',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];
}
