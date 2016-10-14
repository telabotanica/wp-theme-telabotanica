<?php function telabotanica_module_bandeau($data) {
  if (!isset($data->image)) $data->image = get_field('bandeau-image');
  if (!isset($data->titre)) $data->titre = get_the_title();
  if (!isset($data->soustitre)) $data->soustitre = get_field('bandeau-soustitre');
  ?>
  <div class="bandeau" style="background-image: url(<?php echo $data->image['url'] ?>);">
    <div class="layout-wrapper">
      <h1 class="bandeau-titre"><?php echo @$data->titre ?></h1>
      <?php if ($data->soustitre) : ?>
        <div class="bandeau-soustitre"><?php echo $data->soustitre ?></div>
      <?php endif; ?>
    </div>
    <?php if ($data->image && $data->image['description']) : ?>
      <div class="bandeau-credits">
        <?php echo $data->image['description']; ?>
      </div>
    <?php endif; ?>
  </div>
<?php }
