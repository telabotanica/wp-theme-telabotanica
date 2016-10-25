<?php function telabotanica_module_button($data) {
  echo '<a href="' . $data->href . '" class="button" target="' . $data->target . '" title="' . $data->title . '">' . $data->text . '</a>';
}
