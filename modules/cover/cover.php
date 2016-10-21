<?php function telabotanica_module_cover($data) {
  if (!isset($data->image)) $data->image = get_field('cover-image');
  if (!isset($data->title)) $data->title = get_the_title();
  if (!isset($data->subtitle)) $data->subtitle = get_field('cover-subtitle');
  ?>
  <div class="cover" style="background-image: url(<?php echo $data->image['url'] ?>);">
    <div class="layout-wrapper">
      <h1 class="cover-title"><?php echo @$data->title ?></h1>
      <?php if ($data->subtitle) : ?>
        <div class="cover-subtitle"><?php echo $data->subtitle ?></div>
      <?php endif; ?>
    </div>
    <?php if ($data->image && $data->image['description']) : ?>
      <div class="cover-credits">
        <?php echo $data->image['description']; ?>
      </div>
    <?php endif; ?>
  </div>
<?php }
