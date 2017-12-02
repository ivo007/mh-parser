<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| MICE
| -------------------------------------------------------------------
| This file contains an array of mousehunt mice
|
*/

$customers = array(
		
	'ubots' => array(
			'collectibles' => array(),
			'crowns'	=> array('dragon', 'whelpling', 'draconic_warden'),
			'actions'	=> array('crowns')
			),
	'mhcc' => array(
			'collectibles' => array(),
			'crowns'	=> array(),
			'actions'	=> array('collectibles', 'crowns')
			),
	'vermin' => array(
			'collectibles' 	=> array('tournament_trophy_gold_collectible', 'tournament_trophy_silver_collectible', 'tournament_trophy_bronze_collectible'),
			'crowns'		=> array('eclipse', 'desert_boss', 'chess_master', 'balack_the_banished', 'dragon', 'acolyte', 'dojo_sensei', 'silth', 'library_boss'),
			'actions'	=> array('crowns', 'collectibles')
			),
	'lucky' => array(
			'collectibles' => array(),
			'crowns'	=> array('dojo_sensei', 'master_of_the_dojo', 'lucky'),
			'actions'	=> array('crowns')
		),
	'lucia' => array(
			'collectibles' => array(),
			'crowns'	=> array('chrono', 'acolyte', 'lich'),
			'actions'	=> array('crowns')
		)
);

/* End of file mice.php */
/* Location: ./application/config/mice.php */