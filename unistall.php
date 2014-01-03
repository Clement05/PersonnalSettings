<?php
/* 
	Le code contenu dans cette page ne sera �xecut� qu'� la d�sactivation du plugin 
	Vous pouvez donc l'utiliser pour supprimer des tables SQLite, des dossiers, ou executer une action
	qui ne doit se lancer qu'� la d�sinstallation ex :
*/
$ps = new PersonnalSettings();
$ps->drop();

$ps_section = new Section();
$id_section = $ps_section->load(array("label"=>"PersonnalSettings"))->getId();
$ps_section->delete(array('label'=>'PersonnalSettings'));

$ps_right = new Right();
$ps_right->delete(array('section'=>$id_section));
?>
