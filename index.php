<?php
// viewer Markdown

require_once __DIR__."/../yamldoc/markdown/PHPMarkdownLib1.8.0/Michelf/MarkdownExtra.inc.php";

use Michelf\MarkdownExtra;

function showdir(string $dirpath='') {
  if ($dh = opendir(__DIR__.'/..'.$dirpath)) {
    echo "<ul>\n";
    while (($file = readdir($dh)) !== false) {
      if (substr($file, -3)=='.md')
        echo "<li><a href='?file=$dirpath/$file'>$file</a></li>\n";
      elseif (is_dir(__DIR__."/..$dirpath/$file") && ($file <> '.'))
        echo "<li><a href='?file=$dirpath/$file'><b>$file</b></a></li>\n";
    }
    echo "</ul>\n";
    closedir($dh);
  }
  echo "<a href='?'><i>Retour</i></a><br>\n";
}

if (!isset($_GET['file'])) {
  echo "<!DOCTYPE HTML><html><head><meta charset='UTF-8'><title>markdown</title></head><body>\n";
  echo "Permet d'afficher un fichier Markdown<br>\n";
  showdir();
  die();
}

// navigation dans les répertoires
elseif (is_dir(__DIR__."/..$_GET[file]")) {
  echo "<!DOCTYPE HTML><html><head><meta charset='UTF-8'><title>md $_GET[file]</title></head><body>\n";
  showdir($_GET['file']);
  die();
}

else {
  echo "<!DOCTYPE HTML><html><head><meta charset='UTF-8'><title>md $_GET[file]</title></head><body>\n";
  echo MarkdownExtra::defaultTransform(file_get_contents(__DIR__."/..$_GET[file]"));
  die();
}
