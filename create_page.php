<?php

require_once "bootstrap.php";

$newPageName = $argv[1];
$newPageContent = "<h1>HELLO from the other side</h1>";

$page = new Page();
$page->setName($newPageName);
$page->setContent($newPageContent);

$entityManager->persist($Page);
$entityManager->flush();

echo "Created Product with ID " . $page->getId() . "\n";
