<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends CI_Controller {
	// $data contiene variabili visualizzabile nelle view
	protected $data = array();
		function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model('Mod_todo');
				if($this->ion_auth->logged_in()===FALSE){
					// TODO: is admin???
					redirect('accesso');
				} // fine if
    }




		/* **** ToDO Index: Elenco e gestione CRUD ***/
		public function index(){
  		// Istanzio Grocery Crud
  		$crud = new grocery_CRUD();
			$crud->set_model('Mod_GCR');
  		$crud->set_theme('bootstrap');
  		$crud->set_table('todo');
  		$crud->set_language('italian');
			$crud->columns('id_cliente','data_apertura','data_chiusura','descrizione', 'urgenza','stato');
			//$crud->callback_column('data_chiusura',array($this,'_callback_stato'));
			$crud->display_as('data_apertura','Aperto');
			$crud->display_as('data_chiusura','Chiuso');
			$crud->set_relation('id_cliente','clienti','rag_soc');
			$crud->display_as('id_cliente','Cliente');
			if(!$this->ion_auth->is_admin()===TRUE){
				/* CLIENTE OCCASIONALE */
				// Vedo solo i miei task, non li posso cancellare
	  		$crud->unset_delete();
				$crud->where('id_cliente','2');

				//$crud->set_rules('quantityInStock','Quantity In Stock','integer');
				//$crud->required_fields('field_name_1','field_name_2','field_name_3');
				//$crud->unset_texteditor('field_name_1','field_name_2','field_name_3');

			}else{

			}

  		$crud->unset_bootstrap();
  		$output = $crud->render();
  		// Istanzio la vista
			$this->_genera_view('crud', $output);
    } // fine index

		private function _stato($value, $row){
			if($value)
			return "<a href='".site_url('admin/sub_webpages/'.$row->id)."'>$value</a>";
		}

		private function _genera_view($pagina, $output){
			/* Istanzio una vista in base al tipo di accesso */
			$this->load->view("header");
			if($this->ion_auth->is_admin()===TRUE){
				$this->load->view("amministratore/menu");
			}else{
				$this->load->view("cliente/menu");
			}
			$this->load->view($pagina, $output);
			$this->load->view("footer");
			$this->load->view("end_page");
		}
}
