<?php

include_once "bootstrap.php";

$pages = $entityManager->getRepository("Page")->findAll();

print('<nav class="navigation">');
foreach ($pages as $page) {
    if ($page->getId() !== 1) {
        $pageName = "?page={$page->getName()}&id={$page->getId()}";
    } else {
        $pageName = "./";
    }
    print("<div class='nav'><a href='{$pageName}' class='nav'>{$page->getName()}</a></div>");
}
print('</nav>');

if (isset($_GET['page']) && isset($_GET['id']) && !empty($_GET['page']) && !empty($_GET['id'])) {
    $page = $entityManager->find('Page', $_GET['id']);
    print('<div class="pageName">' . $page->getName() . '</div>
          <div class="pageContent">' . $page->getContent() . '</div>');
} else {
    $page = $entityManager->find('Page', 1);
    print('<div class="pageName">' . $page->getName() . '</div>
          <div class="pageContent">' . $page->getContent() . '</div>');
}
