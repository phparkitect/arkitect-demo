<?php

namespace App\Catalog\Application\Service;

use App\Catalog\Infrastructure\Persistence\DoctrineCatalogRepository;

class CatalogService
{
    public function __construct(DoctrineCatalogRepository $catalogRepository)
    {

    }
}