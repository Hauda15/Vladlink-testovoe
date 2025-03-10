<?php

namespace Services;

use Doctrine\ORM\EntityManagerInterface;
use Models\Category;

class ExportService
{
    const int TYPE_B_MAX_LEVEL = 2;

    private EntityManagerInterface $entityManager;
    private array $categories;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->categories = $this->entityManager->getRepository(Category::class)
            ->createQueryBuilder('c')
            ->leftJoin('c.parent', 'p')
            ->addSelect('p')
            ->getQuery()
            ->getResult();
    }

    public function exportByTypeA(string $filePath): void
    {
        $content = $this->generateExportContent(function($category, $level) {
            return str_repeat('    ', $level)
                . "{$category->getName()} "
                . $this->buildCategoryUrl($category);
        }, PHP_INT_MAX);

        file_put_contents($filePath, $content);
    }

    public function exportByTypeB(string $filePath): void
    {
        $content = $this->generateExportContent(function($category, $level) {
            return str_repeat('    ', $level)
                . $category->getName();
        }, self::TYPE_B_MAX_LEVEL);

        file_put_contents($filePath, $content);
    }

    private function generateExportContent(callable $formatter, $maxLevel = PHP_INT_MAX): string
    {
        $tree = $this->buildTree();
        return $this->generateTreeText(
            tree: $tree,
            formatter: $formatter,
            maxLevel: $maxLevel
        );
    }

    private function buildTree(): array
    {
        $tree = [];
        foreach ($this->categories as $category) {
            $parentId = $category->getParent()?->getId();
            $tree[$parentId][] = $category;
        }
        return $tree;
    }

    private function generateTreeText(array $tree, callable $formatter, ?int $parentId = null, int $level = 0, $maxLevel = null): string
    {
        $text = '';
        if (!isset($tree[$parentId]) || $level >= $maxLevel) return $text;

        foreach ($tree[$parentId] as $category) {
            $text .= $formatter($category, $level) . PHP_EOL;
            $text .= $this->generateTreeText($tree, $formatter, $category->getId(), $level + 1, $maxLevel);
        }

        return $text;
    }

    private function buildCategoryUrl(Category $category): string
    {
        $path = [];
        $current = $category;
        while ($current) {
            array_unshift($path, $current->getAlias());
            $current = $current->getParent();
        }
        return '/' . implode('/', $path);
    }
}