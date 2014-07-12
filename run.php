<?php
if (php_sapi_name() != 'cli') {
	die('A lancer en ligne de commande.');
}

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
ini_set('log_errors', 0);
ini_set('html_errors', 0);

require('lib/utils.php');
require('lib/simple_html_dom.php');

require('lib/BIWikiCfgPageParser.php');

define('URL', 'https://community.bistudio.com/wiki/');

// --------------------------------------------------------------------- //

message('------------ BIWikiCfgPageParser ------------');
message('Demarrage...');

// Les pages du wiki à parser
$cfgpages_to_parse = array(
  'Arma_3_CfgWeapons_Weapons'/*,
  'Arma_3_CfgMagazines',
  'Arma_3_CfgWeapons_Items',
  'Arma_3_CfgWeapons_Equipment'*/
);

// Pour chaque page
foreach ($cfgpages_to_parse as $cfgpage_to_parse) {
  require('lib/parsers/'.$cfgpage_to_parse.'.php');
  
  $output = 'exports/';

  try {
    $BIWikiCfgPageParser = new $cfgpage_to_parse(URL, $cfgpage_to_parse, $output);
    message('Traitement de '.URL.$cfgpage_to_parse);
    
    message('Telechargement de la page...');
    $BIWikiCfgPageParser->download();
    
    message('Parsage...');
    $BIWikiCfgPageParser->parse();
    
    message('Export dans '.$output.$cfgpage_to_parse.' ...');
    $BIWikiCfgPageParser->export();
    
    unset($BIWikiCfgPageParser);
  } catch (Exception $e) {
    message('! Erreur : '.$e->getMessage());
  }
}
