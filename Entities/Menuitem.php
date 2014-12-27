<?php namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Internationalisation\Translatable;
use Modules\Menu\Support\NestedCollection;

class Menuitem extends Model
{
    use Translatable;

    public $translatedAttributes = ['title', 'uri', 'url', 'status'];
    protected $fillable = [
        'menu_id',
        'page_id',
        'position',
        'target',
        'module_name',
        'title',
        'uri',
        'url',
        'status',
        'is_root'
    ];

    /**
     * For nested collection
     *
     * @var array
     */
    public $children = [];

    public function menu()
    {
        return $this->belongsTo('Modules\Menu\Entities\Menu');
    }

    /**
     * Custom collection
     *
     * @param array $models
     * @return NestedCollection object
     */
    public function newCollection(array $models = array())
    {
        return new NestedCollection($models);
    }
}
