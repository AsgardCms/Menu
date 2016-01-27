<?php namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Model;

class MenuitemTranslation extends Model
{
    public $fillable = ['locale','title', 'uri', 'url', 'status'];
    protected $table = 'menu__menuitem_translations';
}
