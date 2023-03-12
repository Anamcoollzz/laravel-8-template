<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'activity_type',
        'request_data',
        'before',
        'after',
        'ip',
        'user_agent',
        'user_id',
        // 'role_id',
        'roles',
        'browser',
        'platform',
        'device',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'roles' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function role()
    // {
    //     return $this->belongsTo(Role::class, 'role_id');
    // }
}
