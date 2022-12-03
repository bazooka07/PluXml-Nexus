<?php

const MAIL_NEWUSER_SUBJECT = 'Bienvenue sur PluXml Nexus';

const MAIL_NEWUSER_BODY = <<< EOT
<p>Bonjour ##USERNAME##,</p>
<p>Pour confirmer votre inscription et pouvoir vous connecter à <a href="##HREF##">##HREF##</a>, iveuillez confirmer votre adresse de courriels en cliquant sur le lien ci-dessous :</p>
<p><a href="##LINK##">##LINK##</a></p>
<p>Ce lien est valable pendant ##HOURS##H.</p>
EOT;

const  _ = array(
	'BACKOFFICE'	=> 'Administration',
	'WARNING'	=> 'Avertissement',
	'UNIQUE_NAME_PLUGIN'	=> 'Le nom du plugin doit être unique pour chaque auteur.',
	'UNIQUE_NAME_THEME'	=> 'Le nom du thème doit être unique pour chaque auteur.',
	'ZIP_ARCHIVE'	=> 'Le fichier à téléverser doit être une archive Zip.',
	'ZIP_RENAME_PLUGIN'	=> 'Le fichier téléversé sera renommé avec le nom du plugin',
	'ZIP_RENAME_THEME'	=> 'Le fichier téléversé sera renommé avec le nom du thème',
	'NAME'	=> 'nom',
	'DESCRIPTION'	=> 'description',
	'CATEGORY'	=> 'catégorie',
	'VERSION'	=> 'version',
	'PLUXML'	=> 'PluXml',
	'LINK'		=> 'lien internet',
	'FILE'		=> 'fichier',	
	'DATE'		=> 'Date',
	'SAVE'		=> 'Enregistrer',
	'DELETE'	=> 'Supprimer',
	'HELLO'		=> 'Bonjour',
	'PLUGINS'	=> 'plugins',
	'PLUGIN'	=> 'plugin',
	'NEW_PLUGIN'	=> 'Nouveau plugin',
	'THEMES'	=> 'thèmes',
	'THEME'		=> 'thème',
	'NEW_THEME'	=> 'Nouveau thème',
	'MY_PROFILE'	=> 'mon  profil',
	'USERS'	=> 'utilisateurs',
	'ADD_EDIT_PLUGIN'	=> 'Ajouter ou éditer un plugin',
	'ADD_PLUGIN'	=> 'Ajouter un plugin',
	'NO_PLUGIN_EDIT'	=> 'Aucun plugin à éditer',
	'EDIT_PLUGIN'	=> 'Édition du plugin',
	'ADD_EDIT_THEME'	=> 'Ajouter ou éditer un thème',
	'ADD_THEME'	=> 'Ajouter un thème',
	'NO_THEME_EDIT'	=> 'Aucun thème à éditer',
	'EDIT_THEME'	=> 'Édition du thème',
	'EDIT_MY_PROFILE'	=> 'Editer mon profil',
	'DISPLAY_REGISTERED_USERS'	=> 'Afficher les utilisateurs validés',
	'NAME'	=> 'Nom',
    'DESCRIPTION' => 'Description',
    'VERSION' => 'Version',
    'PLUXML' => 'Version PluXml',
    'WEBSITE' => 'Site Internet',
    'ACTION' => 'Action',
	'EDIT'	=> 'Éditer',
	'LOGIN' => 'Identifiant',
	'PASSWORD' => 'Mot de passe',
	'PASSWORD_CONFIRM' => 'Confirmation du mot de passe',
	'LOST_PASSSWORD' => 'Mot de passe perdu',
	'EMAIL' => 'courriel',
	'WEBSITE' => 'site internet',
	'PLUGINS' => 'plugins',
	'THEMES' => 'thèmes',
	'VALIDATE_BEFORE' => 'valider avant le',
	'ACTIONS' => 'actions',	
	'NO_USERS_FOUND' => 'Aucun utilisateur trouvé',
	'DROP' => 'supprimer',
	'INVALIDATE_USERS' => '%d inscriptions non confirmées',
	'CONTRIBUTORS' => 'contributeurs',
	'AUTHOR' => 'Auteur',
	'SIGN_UP' => 's\'inscrire',
	'LOG_IN' => 'Connexion',
	'LOG_OUT' => 'Quitter',
	'RESSOURCES' => 'Ressources',
	'DOWNLOAD' => 'Télécharger',
	'CATEGORIES' => 'catégories',
	'ALL' => 'Toutes',
	'INSTALLATION' => 'Installation',
	'DOC_INSTALL' => 'Bien que l\'installation de PluXml soit intuitive, une documentation est %s.',
	'AVAILABLE_HERE' => 'disponible ici',
	'PREVIOUS_VERSIONS' => 'Versions précèdentes',
	'REGISTRATION' => 'Inscription',
	'REGISTRATION_REQUEST' => 'S\'inscrire',
	'AUTHENTIFICATION_REQUIRED' => 'Identifiez-vous', #Auhtentification needed
	'LOST_YOUR_PASSWORD' => 'Votre mot de passe est perdu ?',
	'GET_NEW_PASSWORD' => 'Obtenir un nouveau mot de passe',
	'BACK_TO_LOG_IN' => 'Retour à la page de connexion',
	'FAILURE_USER' => 'Utilisateur inconnu',

	'MSG_LOGOUT' => 'Déconnexion réussie',  # Log out successful;
	'MSG_ERROR_LOGIN' => 'Identifiant ou mot de passe invalides', #'Wrong username or password';
	'MSG_ERROR_SIGNUP' => 'Erreur d\'inscription. Voir ci-dessous', #'Signup error, please see below';
	'MSG_ERROR_CONFIRMEMAIL' => 'Échec à la confirmation du courriel', #'Email confirmation failed';
	'MSG_SUCCESS_SIGNUP' => 'Inscription réussie. Confirmez avec votre courriel avant de vous connecter', #'Signup successful, please confirm your email address to be able to login';
	'MSG_SUCCESS_CONFIRMEMAIL' => 'Confirmation par courriel réussie', #'Email address confirmation success';
	'MSG_SUCCESS_LOSTPASSWORDEMAIL' => 'Un courriel vous a été envoyé pour ré-initialise votre mot de passe', #'An e-mail has been sent to you, allowing you to reset your password';
	'MSG_SUCCESS_RESETPASSWORD' => 'Mot de passe actualisé', #'Your password has been updated';
	'MSG_VALID_USERNAME' => 'Doit être des lettres ou chiffres sans espace', #'Must be alphanumeric with no whitespace';
	'MSG_VALID_PASSWORD' => 'Doit être inférieur à 100 caractères', #'Lengh must be inferior to 100 characters';
	'MSG_VALID_PASSWORDCONFIRM' => 'Les mots de passe ne sont pas identiques', #'Password does not match';
	'MSG_SUCCESS_EDITPROFILE' => 'Profil mis à jour', # Profile updated with success
			'MSG_ERROR_EDITPROFILE' => 'Votre profil ne peut pas être modifié. Voir ci-dessous', # Profile can not be updated, see errors below
	'MSG_VALID_NAME' => 'Doit contenir des lettres ou chiffres sans espace', # Must be alphanumeric with no whitespace
	'MSG_VALID_TOLONG1000' => 'invalide ou trop long (1000 caractères maximum)', # Invalid or to long (1000 characters max)
	'MSG_VALID_TOLONG100' => 'invalide ou trop long (100 caractères maximum', # Invalid or to long (100 characters max)
	'MSG_VALID_FILE' => 'Archive zip non reconnu ou avec taille > 10MB', # Invalid zip archive file or more big than 10MB
	'MSG_SUCCESS_EDITRESSOURCE' => 'Enregistrement %s réussi', # %s saved with success
	'MSG_SUCCESS_DELETERESSOURCE' => '%s supprimé', # %s deleted with success
	'MSG_ERROR_TECHNICAL_RESSOURCES' => 'Erreur interne ou le nom %s existe déjà', # Technical error or %s name already exist
	'UNAVAILABLE' => 'Non disponible',
	'DEL_CONTRIBUTOR' => 'Confirmez-vous la suppression de #username# qui a contribué à :\n- #plugins# plugin(s)\n- #themes# theme(s) ?',
	'DEL_USER' => 'Etes-vous sur de supprimer l\'utilisateur #username# ?',
	'DROPPED_USERS' => '%d utilisateurs supprimés',
	'EXPIRED_USERS' => '%d inscriptions expirées',
	'DROP_EXPIRED_USERS' => 'Supprimer %d inscriptions expirées ?',
	'DROPPED_ONE_USER' => 'l\'utilisateur %s a été supprimé',
	'FAILED' => 'Échec',
	'LASTCONNECTED' => 'Dernière connection',
	'LAST_CONNECTION' => 'Dernière connexion le $3/$2/$1 à $4h$5',
	# 'LAST_CONNECTION' => 'Letzter Anschluss am $3.$2.$1 um $4:$5 Uhre',
	# 'LAST_CONNECTION' => 'Última conexión el $3/$2/$1 a las $4:$5h',
	# 'LAST_CONNECTION' => 'Last connection on $3/$2/$1 at $4:$5',
	'DISABLED_SIGNUP' => 'Ce service est momentanément indisponible.
Merci de renouveler votre demande ultérieurement !',
	# 'DISABLED_SIGNUP' => 'Sorry, this service is temporarily disabled. Try again later !',
);
