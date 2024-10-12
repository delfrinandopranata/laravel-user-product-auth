<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_name',
        'date',
        'hours',
        'user_id',
        'project_id',
    ];

    /**
     * The user who logs this timesheet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The project this timesheet is linked to.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
