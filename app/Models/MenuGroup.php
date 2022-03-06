<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_name'
    ];

    /**
     * Default with relationship
     *
     * @var array
     */
    protected $with = [
        'menus'
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'menu_group_id')->whereNull('parent_menu_id');
    }
}
