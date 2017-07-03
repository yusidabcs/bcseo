<?php namespace Modules\Bcseo\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use Translatable;

    protected $table = 'bcseo__seos';
    public $translatedAttributes = [];
    protected $fillable = [];
}
