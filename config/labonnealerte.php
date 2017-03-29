<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Security
$config['scraper_trigger_key'] = 'dAadSJRkAmbAAl6';
$config['notifications_trigger_key'] = 'fXW7JdDM0333Yjc';
$config['email_activated'] = true;
$config['allowed_emails'] = array('thibaut.camberlin@gmail.com',
	'marionc.casanova@gmail.com',
	'juliencasanova@gmail.com',
	'benjamin.lanciaux@gmail.com',
	'raphaellemontefiore@gmail.com',
	'laurent.wlodarczyk@gmail.com',
    'philiberti@noos.fr',
	'guillaume.delhumeau@gmail.com',
	'blacouturiere@hotmail.fr',
	'do-la@hotmail.fr',
	'nsalem@aelia.com',
	'pauline.carrat@gmail.com');

$config['alpha_welcome'] = "La Bonne Alerte fonctionne sur invitation. N'hésitez pas à nous contacter si vous souhaitez tester notre service.<br />Merci de votre intérêt : ";
$config['site_title'] = 'La Bonne Alerte';
$config['site_description'] = "Soyez alerté par email dès la publication d'une annonce sur le site leboncoin.fr";
$config['site_tagline'] = "\"La Bonne Alerte\" vous envoie un email dès qu'une annonce du site <a href='http://www.leboncoin.fr/'>leboncoin.fr</a> correspondant à votre recherche est publiée.
<div>Actuellement uniquement disponible pour la région île de France.</div>";

$config['email_not_allowed'] = 'Votre email (%s) ne fait pas parti des emails invités. Vous pouvez en faire la demande via le lien ci-dessus. Merci.';

$config['alert_email_validation_email_subject'] = '[La Bonne Alerte] Bienvenue sur "La Bonne Alerte", validez dès maintenant votre adresse mail !';
$config['alert_email_validation_body']          = "Bonjour et bienvenue, <br /><br />Nous espérons que vous aurez pleine satisfaction avec La Bonne Alerte. N'hésitez pas nous donner votre opinion et commentaires sur votre utilisation de notre service !<br /><br />Il ne vous reste plus qu'à valider votre adresse mail afin d'activer le service, en cliquant sur lien suivant : <a href=\"%s\">valider mon adresse mail</a> .<br /><br />. Merci de vote confiance,<br />Thibaut";

$config['alert_email_resend_validation_email_subject'] = '[La Bonne Alerte] Bienvenue sur "La Bonne Alerte", validez dès maintenant votre adresse mail !';
$config['alert_email_resend_validation_body']          = "Bonjour et bienvenue, <br /><br />Vous recevez ce message car vous avez souhaité recevoir un nouvel email de validation de votre adresse mail : <a href=\"%s\">valider mon adresse mail</a>.<br /><br />Nous espérons que vous aurez pleine satisfaction avec \"La Bonne Alerte\"<br /><br />. Merci de vote confiance,<br />Thibaut";

$config['alert_created_needs_validation'] = "Votre alerte a été créée. Vous devez maintenant valider votre adresse mail afin d'activer votre alerte en cliquant sur lien de validation contenu dans l'email que vous venez de recevoir.<br /><br />
Merci d'utiliser \"La Bonne Alerte\" !";
$config['alert_created_no_validation'] = "Votre alerte a été créée.<br /><br />
Merci de continuer d'utiliser \"La Bonne Alerte\" !";
$config['alert_not_created'] = "Oops... c'est embarrassant : votre alerte n'a pu étre créée. Vous pouvez essayer à nouveau, ou <a href='mailto:thibaut@labonnealerte.fr'>me contacter</a> afin de m'informer du bug.<br />Merci.";


$config['email_validation_ok']  = "Votre email est maintenant validé. Merci !<br /><br /> Vous serez alerté dès qu'une annonce correspondant à votre recherche sera publiée sur <a href='http://leboncoin.fr/'>leboncoin.fr</a>.";
$config['alert_operation_nok'] = "Oops. L'opération n'a pas pu être effectuée.<br />Vous pouvez réessayer plus tard, ou nous contacter pour nous indiquer le bug... ";
$config['alert_deactivation_ok']  = "Votre alerte a été désactivée. Nous espérons que vous continuerez d'utiliser \"La Bonne Alerte\" prochainement.";
$config['resend_validation_ok'] = "Nous venons de vous renvoyer un email de validation à l'adresse %s.<br /><br />Merci d'utiliser \"La Bonne Alerte\".";

$config['notification_email_body_intro_single'] = "Bonjour,<br/><br/>Notre service a détecté une annonce qui pourrait vous intéresser, la voici :";
$config['notification_email_body_intro_several'] = "Bonjour,<br/><br/>Notre service a détecté des annonces qui pourraient vous intéresser, les voici :";


$config['email_resend_ui_message'] = "Votre alerte a été créée.<br/>Cependant, vous n'avez pas encore validé votre adresse mail. Lors de la précédente création d'alerte, vous avez du recevoir une email de validation. Pouvez-vous vérifier votre dossier spam ?<br /><br />Vous pouvez également <a href='%s'>recevoir un nouvel email de validation</a>.";

$config['too_many_alerts_created'] = "La Bonne Alerte étant en version beta, un seuil de 15 alertes par email ne peut être dépassé. Vous ne pouvez donc plus créer d'alertes. Vous pouvez supprimer vos alertes existantes en cliquant sur le lien présent dans chaque email.<br /><br />Merci de votre confiance.";

$config['notification_email_subject'] = '[La Bonne Alerte] %d annonces pour votre recherche "%s"';
$config['from_email'] = 'thibaut@labonnealerte.fr';
$config['from_name'] = 'Thibaut, La Bonne Alerte';

$config['notification_email_deactivation_link'] = 'Vous pouvez désactiver cette alerte en cliquant sur le lien suivant : %s';

/* End of file labonnealerte.php */
/* Location: ./application/config/labonnealerte.php */
