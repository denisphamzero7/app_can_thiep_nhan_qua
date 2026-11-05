<?php

namespace App\Modules\TvIntervention\Models;

use Illuminate\Database\Eloquent\Model;

class TvInterventionLog extends Model
{
    protected $table = 'tv_intervention_logs';

    protected $fillable = [
        'device_id',
        'question_id',
        'is_correct',
        'watch_time_minutes',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'watch_time_minutes' => 'integer',
    ];
}
