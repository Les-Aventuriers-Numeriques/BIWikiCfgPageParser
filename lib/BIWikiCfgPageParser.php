<?php
abstract class BIWikiCfgPageParser {
  protected $url, $page, $html, $final_content, $output;
  
  function __construct($url, $page, $output) {
    $this->url = $url;
    $this->page = $page;
    $this->output = $output;
  }
  
  function __destruct() {
    $this->html->clear();
  }

  protected function getUrl($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_USERAGENT, 'BIWikiCfgPageParser PHP/'.PHP_VERSION);

    $response = curl_exec($ch);

    if (!$response) {
      throw new Exception(curl_error($ch));
    }

    curl_close($ch);

    return $response;
  }
  
  public function download() {
    $page = $this->getUrl($this->url.$this->page);
    
    $this->html = str_get_html($page);
    
    if (!$this->html or $this->html == null) {
      throw new Exception('Erreur lors du parsage du code HTML');
    }
  }
  
  public function parse() {
    $table = $this->html->find('table.sortable', 0);
    
    if ($table == null) {
      throw new Exception('Impossible de retrouver le tableau contenant les donnees');
    }
    
    $rows = $table->find('tbody tr');

    foreach ($rows as $key => $row) {
      $this->handleRow($key, $row);
    }
  }
  
  public function export() {
    file_put_contents($this->output.$this->page.'.php', "<?php\r\n// Généré à partir de ".$this->url.$this->page." par BIWikiCfgPageParser\r\n\r\n\$export = ".var_export($this->final_content, true).";");
  }
  
  abstract protected function handleRow($key, $row);
}