<?php
$unzip = new ZipArchive;
$out = $unzip->open('stripe.zip');

if ($out === TRUE) {
  $unzip->extractTo(getcwd());
  $unzip->close();
  echo 'File unzipped';
} else {
  echo 'Something went wrong?';
}

?>