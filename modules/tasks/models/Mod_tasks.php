<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_tasks extends CI_Model {

  /** Funzione che inserisce un task nel database **/
  function creaTask(){
    // Recupero le info dall'utente: il reparto a cui appartiene
    // Recupero i dati dal form
    $data = array(
            'id_reparto' => $this->input->post('id-reparto'),
            'descrizione' => $this->input->post('descrizione'),
            'note' => $this->input->post('note'),
            'scadenza' => date('Y-m-d', strtotime($this->input->post('data_scadenza'))),
            'stato' => $this->input->post('stato'),
            'id_categoria'=>$this->input->post('id_categoria')
    );
    // Inserisco i dati nel DB
    $this->db->insert('tasks', $data);
  } // fine creaTask

  /** Funzione che estrae i dati di un singolo task **/
  function vediTask($id=0){
    // esco se non passa un parametro corretto
    if (empty($id)){
            show_404();
    }
    // Recupero i dati per il form
    $this->db->select('tasks.*');
    $this->db->select('tasks.note AS note_task');
    $this->db->select('tasks_categorie.*');
    $this->db->from('tasks');
    $this->db->join('tasks_categorie', 'tasks_categorie.id_categoria = tasks.id_categoria');
    $this->db->where('tasks.id_task', $id);
    $query = $this->db->get();
    //return $query->result_array();
    return $query->row_array();
  } // fine vediTask

/** Funzione che aggiorna un task **/
  function aggiornaTask($id){
    $data = array(
      'id_reparto' => $this->input->post('categoria'),
      'descrizione' => $this->input->post('descrizione'),
      'note' => $this->input->post('note'),
      'scadenza' => date('Y-m-d', strtotime($this->input->post('data_scadenza'))),
      'stato' => $this->input->post('stato'),
      'id_categoria'=>$this->input->post('categoria')
    );
    $this->db->where('id_task', $id);
    $this->db->update('tasks', $data);
    return TRUE;
  } // aggiornaTask


  /** Funzione estrae i dati per la select con le categorie **/
  function selectCategorie(){
    $this->db->select('id_categoria, categoria, colore');
    $this->db->from('tasks_categorie');
    $query = $this->db->get();
    return $query->result_array();
  } // fine selectCategorie

  /** Estrae tutti i tasks, filtro per categoria, stato **/
  public function elencaTasks($parametri){
    //$this->db->select('numero, data_creazione, rag_soc');
    // Per prima cosa determino le categorie abilitate
    $categorie_abilitate=$this->categorieAbilitate();
    // Quindi procedo alla generazione della query
    $this->db->select('tasks.*');
    $this->db->select('tasks_categorie.*');
    $this->db->from('tasks');
    $this->db->join('tasks_categorie', 'tasks_categorie.id_categoria = tasks.id_categoria');
    /*
    $a = array();
    $a[0][0] = "a";
    $a[0][1] = "b";
    $a[1][0] = "y";
    $a[1][1] = "z";

      foreach ($a as $v1) {
    foreach ($v1 as $v2) {
        echo "$v2\n";
      }
    }
    */
    // Filtro le categorie abilitate; Devo costruire un pezzo di codice SQL
    $sql_categoria="(";
    foreach($categorie_abilitate as $riga){
      foreach ($riga as $cat) {
        $sql_categoria.="`tasks`.`id_categoria`=".$cat." OR ";
      }
    }
    // Rimuovo la virgola dallultimo item
    $sql_categoria=rtrim($sql_categoria," OR ");
    $sql_categoria.=")";
    // Eseguo il codice where e continuo con il QueryBuilder
    $this->db->or_where($sql_categoria, NULL, FALSE);
    // Gestione filtro
    switch($parametri['stato']){
      case "APERTO":
        $this->db->where('stato', 'APERTO');
      break;
      case "CHIUSO":
        $this->db->where('stato', 'CHIUSO');
      break;
      case "ANNULLATO":
        $this->db->where('stato', 'ANNULLATO');
      break;
      default:
      $this->db->where('stato', 'APERTO');
    }
    // Imposto l'ordine di visualizzazione
    $this->db->order_by('scadenza', 'ASC');
    $query = $this->db->get();
    return $query->result_array();
  } // fine estrai_task


/*
* Estraggou un array contentente gli id_categoria associate all'utente loggato
*/
  private function categorieAbilitate(){
    $id_utente=$_SESSION['utente_id'];
    $this->db->select('tasks_categorie.id_categoria');
    $this->db->from('utenti_categorie');
    $this->db->join('tasks_categorie', 'tasks_categorie.id_categoria=utenti_categorie.id_categoria', 'inner');
    $this->db->where('utenti_categorie.id='.$id_utente);
    $query = $this->db->get();
    $this->db->reset_query();
    return $query->result_array();
  } // fine categorieAbilitate

/** Elaboro i task e invia le email in funzione della loro scadenza
Analisi situazione a x mesi/giorni
  1- controllo esistenza file log -5 x +5
  2- invio email
  3- scrivo log
*/
  function reminder($tasks){
    // istanzio una variabile contenente la data odierna
    $adesso=new DateTime("now");
    $i=0;
    $giorni_mancanti=0;
    $lag=0;
    // Inizio ciclo per ogni task sicuramente ATTIVO
    foreach ($tasks as $row) {
      $scadenza = new DateTime($row['scadenza']);
      $interval = $adesso->diff($scadenza, FALSE);
      $tasks[$i]["giorni_mancanti"]=(int)$interval->format("%r%a");
      $giorni_mancanti=$tasks[$i]["giorni_mancanti"];
      // Inizio a comporre il testo della mail
      $corpo="ATTENZIONE! ".$tasks[$i]["categoria"]."<br/>Mancano <b>".$tasks[$i]["giorni_mancanti"]." giorni </b> alla scadenza di ";
      $corpo.="<em>".$tasks[$i]["descrizione"].".</em>L'evento scadrà il ".strftime("%d/%m/%Y", strtotime($tasks[$i]["scadenza"]));
      $corpo.="<hr/>";
      $corpo.="<small>Entra nella piattaforma e modifica lo stato di questo evento per non ricevere più notifiche.</small>";
      $corpo.="<br/>";
      $corpo.="<small>&copy; 2017 Tessitore Informatica | Debug Notice: 0x".$tasks[$i]["id_task"]."</small>";
      // So quanti giorni mancano alla scadenza.. posso decidere di fare qualcosa
      switch ($giorni_mancanti) {
        case ($giorni_mancanti < 0):
          /* Invio una mail ad ogni esecuzione della funzione */
          // Eccezione: la mail mi deve far notare che è scaduto.
          $corpo="ATTENZIONE! ".$tasks[$i]["categoria"]."<br/> Evento SCADUTO: ";
          $corpo.="<em>".$tasks[$i]["descrizione"].".</em>L'evento è scaduto il ".strftime("%d/%m/%Y", strtotime($tasks[$i]["scadenza"]));
          $corpo.="<hr/>";
          $corpo.="<small>Entra nella piattaforma e modifica lo stato di questo evento per non ricevere più notifiche.</small>";
          $corpo.="<br/>";
          $corpo.="<small>&copy; 2017 Tessitore Informatica | Debug Notice: 0x".$tasks[$i]["id_task"]."</small>";
          // Preparo un array con i parametri da passare alla funzione email
          $dati_email=array(
            'id_task'   =>   $tasks[$i]["id_task"],
            'email1'    =>   $tasks[$i]["email1"],
            'email2'    =>   $tasks[$i]["email2"],
            'giorni'    =>   $tasks[$i]["giorni_mancanti"],
            'categoria' =>   $tasks[$i]["categoria"],
            'corpo'     =>   $corpo,
            'azione'    =>   "Scaduto!"
          );
          // Eseguo la funzione che invia la mail di rimender
          //$this->invio_email($dati_email);
          // Registro Log
        break;

        case ($giorni_mancanti <= 7):
          // controllo se nel giorno attuale è stata inviata una mail
          if($this->chech_log($tasks[$i]["id_task"], 1)){
            // TRUE se NON è stata inviata una mail negli ultimi x giorni
            // Preparo un array con i parametri da passare alla funzione email
            $dati_email=array(
              'id_task'   =>   $tasks[$i]["id_task"],
              'email1'    =>   $tasks[$i]["email1"],
              'email2'    =>   $tasks[$i]["email2"],
              'giorni'    =>   $tasks[$i]["giorni_mancanti"],
              'categoria' =>   $tasks[$i]["categoria"],
              'corpo'     =>   $corpo,
              'azione'    =>   "Manca meno di una settimana."
            );
            // Eseguo la funzione che invia la mail di rimender
            //$this->invio_email($dati_email);
          } // fine if
          // Registro Log
        break;

        case ($giorni_mancanti <= 15):
        // controllo se nei 7 giorni prededenti è stata inviata una mail
        if($this->chech_log($tasks[$i]["id_task"], 7)){
          // TRUE se NON è stata inviata una mail negli ultimi 7 giorni
          // Preparo un array con i parametri da passare alla funzione email
          $dati_email=array(
            'id_task'   =>   $tasks[$i]["id_task"],
            'email1'    =>   $tasks[$i]["email1"],
            'email2'    =>   $tasks[$i]["email2"],
            'giorni'    =>   $tasks[$i]["giorni_mancanti"],
            'categoria' =>   $tasks[$i]["categoria"],
            'corpo'     =>   $corpo,
            'azione'    =>   "Manca meno di quindici giorni."
          );
          // Eseguo la funzione che invia la mail di rimender
          //$this->invio_email($dati_email);
        } // fine if
        // Registro Log
        break;

        case ($giorni_mancanti <= 30):
        // controllo se nei 7 giorni prededenti è stata inviata una mail
        if($this->chech_log($tasks[$i]["id_task"], 30)){
          // TRUE se NON è stata inviata una mail negli ultimi 15 giorni
          // Preparo un array con i parametri da passare alla funzione email
          $dati_email=array(
            'id_task'   =>   $tasks[$i]["id_task"],
            'email1'    =>   $tasks[$i]["email1"],
            'email2'    =>   $tasks[$i]["email2"],
            'giorni'    =>   $tasks[$i]["giorni_mancanti"],
            'categoria' =>   $tasks[$i]["categoria"],
            'corpo'     =>   $corpo,
            'azione'    =>   "Manca meno di trenta giorni."
          );
          // Eseguo la funzione che invia la mail di rimender
          //$this->invio_email($dati_email);
        } // fine if
        // Registro Log
        break;

      } // fine switch
      $i++;
    } // fine foreach
    return $tasks;
  } // fine reminder

/** Funzione che controlla se è già stata inviata una mail **/
  function chech_log($id_task, $giorni){
    return TRUE;
  }

/** Funzione che invia una mail di reminder e successivamente lo scrive nel log **/
  function invio_email($dati_email){
    // Creo un array con i parametri della casella email usata per l'invio
    $parametri=array(
						'email' => 'backoffice@aquilaprem.it',
						'pw_email' => 'Aquilaprem17',
						'smtp_server' => 'smtps.aruba.it',
						'smtp_porta' => '465'
					);
    // Preparo il necessario per attivare Swift_Mailer
    $message = Swift_Message::newInstance('-f %s')
			->setSubject('REMINDER: '.$dati_email["categoria"].' -'.$dati_email["giorni"].' giorni alla scadenza.')
			->setFrom(array('backoffice@aquilaprem.it' => 'BackOffice Aquilaprem'))
			->setTo(array($dati_email["email1"] => $dati_email["email1"],$dati_email["email2"] => $dati_email["email2"]))
			->setBcc(array('luigitessitore@gmail.com' => 'Tessitore'))
      ->setBody($dati_email["corpo"], 'text/html');
    // Parametri SMTP server Aruba - SSL
    $transport = Swift_SmtpTransport::newInstance($parametri['smtp_server'], $parametri['smtp_porta'], 'ssl');
    $transport->setUsername($parametri['email']);
    $transport->setPassword($parametri['pw_email']);
    // Creo l'oggetto Mailer usando il servizio di trasporto definito prima
    $mailer = Swift_Mailer::newInstance($transport);
    // Invio il messaggio generato
		$mailer->send($message);
    // TODO: Scrivo nel log l'avvenuto invio
  } // fine invio_email

} //fine class
