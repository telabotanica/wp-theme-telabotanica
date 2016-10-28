<?php function telabotanica_module_cover($data) {
  if (!isset($data->image)) $data->image = get_field('cover_image');
  if (!isset($data->title)) $data->title = get_the_title();
  if (!isset($data->subtitle)) $data->subtitle = get_field('cover_subtitle');
  ?>
  <div class="cover" style="background-image: url(<?php echo $data->image['url'] ?>);">
    <div class="layout-wrapper">
      <h1 class="cover-title"><?php echo @$data->title ?></h1>
      <?php if ($data->subtitle) : ?>
        <div class="cover-subtitle"><?php echo $data->subtitle ?></div>
      <?php endif; ?>
    </div>
    <?php if ($data->image) :
      $credits = get_fields($data->image['ID']);
      if ($credits) : ?>
        <div class="cover-credits">
          <?php if ($credits['link']) {
            echo sprintf(__('%s par %s', 'telabotanica'), '<a href="' . $credits['link'] . '" target="_blank">' . $data->image['title'] . '</a>', $credits['author']);
          } else {
            echo sprintf(__('%s par %s', 'telabotanica'), $data->image['title'], $credits['author']);
          } ?>
        </div>
      <?php endif;
    endif; ?>
  </div>
<?php }
