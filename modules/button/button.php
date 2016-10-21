<?php function telabotanica_module_button($data) {
  echo '<a href="' . $data->href . '" class="button">' . $data->text . '</a>';
}
