<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Article extends Model{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'articles';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['slug', 'title','type','video' ,'content','gallery_id', 'image', 'status', 'category_id', 'featured', 'date', 'extras'];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'featured'  => 'boolean',
        'date'      => 'date',
        'image'    => 'array',
//        'videos'    => 'json_decode',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo('Backpack\NewsCRUD\app\Models\Category', 'category_id');
    }
    public function gallery()
    {
        return $this->belongsTo('App\Models\Gallery', 'gallery_id');
    }
    public function tags()
    {
        return $this->belongsToMany('Backpack\NewsCRUD\app\Models\Tag', 'article_tag');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED')
            ->where('date', '<=', date('Y-m-d'))
            ->orderBy('date', 'DESC');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "title" field if no slug exists.
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
//    protected function castAttribute($key, $value)
//    {
//        switch ($this->getCastType($key))
//        {
//            case 'int':
//            case 'integer':
//                return (int) $value;
//            case 'real':
//            case 'float':
//            case 'double':
//                return (float) $value;
//            case 'string':
//                return (string) $value;
//            case 'bool':
//            case 'boolean':
//                return (bool) $value;
//            case 'object':
//                return json_decode($value);
//            case 'array':
//            case 'json':
//                return json_decode($value, true);
//            default:
//                return $value;
//        }
//    }


}
