<?php

return [
  'Standard' => [
    'title' => 'Liens',
    'items' => [
      [
        'href'  => '#',
        'text'  => 'Un lien',
        'title' => 'Titre du lien',
      ],
      [
        'href'   => '#',
        'text'   => 'Un autre lien',
        'title'  => 'Titre du lien',
        'target' => '_blank',
      ],
      [
        'href'     => '#',
        'text'     => 'Un fichier à télécharger',
        'download' => true,
        'filename' => 'fichier.pdf',
        'filesize' => 2048, // octets
      ],
    ],
  ],
];
