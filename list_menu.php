<?php

use Models\Category;

require __DIR__ . '/bootstrap.php';

$categoryRepository = $entityManager->getRepository(Category::class);

$rootCategories = $categoryRepository->findBy(['parent' => null]);

$menuHtml = (new \Services\RenderService())->renderMenu($rootCategories);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Меню</title>
    <style>
        ul { list-style: none; padding-left: 20px; }
        li { margin: 5px 0; }
        .level-0 { font-weight: bold; }
        .level-1 { opacity: 80% }
        .level-2 { opacity: 70% }
    </style>
</head>
<body>
<h1>Меню</h1>
<?= $menuHtml ?>
</body>
</html>