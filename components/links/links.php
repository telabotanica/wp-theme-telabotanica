<?php

function telabotanica_component_links($data)
{
    $defaults = [
    'title'     => get_sub_field('title'),
    'items'     => get_sub_field('items'),
    'modifiers' => []
  ];

    $data = telabotanica_styleguide_data($defaults, $data);
    $data->modifiers = telabotanica_styleguide_modifiers_array(['component', 'component-links'], $data->modifiers);

    echo '<div class="' . implode(' ', $data->modifiers) . '">';

    echo '<h3 class="component-links-title">' . $data->title . '</h3>';

    if ($data->items):

      echo '<ul>';

    foreach ($data->items as $item) :

          $item = (object) $item;

    if (isset($item->acf_fc_layout)) :

            // Téléchargement
            if ($item->acf_fc_layout === 'download') :

              $item->download = true;
    $item->href = $item->file['url'];
    $item->filename = $item->file['filename'];
    $item->filesize = filesize(get_attached_file($item->file['id']));

    // Lien
    elseif ($item->acf_fc_layout === 'link') :

              $item->href = $item->destination['url'];
    $item->target = $item->destination['target'];
    $item->title = $item->destination['title'];

    endif; else :

            if (!isset($item->target)) {
                $item->target = '';
            }

    endif;

    // Téléchargement
    if (isset($item->download) && $item->download === true) :

            $extension = pathinfo($item->filename, PATHINFO_EXTENSION);

    printf(
              '<li class="component-links-item-download"><a href="%s" target="%s" title="%s" download="%s">%s%s <span class="component-links-metadata">%s - %s</span></a></li>',
              $item->href,
              '_blank',
              sprintf(__('Télécharger le fichier %s', 'telabotanica'), $item->filename),
              $item->filename,
              get_telabotanica_module('icon', ['icon' => ($extension === 'pdf' ? 'pdf' : 'doc')]),
              $item->text,
              strtoupper($extension),
              size_format($item->filesize, 2)
            );

    // Lien
    else :

            printf(
              '<li class="component-links-item-link"><a href="%s" target="%s" title="%s">%s%s</a></li>',
              $item->href,
              $item->target,
              $item->title,
              get_telabotanica_module('icon', ['icon' => 'link']),
              $item->text
            );

    endif;

    endforeach;

    echo '</ul>';

    endif;

    echo '</div>';
}
