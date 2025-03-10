<?php

namespace Services;

use Doctrine\ORM\EntityManagerInterface;
use Models\Category;

class ImportService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function import(string $path): void
    {
        $json = file_get_contents($path);
        $importData = json_decode($json);

        $this->entityManager->beginTransaction();
        try {
            $this->processCategories($importData);

            $this->entityManager->commit();
        } catch (\Exception) {
            $this->entityManager->rollback();
        }
    }

    private function processCategories($importData, $parent = null): void
    {
        foreach ($importData as $category) {
            $newCategory = new Category();
            $newCategory->setId($category->id);
            $newCategory->setName($category->name);
            $newCategory->setAlias($category->alias);
            $newCategory->setParent($parent);

            $this->entityManager->persist($newCategory);

            if (!empty($category->childrens)) {
                $this->processCategories($category->childrens, $newCategory);
            }
        }

        $this->entityManager->flush();
    }
}
