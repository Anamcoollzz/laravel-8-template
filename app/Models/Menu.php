<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function childs()
    {
        return $this->hasMany(Menu::class, 'parent_menu_id');
    }
}
