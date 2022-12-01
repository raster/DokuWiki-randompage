<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Pete Prodoehl <pete@2xlnetworks.com> and Jean Marc Massou <massou@gmail.com>
 */

require_once(DOKU_PLUGIN . 'action.php');

class action_plugin_randompage extends Dokuwiki_Action_Plugin
{

	/**
	 * Register its handlers with the dokuwiki's event controller
	 */
	function register(Doku_Event_Handler $controller)
	{
		//	$controller->register_hook('ACTION_HEADERS_SEND', 'BEFORE', $this, 'init', 'header');
		$controller->register_hook('ACTION_ACT_PREPROCESS', 'BEFORE', $this, 'init', 'header');
	}

	function init(Doku_Event $event, $args)
	{
		// Catch the good request
		if ($_REQUEST['do'] == 'randompage' || $_REQUEST['do'] == 'nsrandompage') {

			// $event->preventDefault(); //https://github.com/solewniczak/dokuwiki-plugin-randompage2/blob/master/action.php
			// $event->data = 'show';  // https://forum.dokuwiki.org/d/18265-actionplugin-throwing-error-action-unknown-action-plugin
			if ($args == 'header') {
				$this->action_randompage($event, $args);
			}
		}
	}


	function action_randompage($event, $args)
	{

		global $conf;
		global $ID;
		global $INFO;

		$data = array();
		$dir = $conf['savedir'];

		$data = file($dir . '/index/page.idx');

		//if current page is in 
		function isCurNS($value)
		{
			global $INFO;
			return stripos($value, $INFO['namespace']) === 0 ? true : false;
		}

		if ($INFO['namespace'] != null && $_REQUEST['do'] == 'nsrandompage') {
			$data = array_filter($data, "isCurNS");
		}

		//We loops through ten random page...
		$i = 1;
		while ($i <= 10 & $i <> "ok") :
			//echo $i;
			$i++;

			$id = rtrim($data[array_rand($data)]);
			$testACL = auth_aclcheck($id, $_SERVER['REMOTE_USER'], $USERINFO['grps']);

			if (($testACL > 1) and (file_exists(wikiFN($id)))) {
				$i = "ok";
				//echo $id;
			}

		endwhile;

		if ($testACL < 1) {
			$id = $ID;
		}

		send_redirect(wl($id, '', true, '&'));
		//		header("Location: " . wl(trim($id), '', true));
		//echo wl($page,'',true);
		exit();
	}

	//Function from Php manual to get  a random number in a Arraye
	function array_rand($array, $lim = 1)
	{
		mt_srand((float) microtime() * 1000000);
		for ($a = 0; $a <= $lim; $a++) {
			$num[] = mt_srand(0, count($array) - 1);
		}
		return @$num;
	}
}
