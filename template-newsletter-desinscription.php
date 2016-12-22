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

get_header();

?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php //the_telabotanica_module('cover'); ?>
		<div class="layout-wrapper">
			<div class="layout-content">
				<?php the_telabotanica_module('breadcrumbs'); ?>
				<article class="article">
					<div class="component component-title level-2">
						<h1>Me désinscrire de la lettre d'actualités</h1>
					</div>

<?php
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
		$destinataires_emails_erreurs = $newsletter_config['error_recipients_emails'];
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
				/**
				 * Lors d'un échec de désinscription, envoie une alerte par email
				 * aux destinataires listés dans la configuration du plugin :
				 * "Newsletter" => "Réglages" => "Destinataires des emails d'erreurs"
				 */
				$message = 'Désinscription à la lettre d\'actu : erreur ! ' . "\r\n"
					. "\r\n"
					. 'Adresse à désinscrire : ' . $email . "\r\n"
					. 'Liste : ' . $adresse_liste . "\r\n"
					. 'URL appelée : ' . $unsubscribe_url . "\r\n"
					. 'Code de retour HTTP : ' . $http_code . "\r\n"
					. 'Erreur cURL : ' . curl_error($ch) . "\r\n"
					. 'Message renvoyé par le service : ' . $contenu . "\r\n"
				;

				$headers = 'Content-Type: text/plain; charset="utf-8"' . "\r\n"
					. 'Content-Transfer-Encoding: 8bit' . "\r\n"
					. 'From: wp-newsletter@tela-botanica.org' . "\r\n"
					. 'Reply-To: no-reply@example.com' . "\r\n"
					. 'X-Mailer: PHP/' . phpversion()
				;

				foreach ($destinataires_emails_erreurs as $destinataire) {
					if ($destinataire && '#' !== substr($destinataire, 0, 1)) {
						error_log($message, 1, $destinataire, $headers);
						error_log($message);
					}
				}
				?>
				<p>
					Une erreur est survenue lors de la désinscription, nous en avons eté informés.
					<br/>
					Pour plus d'informations n'hésitez pas à nous contacter.
				</p>
				<?php
			}

			curl_close($ch);
		}
		?>
		<form method="post" action="" class="form-newsletter layout-column">
			<input type="hidden" name="name" id="name">
			<fieldset class="form-newsletter-fields">
				<input class="form-newsletter-email" type="email" name="email" placeholder="Votre adresse e-mail" type="email">
				<svg aria-hidden="true" role="img" class="icon icon-mail "><use xlink:href="#icon-mail"/></svg>
				<button class="form-newsletter-button" type="submit">
					Me désinscrire
				</button>
			</fieldset>
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

?>
				</article>
			</div>
		</div>
	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php
get_footer();
