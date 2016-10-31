<?php
return array(
  "Standard" => array(
    'title' => 'Liens',
    'items' => array(
      array(
        'href' => '#',
        'text' => 'Un lien',
        'title' => 'Titre du lien'
      ),
      array(
        'href' => '#',
        'text' => 'Un autre lien',
        'title' => 'Titre du lien',
        'target' => '_blank'
      ),
      array(
        'href' => '#',
        'text' => 'Un fichier à télécharger',
        'download' => true,
        'filename' => 'fichier.pdf',
        'filesize' => 2048 // octets
      )
    )
  )
);
