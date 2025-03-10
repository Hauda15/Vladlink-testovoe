<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;
use Models\Category;

class CategoryRepository extends EntityRepository
{
    public function findChildrenByParent(Category $parent): array
    {
        return $this->findBy(['parent' => $parent]);
    }
}