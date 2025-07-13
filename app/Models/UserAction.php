<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;

class UserAction extends Model
{
    use NodeTrait;

    protected $fillable = [
        'user_id',
        'actionable_id', 
        'actionable_type',
        'action_id',
        'state',
        'is_completed',
        'completed_at'
    ];

    protected $casts = [
        'state' => 'array',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function actionable()
    {
        return $this->morphTo();
    }


    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    public function action()
    {
        return $this->belongsTo(Actions::class)->with('parent');
    }

    public function getParentIdName()
    {
        return 'parent_id';
    }
}