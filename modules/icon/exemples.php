<?php
$exemples = [
  "Standard" => ['icon' => 'home'],
  "En couleur" => ['icon' => 'rss', 'color' => 'orange'],
];

// Chargement de toutes les icônes disponibles
$directory = get_template_directory() . '/assets/icons/';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
while ($it->valid()) {
  if (!$it->isDot() && $it->getSubPathName() != '_all.js') {
    $icon = str_replace('.svg', '', $it->getSubPathName());
    $exemples[$icon] = ['icon' => $icon];
  }
  $it->next();
}

return $exemples;
