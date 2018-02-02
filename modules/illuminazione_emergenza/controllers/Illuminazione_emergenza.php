<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* 2018 - Illuminazione_emergenza.php - Classe Controller gestione Impianti Illuminazione Emergenza
*/
class Illuminazione_emergenza extends CI_Controller {
  // $data contiene variabili visualizzabili nel corpo della pagina
	protected $data = array();
	protected $opzioni = array();
  function __construct() {
          parent::__construct();
          if($this->ion_auth->logged_in()===FALSE){
						// TODO: RIMPIAZZARE IL METODO LOGIN CON IL SEMPLICE INDEX
            redirect('accesso/login');
          } // fine if
  } // fine construct


/*
* Visualizzo la dashboard relativa al materiale hardware in possesso ai clienti
*/
  public function index(){
		$opzioni=array("datatables");
		$this->codemakers->genera_vista_admin('dashboard', $this->data, $opzioni);
	}

	/*
	* Visualizzo la dashboard relativa ai clienti
	*/
	  public function elenco(){
  		// Istanzio Grocery Crud
  		$crud = new grocery_CRUD();
  		$crud->set_theme('bootstrap');
  		$crud->set_table('clienti');
			$crud->set_subject('Anagrafica Clienti');
			$crud->columns('rag_soc','citta','piva','pec', 'email');
			$crud->display_as('rag_soc','Ragione Sociale');
			$crud->display_as('citta','Città');
  		$crud->set_language('italian');
			// Non posso cancellare un Cliente
  		$crud->unset_delete();
  		$crud->unset_bootstrap();
  		$this->data = $crud->render();
			// Genero la view
			$this->codemakers->genera_vista_admin('crud', $this->data, $this->opzioni);
		}


} //Fine controller Clienti
