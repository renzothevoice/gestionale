<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* 2017 - Amministratore.php - Classe Controller gestione Amministratore
* Dashboard Amministratore
*/
class Amministratore extends CI_Controller {
  // $data contiene variabili visualizzabili nel corpo della pagina
	protected $data = array();
  function __construct() {
          parent::__construct();
          if($this->ion_auth->logged_in()===FALSE){
						// TODO: is admin???
            redirect('accesso');
          } // fine if
} // fine construct


/*
* Visualizzo la home page della dashboard Amministratore
*/
  public function index(){
		$this->load->model('mod_amministratore');
		// Etraggo tutti i ToDo [più giovani di 6 mesi && con stato CHIUSO]
		$this->data['todo']=$this->mod_amministratore->estrai_todo();
		/** Istanzio la vista **/
		$opzioni=array("datatables","fullcalendar");
		$this->codemakers->genera_vista_admin('dashboard', $this->data, $opzioni);
  } // fine index

/***
	dashboard cliente
**/
public function cliente($id_cliente=0){
	if($id_cliente==0){
		redirect(dashboard);
	}
	$this->load->model('mod_clienti');
	$this->load->model('fatture/mod_fatture');

	/** Estraggo i dati del cliente **/
	$this->data['cliente']=$this->mod_clienti->dati_cliente($id_cliente);

	/** Fatture Emesse Anno contabile corrente **/
	$this->data['fatture']=$this->mod_fatture->estraiFatture($id_cliente);

	/** Saldo Insoluti dell'intera Azienda **/
	$this->data['saldo_insoluti'] = $this->mod_fatture->saldoInsoluti($id_cliente);
	$this->data['totale_fatture_emesse']=$this->mod_fatture->totaleFattureInsolute($id_cliente);
	$this->data['numero_fatture_insolute']=$this->mod_fatture->numeroFattureInsolute($id_cliente);

	/** Istanzio la vista **/
	$this->aiuto['aiuto_titolo']="CLIENTI";
	$this->aiuto['aiuto_msg']="Report della situazione del cliente selezionato.";
	$this->load->view("template/tpl_header");
	$this->load->view("template/tpl_header_datatables");
	$this->load->view("jsh_clienti_view");
	$this->load->view("template/tpl_menu", $this->aiuto);
	$this->load->view("_menu_clienti");
	$this->load->view('report_cliente', $this->data);
	$this->load->view("template/tpl_footer");
	$this->load->view("template/tpl_end_page");
} // fine cliente

private function _genera_view($pagina, $output, $opzioni=0){
	/*
	* Istanzio una vista in base al tipo di accesso e carico JS,CSS necessari
	*/
	$this->load->view("header");
	// Controllo  se devo caricare il necessario per far funzionare datatables
	if (in_array("datatables", $opzioni)) {
		$this->load->view("template/tpl_header_datatables");
	}
	// Controllo  se devo caricare il necessario per far funzionare fullcalendar
	if (in_array("fullcalendar", $opzioni)) {
		$this->load->view("template/tpl_header_fullcalendar");
	}
	// Carico eventuale codice JS da incluedere nell'header
	$this->load->view('jsh_'.$pagina);

	// Seleziono in menu in funzione del livello di accesso
	if($this->ion_auth->is_admin()===TRUE){
		$this->load->view("amministratore/menu");
	}else{
		$this->load->view("cliente/menu");
	}

	// Carico il sottomenu menu che deve essere presente per ogni view
	$this->load->view($pagina.'_menu');

	$this->load->view($pagina, $output);
	$this->load->view("footer");
	$this->load->view("end_page");
}


/** Full calendar **/
public function eventi_cliente(){

	$eventi_json=array();
	$this->load->model('mod_eventi');
	$eventi=$this->mod_eventi->eventi_cliente('1');
	foreach ($eventi as $key) {
		# code...
		$row = array();
		$row['start'] = $key->inizio;
		$row['end'] = $key->fine;
		$row['title'] = $key->descrizione;
		$row['color'] = $key->colore;
		array_push($eventi_json, $row);
	}
	echo json_encode($eventi_json);
}




/******** DEBUG *************/





}// fine classe
