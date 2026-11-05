<?php

namespace App\Modules\TvIntervention\Models;

use Illuminate\Database\Eloquent\Model;

class TvInterventionSetting extends Model
{
    protected $table = 'tv_intervention_settings';

    protected $fillable = [
        'device_id',
        'is_active',
        'interval_minutes',
        'daily_limit_minutes',
        'target_grade',
        'questions_to_pass',
        'max_penalty_cap',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'interval_minutes' => 'integer',
        'daily_limit_minutes' => 'integer',
        'questions_to_pass' => 'integer',
        'max_penalty_cap' => 'integer',
    ];
}
