<?php namespace Modules\Bcseo\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface SeoRepository extends BaseRepository
{
    public function createOrUpdate($data);




}
