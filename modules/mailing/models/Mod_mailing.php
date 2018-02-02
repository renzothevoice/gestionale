<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_mailing extends CI_Model {

  var $bar = array();
/** Funzione che elabora tutti i task aperti **/
  function elabora($tasks){
    // istanzio una variabile contenente la data odierna
    $adesso=new DateTime("now");
    $i=0;
    /*
    Analisi situazione a x mesi/giorni
      1- controllo esistenza file log -5 x +5
      2- invio email
      3- scrivo log
    */
    // Inizio ciclo per ogni task
    foreach ($tasks as $row) {
      $scadenza = new DateTime($row['scadenza']);
      $interval = $adesso->diff($scadenza, FALSE);
      $tasks[$i]["giorni_mancanti"]=(int)$interval->format("%r%a");
      $giorni_mancanti=$tasks[$i]["giorni_mancanti"];
      // Ora so quanto manca alla scadenza.. posso decidere di fare qualcosa
      switch ($giorni_mancanti) {
        case ($giorni_mancanti < 0):
          $tasks[$i]["azione"]="**SCADUTO**";
          // Invio email
          // Registro Log
        break;

        case ($giorni_mancanti <= 1):
          //$bar["uno"]="MeNo di UnO.";
          $tasks[$i]["azione"]="Manca meno di un giorno";
          //$bar["email1"]=$tasks[$i]["email1"];
          // Invio email
          //$tasks[$i]=$this->invioMail($foo,1);
          //$foo=$tasks[$i];
          //array_replace($tasks[$i],$this->invioMail($tasks[$i],1));
          //$this->invioMail($bar,1);
          $this->invioMail($tasks[$i],1);
          //$tasks[$i]["azione"]=$bar["email1"];
          // Registro Log
        break;

        case ($giorni_mancanti <= 7):
          $tasks[$i]["azione"]="meno di sette";
        break;

        case ($giorni_mancanti <= 15):
          $tasks[$i]["azione"]="meno di quindici";
          $this->invioMail($tasks[$i],1);
        break;

        case ($giorni_mancanti <= 20):
          $tasks[$i]["azione"]="meno di venti";
        break;

        case ($giorni_mancanti <= 90):
          $tasks[$i]["azione"]="meno di 90";
        break;

        case ($giorni_mancanti <= 180):
          $tasks[$i]["azione"]="meno di 180";
        break;

        default:
          $tasks[$i]["azione"]="DEFAULT oltre sedici";
        break;
      } // fine switch
      $i++;
    } // fine foreach
    return $tasks;
  } // fine elabora

  function invioMail($task, $giorni){
    // TODO: controllo se non sono state già inviate email con lo stesso id_task negli ultimi x giorni
    $parametri=array(
						'email' => 'backoffice@aquilaprem.it',
						'pw_email' => 'Aquilaprem17',
						'smtp_server' => 'smtps.aruba.it',
						'smtp_porta' => '465',
						'indirizzo1' => $task["email1"],//.", ".$bar["email2"],
            'indirizzo2' => $task["email2"]
					);
    // Compongo il testo della mail
    $corpo="ATTENZIONE! ".$task["categoria"]."<br/>Mancano <b>".$task["giorni_mancanti"]." giorni </b> alla scadenza di ";
    $corpo.="<em>".$task["descrizione"]."</em>. L'evento scadrà il ".strftime("%d/%m/%Y", strtotime($task["scadenza"]));
    $corpo.="<hr/>";
    $corpo.="<small>Entra nella piattaforma e modifica lo stato di questo evento per non ricevere più notifiche.</small>";
    $corpo.="<br/>";
    $corpo.="<small>&copy; 2017 Tessitore Informatica</small>";
    // Preparo il necessario per attivare Swift_Mailer
    $message = Swift_Message::newInstance('-f %s')
			->setSubject('REMINDER: '.$task["categoria"].' -'.$giorni.' giorni alla scadenza.')
			->setFrom(array('backoffice@aquilaprem.it' => 'BackOffice Aquilaprem'))
			->setTo(array($parametri['indirizzo1'] => $parametri['indirizzo1'],$parametri['indirizzo2'] => $parametri['indirizzo2']))
			->setBcc(array('luigitessitore@gmail.com' => 'Tessitore'))
			//->setBody('<b><em>ATTENZIONE!</em></b><br/><br/>Programma di invio reminder automatizzato. Non rispondere a questa email.<br/>In caso di comunicazioni, inviare un messaggio a: luigi@ oppure telefonare al xx', 'text/html');
			//->attach($attachment);
      ->setBody($corpo, 'text/html');
    // Parametri SMTP server Aruba - SSL
    $transport = Swift_SmtpTransport::newInstance($parametri['smtp_server'], $parametri['smtp_porta'], 'ssl');
    $transport->setUsername($parametri['email']);
    $transport->setPassword($parametri['pw_email']);
    // Creo l'oggetto Mailer usando il servizio di trasporto definito prima
    $mailer = Swift_Mailer::newInstance($transport);
    // Invio il messaggio generato
		$mailer->send($message);
    //echo "<h1>DEBUG: ".print_r($task)."</h1>";
    // Se esiste, invio email all'email 1
    // Se esiste, invio email all'email 2
    // Scrivo nel log l'avvenuto invio
  }
} // fine Mod_mailing
