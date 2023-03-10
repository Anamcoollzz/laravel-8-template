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
        'menu_group_id',
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

    /**
     * Get the fix_url attribute.
     *
     * @return string
     */
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

    /**
     * Get all of the Menu's childs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childs()
    {
        return $this->hasMany(Menu::class, 'parent_menu_id');
    }

    /**
     * Get the group that owns the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(MenuGroup::class, 'menu_group_id');
    }

    /**
     * Get the parent that owns the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentMenu()
    {
        return $this->belongsTo(Menu::class, 'parent_menu_id');
    }
}
