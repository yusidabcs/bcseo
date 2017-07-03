<?php namespace Modules\Bcseo\Entities;

use Illuminate\Database\Eloquent\Model;

class SeoTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'bcseo__seo_translations';
}
