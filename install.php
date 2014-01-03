<?php
/* 
	Le code contenu dans cette page ne sera �xecut� qu'� l'activation du plugin 
	Vous pouvez donc l'utiliser pour cr�er des tables SQLite, des dossiers, ou executer une action
	qui ne doit se lancer qu'� l'installation ex :
	
*/
require_once('PersonnalSettings.class.php');
$ps = new PersonnalSettings();
$ps->create();

$s1 = New Section();
$s1->setLabel('PersonnalSettings');
$s1->save();

$r1 = New Right();
$r1->setSection($s1->getId());
$r1->setRead('1');
$r1->setDelete('1');
$r1->setCreate('1');
$r1->setUpdate('1');
$r1->setRank('1');
$r1->save();

$ps = new PersonnalSettings();
$ps->setName('PROGRAM_NAME');
$ps->setDescription('Yana Server');
$ps->save();

$ps = new PersonnalSettings();
$ps->setName('PROGRAM_VERSION');
$ps->setDescription('3.0.4');
$ps->save();

$ps = new PersonnalSettings();
$ps->setName('PROGRAM_AUTHOR');
$ps->setDescription('Valentin CARRUESCO');
$ps->save();

$ps = new PersonnalSettings();
$ps->setName('MYSQL_PREFIX');
$ps->setDescription('yana_');
$ps->save();

$ps = new PersonnalSettings();
$ps->setName('DEFAULT_THEME');
$ps->setDescription('default');
$ps->save();

$ps = new PersonnalSettings();
$ps->setName('VOCAL_ENTITY_NAME');
$ps->setDescription('YANA');
$ps->save();

$ps = new PersonnalSettings();
$ps->setName('DB_NAME');
$ps->setDescription('db/database.db');
$ps->save();

$ps = new PersonnalSettings();
$ps->setName('COOKIE_NAME');
$ps->setDescription('yana');
$ps->save();

$ps = new PersonnalSettings();
$ps->setName('COOKIE_LIFETIME');
$ps->setDescription('7');
$ps->save();

$ps = new PersonnalSettings();
$ps->setName('UPDATE_URL');
$ps->setDescription('http://projet.idleman.fr/yana/maj.php?callback=?');
$ps->save();

?>
