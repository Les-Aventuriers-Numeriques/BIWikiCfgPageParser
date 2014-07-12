<?php
class Arma_3_CfgWeapons_Items extends BIWikiCfgPageParser {
  protected function handleRow($key, $row) {
    $tds = $row->find('td');

    if (count($tds) < 6) {
      return;
    }

    $class = $tds[1]->find('b', 0)->plaintext;

    $img = $tds[0]->find('img', 0);

    if ($img !== null) {
      $img = parse_url($this->url, PHP_URL_SCHEME).'://'.parse_url($this->url, PHP_URL_HOST).str_replace(array('thumb/'), '', substr($img->src, 0, strrpos($img->src, '/')));

      if (!is_dir($this->output.$this->page)) {
        mkdir($this->output.$this->page);
      }

      file_put_contents($this->output.$this->page.'/'.$class.'.jpg', $this->getUrl($img));
    }

    $name = $tds[2]->find('i', 0);

    if ($name !== null) {
      $name = $name->plaintext;
    }

    $invdescr = $tds[3]->find('i', 0);

    if ($invdescr !== null) {
      $invdescr = $invdescr->innertext;
    }

    $magazines = $tds[4]->find('dl', 0);

    if ($magazines !== null) {
      $magazines = explode('  ', trim($magazines->plaintext));
    } else {
      $magazines = array();
    }

    $usedby = $tds[5]->find('dl', 0);

    if ($usedby !== null) {
      $usedby = explode('  ', trim($usedby->plaintext));
    } else {
      $usedby = array();
    }

    $this->final_content[] = array(
      'class' => $class,
      'name' => $name,
      'description' => $invdescr,
      'magazines' => $magazines,
      'usedby' => $usedby
    );
  }
}