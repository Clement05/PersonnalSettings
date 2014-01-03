<?php
/*
@name Personnal Settings
@author Clément GIRARD <clement.girard4@gmail.com>
@link https://sites.google.com/site/clementgirard4/
@licence CC by nc sa
@version 1.0.0
@description Plugin de paramètres avancés
*/

//Si vous utiliser la base de donnees a ajouter
include('PersonnalSettings.class.php');

//Cette fonction va generer un nouveau element dans le menu horizontal
function ps_plugin_menu(&$menuItems){
	global $_;
	$menuItems[] = array('sort'=>10,'content'=>'<a href="index.php?module=PersonnalSettings"><i class="icon-th-large"></i> Personnal Settings</a>');
}

//Cette fonction va generer un nouveau element dans le menu de préférences
function ps_plugin_setting_menu(){
	global $_;
	echo '<li '.(isset($_['section']) && $_['section']=='PersonnalSettings'?'class="active"':'').'><a href="setting.php?section=PersonnalSettings"><i class="icon-chevron-right"></i> Personal Settings</a></li>';
	
}

//Cette fonction décrit le contenu de l'élément du menu de préférence
function ps_plugin_setting_page(){
	global $myUser,$_;
	
	if(isset($_['section']) && $_['section']=='PersonnalSettings' ){
		if($myUser!=false){
			$psManager = new PersonnalSettings();
			$sets = $psManager->populate();

	//Gestion des modifications
			if (isset($_['id'])){
				$id_mod = $_['id'];
				$selected = $psManager->getById($id_mod);
				$description = $selected->getName();
				$button = "Modifier";
			}
			else
			{
				$description =  "Ajout d'un paramètre";
				$button = "Ajouter";
			} 

			?>

			<div class="span9 userBloc">


				<h1>Personnal Settings</h1>
				<p>Gestion des paramètres avancés</p>  

				<form action="action.php?action=ps_add_ps" method="POST"> 
					<fieldset>
						<legend><? echo $description ?></legend>

						<div class="left">
							<label for="namePS">Nom</label>
							<? if(isset($selected)){echo '<input type="hidden" name="id" value="'.$id_mod.'">';} ?>
							<input type="text" value="<? if(isset($selected)){echo $selected->getName();} ?>" id="namePS" name="namePS" placeholder="Nom du paramètre"/>
							<label for="descriptionPS">Valeur</label>
							<input type="text" value="<? if(isset($selected)){echo $selected->getDescription();} ?>" name="descriptionPS" id="descriptionPS" placeholder="Valeur du paramètre"/>
						</div>

						<div class="clear"></div>
						<br/>
							<p style="float: left;"><button type="submit" class="btn"><? echo $button; ?></button>
							</p>
							<p style="float: right;"><a class="btn" href="setting.php?section=PersonnalSettings&save=true&myUser=<?php $myUser ?>"><i class="icon-check icon-black"></i> Enregistrer</a><a class="btn" href="setting.php?section=PersonnalSettings"><i class="icon-remove icon-black"></i> Annuler</a>
							</p>
					</fieldset>
					<br/>
				</form>

				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>Nom</th>
							<th>Description</th>
							<th></th> 
						</tr>
					</thead>

					<?php foreach($sets as $ps){ ?>
					<tr>
						<td><?php echo $ps->getName(); ?></td>
						<td><?php echo $ps->getDescription(); ?></td>
						<td><?php if($ps->getId()>10){
							?><a class="btn" href="action.php?action=ps_delete_ps&id=<?php echo $ps->getId(); ?>"><i class="icon-remove"></i></a>
						<?php }
						else "";
						?>
							<a class="btn" href="setting.php?section=PersonnalSettings&id=<?php echo $ps->getId(); ?>"><i class="icon-edit"></i></a></td>
						</tr>
						<?php } ?>
					</table>
					<p style="float: right;"><a class="btn btn-danger" href="setting.php?section=PersonnalSettings&reset=true">Reset</a>
					</p>
</div>

				<?php 

					if (isset($_GET['save'])){ // On récupère les données envoyées
					  if ($_GET['save']=="true"){
						edit_constant();
						}
					}
					if (isset($_GET['reset'])){ // On récupère les données envoyées
					  if ($_GET['reset']=="true"){
						reset_constant();
						}
					}
					
				}else{ ?>

				<div id="main" class="wrapper clearfix">
					<article>
						<h3>Vous devez être connecté</h3>
					</article>
				</div>
				<?php
			}
		}
	}

	function ps_action_ps(){
		global $_,$myUser;

		//Erreur dans les droits sinon!
		$myUser->loadRight();

		switch($_['action']){

			case 'ps_add_ps':
			$right_toverify = isset($_['id']) ? 'u' : 'c';
			if($myUser->can('PersonnalSettings',$right_toverify)){
				$ps = new PersonnalSettings();
				if ($right_toverify == "u"){$ps = $ps->load(array("id"=>$_['id']));}
				$ps->setName($_['namePS']);
				$ps->setDescription($_['descriptionPS']);
				$ps->save();
			header('location:setting.php?section=PersonnalSettings');	
			}
						else
			{
				header('location:setting.php?section=PersonnalSettings&error=Vous n\'avez pas le droit de faire ça!');
			}
			
			break;

			case 'ps_delete_ps':
			if($myUser->can('PersonnalSettings','d')){
				$psManager = new PersonnalSettings();
				$psManager->delete(array('id'=>$_['id']));
				header('location:setting.php?section=PersonnalSettings');
			}
			else
			{
				header('location:setting.php?section=PersonnalSettings&error=Vous n\'avez pas le droit de faire ça!');
			}

			break;
			}
		}

// Modifier le fichier de constant
function edit_constant(){
		global $_,$myUser;

		//Erreur dans les droits sinon!
		$myUser->loadRight();	
		
	if(isset($_['section']) && $_['section']=='PersonnalSettings' ){
		if($myUser!=false){
			$psManager = new PersonnalSettings();
			$sets = $psManager->populate();
			$body = "";
			
			foreach($sets as $ps){
				$body = $body."define('".$ps->getName()."','".$ps->getDescription()."');";
			}
			$handle = fopen("../yana-server/constant.php", "r+");
			$header = "<?php ";
			$footer = " ?>";
			$constant = $header.$body.$footer;
			ftruncate($handle,0);// on vide le fichier
			fseek($handle, 0); // On remet le curseur au début du fichier
			fputs($handle, $constant); // On écrit le nouveau nombre de pages vues
			fclose($handle);
		}
		else {
			?>
			<div id="main" class="wrapper clearfix">
				<article>
					<h3>Vous devez être connecté</h3>
				</article>
			</div>
			<?php
		}
	}
}

//Reset des paramètres par défaut
function reset_constant(){
		global $_,$myUser;

		//Erreur dans les droits sinon!
		$myUser->loadRight();	
		
	if(isset($_['section']) && $_['section']=='PersonnalSettings' ){
		if($myUser!=false){
			
			include 'uninstall.php';
			include 'install.php';
			
			$psManager = new PersonnalSettings();
			$sets = $psManager->populate();
			$body = "";
			
			foreach($sets as $ps){
				$body = $body."define('".$ps->getName()."','".$ps->getDescription()."');";
			}
			$handle = fopen("../yana-server/constant.php", "r+");
			$header = "<?php ";
			$footer = " ?>";
			$constant = $header.$body.$footer;
			ftruncate($handle,0);// on vide le fichier
			fseek($handle, 0); // On remet le curseur au début du fichier
			fputs($handle, $constant); // On écrit le nouveau nombre de pages vues
			fclose($handle);
			
			}
		else {
			?>
			<div id="main" class="wrapper clearfix">
				<article>
					<h3>Vous devez être connecté</h3>
				</article>
			</div>
			<?php
		}
	}
}

Plugin::addCss("/css/style.css"); 
//Plugin::addJs("/js/main.js"); 

Plugin::addHook("setting_menu", "ps_plugin_setting_menu"); //Ajoute un item à la liste du menu de préférence
Plugin::addHook("setting_bloc", "ps_plugin_setting_page"); //Ajoute le contenu du menu de préférences
Plugin::addHook("action_post_case", "ps_action_ps"); //Ajoute les actions menu de préférences

//Plugin::addHook("menubar_pre_home", "ps_plugin_menu");  
//Plugin::addHook("home", "ps_plugin_page");  
?>
