<?php function telabotanica_module_form_newsletter($data) { ?>
  <form action="#" method="POST" class="form-newsletter <?php echo $data->modifiers ?>">
    <div class="form-newsletter-titre">Recevoir la lettre d'actualités</div>
    <p class="form-newsletter-texte">Chaque jeudi, recevez un condensé de l'actualité du réseau, les évènements et les offres d'emplois directement dans votre boîte mail.</p>
    <fieldset class="form-newsletter-champs">
      <input class="form-newsletter-email" type="email" name="email" placeholder="Votre adresse e-mail" />
      <button class="form-newsletter-bouton" type="submit">></button>
    </fieldset>
  </form>
<?php }
