<?php namespace Modules\Menu\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Menu\Support\NestedCollection;

class Menuitem extends Model
{
    use Translatable;

    public $translatedAttributes = ['title', 'uri', 'url', 'status'];
    protected $fillable = [
        'menu_id',
        'page_id',
        'parent_id',
        'position',
        'target',
        'module_name',
        'title',
        'uri',
        'url',
        'status',
        'is_root',
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
     * Return a custom nested collection
     *
     * @param  array            $models
     * @return NestedCollection
     */
    public function newCollection(array $models = array())
    {
        return new NestedCollection($models);
    }

    public function makeChildOf($rootItem)
    {
        $this->parent_id = $rootItem->id;
        $this->save();
    }
}
