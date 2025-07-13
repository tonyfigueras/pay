<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Actions extends Model
{
    use NodeTrait;

    protected $fillable = [
        'actionable_id',
        'actionable_type',
        'action_type',
        'parent_id',
        'order',
        'properties',
        'detail',
        '_lft',
        '_rgt',
    ];

    protected $casts = [
        'properties' => 'array',
        'detail' => 'array',
    ];

    /**
     * Relación polimórfica con modelos asociados (Npc, AreaTriggerEvent, etc.)
     */
    public function actionable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Alias para children() con nombre semántico "actions"
     * @return \Kalnoy\Nestedset\Collection
     */
    public function actions()
    {
        return $this->children();
    }


    public function parent()
    {
        return $this->belongsTo(Actions::class, 'parent_id')->with('userActions');
    }
 

    /**
     * Verifica si el usuario completó el padre directo
     */
    public function isParentCompletedBy(int $userId): bool
    {
        if (!$this->parent_id) {
            return true;
        }

        // Cargamos el parent si no está cargado
        if (!$this->relationLoaded('parent')) {
            $this->load('parent');
        }

        return $this->parent->userActions
            ->where('user_id', $userId)
            ->where('is_completed', true)
            ->isNotEmpty();
    }

    public function userActions()
    {
        return $this->hasMany(UserAction::class, 'action_id');
    }

    public function audios()
    {
        return $this->hasMany(ActionAudios::class);
    }
}