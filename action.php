<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Pete Prodoehl <pete@2xlnetworks.com> and Jean Marc Massou <massou@gmail.com>
 */

require_once(DOKU_PLUGIN.'action.php');

class action_plugin_randompage extends Dokuwiki_Action_Plugin {

	
	/**
	* Register its handlers with the dokuwiki's event controller
	*/
	function register(&$controller) {
		$controller->register_hook('ACTION_HEADERS_SEND', 'BEFORE', $this, 'init', 'header');
	}


	function init(&$event, $args)
	{
		// Catch the good request
		if ($_REQUEST['do'] == 'randompage') {
			// On efface les headers par defaut
			if ($args == 'header') {
				$this->action_randompage($event, $args);
			}
	
		}
	}


	function action_randompage(&$event, $args) {
	
		global $conf;
		global $ID;
		
		$data = array();
		$dir = $conf['savedir'];
		
		$data = file ($dir.'/index/page.idx');
		
		//We loops through ten random page...
		$i = 1;
		while ($i <= 10 & $i <> "ok"):
		//echo $i;
			$i++;
	
		$id = rtrim($data[array_rand($data, 1)]);
		$testACL = auth_aclcheck($id,$_SERVER['REMOTE_USER'],$USERINFO['grps']);
	
		if (($testACL > 1) and (file_exists(wikiFN($id)))){
			$i="ok";
			//echo $id;
		}
		
		endwhile;
		
		if ($testACL < 1){
			$id = $ID;
		}
		
		header("Location: ".wl($id,'',true));
		//echo wl($page,'',true);
		exit();
	
		}
	
		//Function from Php manual to get  a random number in a Array
		function array_rand($array, $lim=1) {
		mt_srand((double) microtime() * 1000000);
		for($a=0; $a<=$lim; $a++) {
			$num[] = mt_srand(0, count($array)-1);
		}
		return @$num;
		}
    
}
