<?php
class MailCommand extends CConsoleCommand {
  public function run($args) {
    echo "Hello \n";
    $c =  file_get_contents('php://stdin');
    Mailer::sendHtml('kefah.issa@freesoft.jo', 'Kefah Issa', 'kefah@choozon.net', 'Hello there', $c, 'kefah@choozon.net');

  }
}

