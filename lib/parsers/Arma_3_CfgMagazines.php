<?php
class Arma_3_CfgMagazines extends BIWikiCfgPageParser {
  protected function handleRow($key, $row) {
    $tds = $row->find('td');

    if (count($tds) < 5) {
      return;
    }

    $class = $tds[0]->find('b', 0)->plaintext;

    $name = $tds[1]->find('i', 0);

    if ($name !== null) {
      $name = $name->plaintext;
    }

    $invdescr = $tds[2]->find('i', 0);

    if ($invdescr !== null) {
      $invdescr = $invdescr->innertext;
    }

    $ammo = trim($tds[3]->plaintext);

    if (empty($ammo)) {
      $ammo = null;
    }

    $usedby = $tds[4]->find('dl', 0);

    if ($usedby !== null) {
      $usedby = explode('  ', trim($usedby->plaintext));
    } else {
      $usedby = array();
    }

    $this->final_content[] = array(
      'class' => $class,
      'name' => $name,
      'description' => $invdescr,
      'ammo' => $ammo,
      'usedby' => $usedby
    );
  }
}