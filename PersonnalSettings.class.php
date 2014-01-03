<?php

/*
 @nom: Personnal Settings
 @auteur: Clément Girard 
 @description:  Classer de paramètres personnels
 */

//Ce fichier permet de gerer vos donnees en provenance de la base de donnees

//Il faut changer le nom de la classe ici (je sens que vous allez oublier)
class PersonnalSettings extends SQLiteEntity{

	
	protected $id,$name,$description;
	protected $TABLE_NAME = 'plugin_PersonnalSettings';
	protected $CLASS_NAME = 'PersonnalSettings';
	protected $object_fields = 
	array(
		'id'=>'key',
		'name'=>'string',
		'description'=>'string'
	);

	function __construct(){
		parent::__construct();
	}

	function setId($id){
		$this->id = $id;
	}
	
	function getId(){
		return $this->id;
	}

	function getName(){
		return $this->name;
	}

	function setName($name){
		$this->name = $name;
	}

	function getDescription(){
		return $this->description;
	}

	function setDescription($description){
		$this->description = $description;
	}
}

?>
