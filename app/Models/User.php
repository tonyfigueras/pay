<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, hasRoles, hasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'title',
        'email',
        'password',
        'active',
        'wallet',
        'class',
        'professor',
        'current_chapter',
        'current_quest',
        'language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function autosaves(){
        return $this->hasMany(AutoSave::class);
    }

    public function studentProgress(){
        return $this->hasMany(StudentProgress::class);
    }

    public function grades(){
        return $this->hasMany(Grade::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_user', 'user_id', 'product_id');
    }

    public function class(){
        return $this->belongsTo(SchoolClass::class);
    }

    public function professor(){
        return $this->belongsTo(User::class);
    }

    public function schools(){
        return $this->belongsToMany(School::class);
    }

    public function schoolClasses(){
        return $this->belongsTo(SchoolClass::class);
    }

    public function galaxies(){
        return $this->belongsToMany(Galaxy::class);
    }

    public function worlds()
    {
        return $this->belongsToMany(World::class, 'world_user') // Explicitly set the pivot table
        ->withPivot('is_active', 'completed', 'completed_at', 'locked')
            ->withTimestamps();
    }


    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_user')->withPivot('completed', 'completed_at');
    }

    public function quests()
    {
        return $this->belongsToMany(Quest::class, 'quest_user')->withPivot('completed', 'completed_at');
    }

    public function steps()
    {
        return $this->belongsToMany(Step::class, 'step_user')->withPivot('completed', 'completed_at');
    }

    public function userCustomizations(){
        return $this->hasOne(UserCustomization::class);
    }

    public function currentlocations(){
        return $this->hasOne(CurrentLocation::class);
    }

    public function progress()
    {
        return $this->hasOne(UserProgress::class);
    }

    public function worldUser()
    {
        return $this->hasMany(WorldUser::class);
    }

    public function actions()
    {
        return $this->hasMany(UserAction::class);
    }

}
