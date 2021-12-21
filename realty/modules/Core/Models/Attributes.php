<?php
namespace Modules\Core\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attributes extends BaseModel
{
    use SoftDeletes;
    protected $table = 'bravo_attrs';
    protected $fillable = ['name','display_type','hide_in_single'];
    protected $slugField = 'slug';
    protected $slugFromField = 'name';

    public function terms()
    {
        return $this->hasMany(Terms::class, 'attr_id', 'id')->with(['translations']);
    }

    public function fill(array $attributes)
    {
        if(!empty($attributes)){
            foreach ( $this->fillable as $item ){
                $attributes[$item] = $attributes[$item] ?? null;
            }
        }
        return parent::fill($attributes); // TODO: Change the autogenerated stub
    }
}