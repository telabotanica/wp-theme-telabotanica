<?php
/**
 * Template pour le formulaire de désinscription de la newsletter
 *
 * Charge les options "URL annuaire" et "Jeton SSO administrateur" définies par
 * le plugin Tela Botanica, et envoie un ordre de désinscription à toute
 * personne saisissant son adresse email dans le formulaire
 */
 /*
Template Name: newsletter-desinscription
*/

// Entête du thème
get_header();

// Détection du plugin Tela Botanica
// @WARNING attention à ne pas renommer le dossier
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active( 'tela-botanica/tela-botanica.php')) {
	// Lecture de la configuration (adresse du service ezmlm-php, jeton SSO admin)
	$newsletter_config = json_decode(get_option('tb_newsletter_config'), true);
	$general_config = json_decode(get_option('tb_general_config'), true);

	if (! empty($general_config['adminToken'])
		&& ! empty($newsletter_config['ezmlm_php_url'])
		&& ! empty($newsletter_config['newsletter_recipient'])) {

		$jeton_admin_sso = $general_config['adminToken'];
		$ezmlm_php_url = $newsletter_config['ezmlm_php_url'];
		$ezmlm_php_header = "Authorization"; // défaut confortable
		if (! empty($newsletter_config['ezmlm_php_header'])) {
			$ezmlm_php_header = $newsletter_config['ezmlm_php_header'];
		}
		$adresse_liste = $newsletter_config['newsletter_recipient'];
		// ezmlm-php s'attend à recevoir le nom de la liste, sans son domaine
		$nom_liste = substr($adresse_liste, 0, strpos($adresse_liste, '@'));

		/**
		 * Affiche le formulaire de désinscription, et le traite une fois posté :
		 * appelle le service ezmlm-php avec un jeton administrateur pour désinscrire
		 * l'adresse email fournie de la liste configurée
		 */
		if (! empty($_POST['name'])) {
			//robot
		} elseif (!empty ($_POST['email'])) {
			$email = trim($_POST['email']);
			$unsubscribe_url = $ezmlm_php_url . '/lists/' . $nom_liste . '/subscribers/' . $email;

			$ch = curl_init();
			curl_setopt_array($ch, array(
				CURLOPT_CUSTOMREQUEST => 'DELETE',
				CURLOPT_HTTPHEADER => [$ezmlm_php_header . ': ' . $jeton_admin_sso],
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_FAILONERROR => 1,
				CURLOPT_URL => $unsubscribe_url
			));

			$contenu = curl_exec($ch);

			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($http_code == 200) { // @WARNING se méfier d'un potentiel changement de code 2**
				?>
				<p>
					L'adresse <strong><?= $email ?></strong> a bien été désinscrite de la lettre d'actualités.
				</p>
				<?php
			} else {
				var_dump($contenu);
				var_dump($http_code);
				var_dump(curl_error($ch));
			}

			curl_close($ch);
		}
		?>
		<form method="post" action="">
			<input type="hidden" name="name" id="name">

			<label for="email">Votre adresse email</label>
			<input type="email" name="email" id="email" size="60">

			<input type="submit" name="submit" value="Me désinscrire">
		</form>
		<?php
	} else {
		?>
		<p>
			Configuration incomplète.
			<br/>
			Vérifiez que vous avez défini "URL racine du service ezmlm-php" dans
			"Newsletter" > "Réglages".
			<br/>
			Vérifiez que vous avez défini "Adresse destinataire" dans
			"Newsletter" > "Envoyer la newsletter".
			<br/>
			Vérifiez que vous avez défini "Jeton SSO administrateur" dans
			"Tela Botanica" > "Sécurité".
		</p>
		<?php
	}
} else {
	?>
	<p>Vérifiez que le plugin Tela Botanica est installé et activé.</p>
	<?php
}

// Pied du thème
get_footer();
