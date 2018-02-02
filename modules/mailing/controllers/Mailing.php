<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mailing extends CI_Controller {
	// $data contiene variabili visualizzabile nelle view
	protected $data = array();
		function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model('mod_mailing');
				$this->load->model('tasks/mod_tasks');
				if($this->ion_auth->logged_in()===FALSE){
					// TODO: is admin???
					redirect('accesso');
				} // fine if
				// Mi assicuro che sia caricato il componente swiftmailer
				require_once APPPATH.'../vendor/autoload.php';
    }

/** Funzione che invia le email secondo una pianificazione nota **/
	public function index(){

		/*
		Analisi situazione a x mesi/giorni
			1- controllo esistenza file log -5 x +5
			2- invio email
			3- scrivo log
		*/

		// Istanzio i parametri da passare al model
		$parametri=array(
			'stato'=>'APERTO',
			'categoria' => '',
			'reparto'=>''
		);
		$tasks=array();
		// Etraggo tutti i tasks anche filtrati. Uso il model TASKS
		$tasks=$this->mod_tasks->elencaTasks($parametri);
		// chiamo la function
		$this->data['tasks']=$this->mod_mailing->elabora($tasks);
		// Istanzio la vista, passando un array con le opzioni per il template
		$this->opzioni=array("datatables");
		$this->codemakers->genera_vista_aqp('index', $this->data, $this->opzioni);

	} // fine index
} // fine class
