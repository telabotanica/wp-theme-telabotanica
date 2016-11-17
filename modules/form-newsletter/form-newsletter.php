<?php function telabotanica_module_form_newsletter($data) { ?>
  <form action="#" method="POST" class="form-newsletter <?php echo $data->modifiers ?>">
    <div class="form-newsletter-title"><?php echo __( "Recevoir la lettre d'actualités", 'telabotanica' ) ?></div>
    <p class="form-newsletter-text"><?php echo __( "Chaque jeudi, recevez un condensé de l'actualité du réseau, les évènements et les offres d'emplois directement dans votre boîte mail.", 'telabotanica' ) ?></p>
    <fieldset class="form-newsletter-fields">
      <input class="form-newsletter-email" type="email" name="email" placeholder="<?php echo __( "Votre adresse e-mail", 'telabotanica' ) ?>" />
      <?php the_telabotanica_module('icon', ['icon' => 'mail']) ?>
      <button class="form-newsletter-button" type="submit"><?php the_telabotanica_module('icon', ['icon' => 'arrow-right']) ?></button>
    </fieldset>
  </form>
<?php }
