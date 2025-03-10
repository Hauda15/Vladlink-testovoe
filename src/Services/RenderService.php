<?php

namespace Services;

class RenderService
{
    public function renderMenu(array $categories, int $level = 0): string
    {
        if (empty($categories)) return '';

        $html = '<ul class="level-' . $level . '">' . PHP_EOL;

        foreach ($categories as $category) {
            $html .= str_repeat('  ', $level + 1);
            $html .= '<li>' . htmlspecialchars($category->getName());

            $children = $category->getChildren()->toArray();
            if (!empty($children)) {
                $html .= $this->renderMenu($children, $level + 1);
            }

            $html .= '</li>' . PHP_EOL;
        }

        $html .= str_repeat('  ', $level) . '</ul>' . PHP_EOL;
        return $html;
    }
}