<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {
	// $data contiene variabili visualizzabile nelle view
	protected $data = array();
		function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model('Mod_tasks');
				if($this->ion_auth->logged_in()===FALSE){
					// TODO: is admin???
					redirect('accesso');
				} // fine if
				// Mi assicuro che sia caricato il componente swiftmailer
				require_once APPPATH.'../vendor/autoload.php';
    }

		/** Creo un nuovo TASK **/
		public function nuovo(){
			$this->load->library('form_validation');
			$data=array();
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('data_scadenza', 'Data scadenza', 'required');
			$this->form_validation->set_rules('descrizione', 'Descizione', 'required');
			if ($this->form_validation->run() == FALSE){
				// Recupero i dati relativi alla select Categoria
				$data['categorie']=$this->Mod_tasks->selectCategorie();
				$this->codemakers->genera_vista_aqp('crea',$data);
			}else{
				/** TODO: Recupero i dati e li inserisco nel DB **/
				$this->Mod_tasks->creaTask();
				/** TODO: ritorno nella schermata con le scadenze **/
				//$this->load->view('formsuccess');
				redirect();
			}
		} // fine nuovo
/*
* Funzione che provvede a modificare un task
*/
		public function modifica($id=""){
			if (empty($id)){
				show_404();
			}
			// Istanzio l'array che fungerà da contenitore
			$data=array();
			// Carico library form validation
			$this->load->library('form_validation');
			// Preparo l'array per le regole di validazione
			//set form validation rules
			$regole = array();
			$regole['descrizione'] = array(
				'field' => 'descrizione',
				'label' => 'Descrizione',
				'rules' => 'trim|required'
			);
			$this->form_validation->set_rules($regole);
			// Eseguo la validazione dei campi
			if ($this->form_validation->run() == FALSE){
				$data['messaggio_errore'] = validation_errors();
			}else{
				// procedo con la modifica - Update; return $success
				$success=$this->Mod_tasks->aggiornaTask($id);
				if ($success){
					// Genero un message flashdata
					//$this->session_set_flashdata('success_message', MESSAGE_HERE);
				}
				// Reindirizzo verso una pagina chi successo
				redirect('aquilaprem/elenco');
			}
			// Preparo l'array per la creaizone della vista
			$opzioni=array("datatables");
			// Recupero dati per riempire il form
			$data['task']=$this->Mod_tasks->vediTask($id);
			// Recupero i dati relativi alla select Categoria
			$data['categorie']=$this->Mod_tasks->selectCategorie();
			// Genero la vista
			$this->codemakers->genera_vista_aqp('modifica',$data ,$opzioni);
	}// fine modifica

		/* **** Tasks Index: Elenco Task con evidenza su scadenza ***/
		public function index(){
			$opzioni=array("datatables","fullcalendar");
			$this->codemakers->genera_vista('index','',$opzioni);
		}


		/* ****  Elenco Task e gestione CRUD ***/
		public function lista(){
  		// Istanzio Grocery Crud
  		$crud = new grocery_CRUD();
			$crud->set_model('Mod_GCR');
  		$crud->set_theme('bootstrap');
  		$crud->set_table('tasks');
  		$crud->set_language('italian');
			$crud->columns('id_categoria','scadenza','descrizione','note','stato');
			$crud->fields('id_categoria','scadenza','descrizione','note','stato');
			$crud->set_relation('id_categoria','tasks_categorie','categoria');
			$crud->display_as('id_categoria','Categoria');
			//$crud->callback_column('id_categoria',array($this,'_callback_email'));
			if(!$this->ion_auth->is_admin()===TRUE){
				/* UTENTE NON AMMINISTRATORE */
				// Vedo solo i miei task, non li posso cancellare
	  		$crud->unset_delete();
				$crud->where('id_reparto','0');
			}
  		$crud->unset_bootstrap();
  		$output = $crud->render();
  		// Istanzio la vista
			$this->codemakers->genera_vista_aqp('crud',$output,'');
    } // fine index

		/* ****  Elenco Task e gestione CRUD ***/
		public function categorie(){
  		// Istanzio Grocery Crud
  		$crud = new grocery_CRUD();
			$crud->set_model('Mod_GCR');
  		$crud->set_theme('bootstrap');
  		$crud->set_table('tasks_categorie');
  		$crud->set_language('italian');
			// Imposto una callback per il colorpicker
			$crud->callback_edit_field('colore',array($this,'edit_field_callback_colore'));
			$crud->callback_add_field('colore', function () {
				return '<input type="text" maxlength="50" value="" name="colore" id="field-colore" class="jscolor">';
			});
			$crud->unset_delete();
  		$crud->unset_bootstrap();
  		$output = $crud->render();
			// Definisco le opzioni
			$opzioni=array(
				"colorpicker"
			);
  		// Istanzio la vista
			$this->codemakers->genera_vista_aqp('crud', $output, $opzioni);
    } // fine index

		function edit_field_callback_colore($value, $primary_key){
		return '<input type="text" maxlength="50" value="'.$value.'" name="colore" class="jscolor" id="field-colore" style="width:462px">';
	}// fine function

/** DEBUG ** DEBUG** DEBUG */
public function debug(){
	echo "DEBUG: <br/>";
		print_r($this->Mod_tasks->categorieAbilitate());
	//echo $this->Mod_tasks->categorieAbilitate();
}


/** Gestione Reminder: funziona chiamata da CLI mediante CRON JOB **/
	function reminder(){
		// Istanzio i parametri da passare al model
		$parametri=array(
			'stato'=>'APERTO',
			'categoria' => '',
			'reparto'=>''
		);
		// Istanzio una variabile array che conterrà i task estratti
		$tasks=array();
		// Etraggo tutti i tasks anche filtrati. Uso il model TASKS
		$tasks=$this->mod_tasks->elencaTasks($parametri);
		// chiamo la function
		$risultato=$this->mod_tasks->reminder($tasks);
		//$this->data['tasks']=$this->mod_mailing->elabora($tasks);
		// Istanzio la vista, passando un array con le opzioni per il template

		$this->opzioni=array("datatables");
		$this->codemakers->genera_vista_aqp('debug', $risultato, $this->opzioni);

		//redirect('/');
	}// fine reminder

}
