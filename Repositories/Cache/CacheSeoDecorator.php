<?php namespace Modules\Bcseo\Repositories\Cache;

use Modules\Bcseo\Repositories\SeoRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSeoDecorator extends BaseCacheDecorator implements SeoRepository
{
    public function __construct(SeoRepository $seo)
    {
        parent::__construct();
        $this->entityName = 'bcseo.seos';
        $this->repository = $seo;
    }

    public function createOrUpdate($data)
    {
        $this->repository->createOrUpdate($data);
    }

}
