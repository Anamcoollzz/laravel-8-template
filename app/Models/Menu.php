<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'menu_name',
        'route_name',
        'icon',
        'parent_menu_id',
        'permission',
        'is_active_if_url_includes',
        'is_blank',
        'uri',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'fix_url',
    ];

    /**
     * Default with relationship
     *
     * @var array
     */
    protected $with = [
        'childs'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function getFixUrlAttribute()
    {
        if ($this->uri) {
            return url($this->uri);
        }
        if ($this->route_name && Route::has($this->route_name)) {
            return route($this->route_name);
        }
        return '#';
    }

    public function childs()
    {
        return $this->hasMany(Menu::class, 'parent_menu_id');
    }
}
