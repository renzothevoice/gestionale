<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* Gestisce le informazioni relative alle Aziende */

class Aziende extends CI_Controller {
	// $footer contiene variabili visualizzabile nel piedone
	protected $footer = array();
  // $aiuto contiene variabili con testo di aiuto
	protected $aiuto = array();
  // $data contiene variabili visualizzabili nel corpo della pagina
	protected $data = array();
		function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        //$this->load->model('Mod_aziende');
    }


		/*** Gestione dati aziendali ***/
		public function index(){
  		$this->aiuto['aiuto_titolo']="TODO";
  		$this->aiuto['aiuto_msg']="Gestisce le informazioni di base di una azienda.";
  		// Istanzio Grocery Crud
  		$crud = new grocery_CRUD();
  		$crud->set_theme('bootstrap');
  		$crud->set_table('aziende');
			$crud->set_subject('Anagrafica Aziende');
			$crud->columns('rag_soc','citta','piva','pec', 'email','url_logo');
			$crud->display_as('rag_soc','Ragione Sociale');
			$crud->display_as('citta','Città');
			$crud->display_as('url_logo','Logo');
  		$crud->set_language('italian');
			$crud->set_field_upload('url_logo','assets/img/aziende');
			// Non posso cancellare una azienda
  		$crud->unset_add();
			// Non posso inserire una nuova azienda
  		$crud->unset_bootstrap();
  		$output = $crud->render();
  		// Istanzio la vista
  		$this->load->view("template/tpl_header");
  		$this->load->view("template/tpl_menu", $this->aiuto);
			$this->load->view('_menu_aziende');
  		$this->load->view('crud', $output);
  		$this->load->view("template/tpl_footer");
  		$this->load->view("template/tpl_end_page");
    } // fine index
}
