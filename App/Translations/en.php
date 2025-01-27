<?php

const MAIL_NEWUSER_SUBJECT = 'Welcome to PluXml Nexus';

const MAIL_NEWUSER_BODY = <<< EOT
<p>Hello ##USERNAME##,</p>
<p>To complete your signup and be able to login to <a href="##HREF##">##HREF##</a>, please confirm your email address by clicking the link below :</p>
<p><a href="##LINK##">##LINK##</a></p>
<p>This link will expire in ##HOURS##H.</p>
EOT;

const  _ = array(
	'BACKOFFICE'	=> 'Backoffice',
	'WARNING'	=> 'Warning',
	'UNIQUE_NAME_PLUGIN'	=> 'The plugin name must be unique',
	'ZIP_ARCHIVE'	=> 'The uploaded file must be a "zip" archive',
	'ZIP_RENAME_PLUGIN'	=> 'The uploaded file will be renamed with the plugin name',
	'NAME'	=> 'name',
	'DESCRIPTION'	=> 'description',
	'CATEGORY'	=> 'category',
	'VERSION'	=> 'version',
	'PLUXML'	=> 'PluXml',
	'LINK'		=> 'link',
	'FILE'		=> 'file',	
	'NEW_PLUGIN'	=> 'New plugin',
	'SAVE'		=> 'save',
	'HELLO'		=> 'Hello',
	'PLUGINS'	=> 'plugins',
	'THEMES'		=> 'themes',
	'MY_PROFILE'	=> 'my profile',
	'USERS'	=> 'users',
	'ADD_EDIT_PLUGIN'	=> 'Add or edit a plugin',
	'ADD_PLUGIN'	=> 'Add a plugin',
	'NO_PLUGIN_EDIT'	=> 'No plugins to edit',
	'ADD_EDIT_THEME'	=> 'Add or edit a theme',
	'ADD_THEME'	=> 'Add a theme',
	'NO_THEME_EDIT'	=> 'No theme for editing',
	'EDIT_MY_PROFILE'	=> 'Edit my profile',
	'DISPLAY_REGISTERED_USERS'	=> 'Display registered users',
	'NAME'	=> 'Name',
    'DESCRIPTION' => 'Description',
    'VERSION' => 'Version',
    'PLUXML' => 'PluXml version',
    'WEBSITE' => 'Website',
    'ACTION' => 'Action',
	'EDIT'	=> 'Edit',
	'LOGIN' => 'identifiant',
	'EMAIL' => 'courriel',
	'WEBSITE' => 'site internet',
	'PLUGINS' => 'plugins',
	'THEMES' => 'thèmes',
	'VALIDATE_BEFORE' => 'valider avant le',
	'ACTIONS' => 'actions',	
	'NO_USERS_FOUND' => 'Aucun utilisateur trouvé',
	'DROP' => 'supprimer',
	'INVALIDATE_USERS' => 'utilisateurs à invalider',
	'CONTRIBUTORS' => 'contributeurs',
	'SIGN_UP' => 's\'inscrire',
	'LOG_IN' => 'se connecter',
	'LOG_OUT' => 'quitter',
	'RESSOURCES' => 'Ressources',
	'DOWNLOAD' => 'télécharger',
	'CATEGORIES' => 'catégories',
	'ALL' => 'Toutes',
	'INSTALLATION' => 'Installation',
	'DOC_INSTALL' => 'Although PluXml is very easy to install, documentation is  %s.',
	'AVAILABLE_HERE' => 'available here',
);
