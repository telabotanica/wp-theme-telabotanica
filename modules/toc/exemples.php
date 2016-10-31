<?php
return array(
  'Sommaire de la page (un seul niveau)' => array(
    'items' => array(
      array(
        'items' => array(
          array(
            'text' => "Intertitre 1",
            'href' => '#intertitre-1'
          ),
          array(
            'text' => "Intertitre 2",
            'href' => '#intertitre-2'
          ),
          array(
            'text' => "Intertitre 3",
            'href' => '#intertitre-3'
          ),
        )
      )
    )
  ),
  'Sommaire de la rubrique (un seul niveau)' => array(
    'items' => array(
      array(
        'text' => "Page 1",
        'href' => '#'
      ),
      array(
        'text' => "Page 2",
        'href' => '#'
      ),
      array(
        'text' => "Page 3",
        'href' => '#'
      ),
    )
  ),
  'Deux niveaux' => array(
    'items' => array(
      array(
        'text' => "Page 1",
        'href' => '#',
        'items' => array(
          array(
            'text' => "Intertitre 1",
            'href' => '#intertitre-1'
          ),
          array(
            'text' => "Intertitre 2",
            'href' => '#intertitre-2'
          ),
          array(
            'text' => "Intertitre 3",
            'href' => '#intertitre-3'
          ),
        )
      ),
      array(
        'text' => "Page 2",
        'href' => '#'
      ),
      array(
        'text' => "Page 3",
        'href' => '#'
      ),
    )
  )
);
