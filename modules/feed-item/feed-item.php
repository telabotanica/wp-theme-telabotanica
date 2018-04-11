<?php
function telabotanica_module_feed_item($data) {
  $defaults = [
    'article' => false,
    'date' => false,
    'image' => false,
    'images' => false,
    'href' => false,
    'target' => false,
    'title' => '',
    'text' => '',
    'meta' => false,
    'modifiers' => []
  ];

  $data = telabotanica_styleguide_data($defaults, $data);
  $data->modifiers = telabotanica_styleguide_modifiers_array('feed-item', $data->modifiers);

  if ($data->date && !$data->text) { $data->modifiers[] = "is-date"; }
  if ($data->image) { $data->modifiers[] = "has-image"; }
  if ($data->images) { $data->modifiers[] = "has-images"; }
  if ($data->href) { $data->modifiers[] = "has-link"; }
  if ($data->article) { $data->modifiers[] = "is-article"; }
  if ($data->text && !$data->image && !$data->title && !$data->meta && !$data->href) {
    $data->modifiers[] = "has-only-text";
  }

  echo '<div class="' . implode(' ', $data->modifiers) . '">';

    if ($data->href) {
      printf(
        '<a href="%s" target="%s" class="feed-item-link">',
        $data->href,
        $data->target
      );
    }

    if ($data->image) {
      if ($data->article) {
        printf(
          '<div class="feed-item-image" style="background-image: url(%s);">',
          $data->image
        );
          the_telabotanica_module('icon', ['icon' => 'news']);
        echo '</div>';
      } else {
        printf(
          '<img src="%s" class="feed-item-image" alt="">',
          $data->image
        );
      }
    }

    if ($data->images) {
      echo '<div class="feed-item-images">';
        foreach ($data->images as $image) {
          echo '<img src="' . $image . '" alt="">';
        }
      echo '</div>';
    }

    if ($data->title) {
      printf(
        '<h3 class="feed-item-title">%s</h3>',
        $data->title
      );
    }

    if ($data->text) {
      printf(
        '<div class="feed-item-text">%s</div>',
        $data->text
      );
    } elseif ($data->date) {
      printf(
        '<div class="feed-item-text">%s%s</div>',
        get_telabotanica_module('icon', ['icon' => 'clock']),
        $data->date
      );
    }

    if ($data->meta) {
      echo '<div class="feed-item-meta">';
        if ($data->meta['place']) {
          printf(
            '<span class="feed-item-meta-place">%s%s</span>',
            $data->meta['place'],
            get_telabotanica_module('icon', ['icon' => 'marker'])
          );
        }
        if ($data->meta['text']) {
          echo $data->meta['text'];
        }
      echo '</div>';
    }

    if ($data->href) {
      echo '</a>';
    }

  echo '</div>';

}
