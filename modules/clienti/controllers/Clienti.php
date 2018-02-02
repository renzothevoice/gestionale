<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* 2017 - Clienti.php - Classe Controller gestione Clienti Generici
*/
class Clienti extends CI_Controller {
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
* Visualizzo la dashboard relativa ai clienti
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
			$crud->columns('nome','cognome','rag_soc','citta','piva','pec', 'email');
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

		/*
		* Visualizzo l'elenco delle workstation possedute dai clienti
		*/
		  public function ws(){
	  		// Istanzio Grocery Crud
	  		$crud = new grocery_CRUD();
	  		$crud->set_theme('bootstrap');
	  		$crud->set_table('cli_workstation');
				$crud->set_subject('PC e Workstation Clienti');
				$crud->columns('id_cliente','reparto','nome_pc','tipo','marca_modello','ip');
				$crud->display_as('id_cliente','Nome/Ragione Sociale');
				//$crud->display_as('citta','Città');
				$crud->set_relation('id_cliente','clienti','rag_soc');
	  		$crud->set_language('italian');
				// Non posso cancellare un Cliente
	  		//$crud->unset_delete();
	  		$crud->unset_bootstrap();
	  		$this->data = $crud->render();
				// Genero la view
				$this->codemakers->genera_vista_admin('crud', $this->data, $this->opzioni);
			}
			/*
			* Visualizzo l'elenco delle stampanti possedute dai clienti
			*/
			  public function prn(){
		  		// Istanzio Grocery Crud
		  		$crud = new grocery_CRUD();
		  		$crud->set_theme('bootstrap');
		  		$crud->set_table('cli_stampanti');
					$crud->set_subject('Stampanti e Plotter Clienti');
					//$crud->columns('id_cliente','reparto','nome_pc','tipo','marca_modello','ip');
					$crud->display_as('id_cliente','Nome/Ragione Sociale');
					//$crud->display_as('citta','Città');
					$crud->set_relation('id_cliente','clienti','rag_soc');
		  		$crud->set_language('italian');
					// Non posso cancellare un Cliente
		  		//$crud->unset_delete();
		  		$crud->unset_bootstrap();
		  		$this->data = $crud->render();
					// Genero la view
					$this->codemakers->genera_vista_admin('crud', $this->data, $this->opzioni);
				}
				/*
				* Visualizzo l'elenco dei dispositivi mobile e smartphone possedute dai clienti
				*/
				  public function mobile(){
			  		// Istanzio Grocery Crud
			  		$crud = new grocery_CRUD();
			  		$crud->set_theme('bootstrap');
			  		$crud->set_table('cli_mobile');
						$crud->set_subject('Smartphone e Tablet Clienti');
						//$crud->columns('id_cliente','reparto','nome_pc','tipo','marca_modello','ip');
						$crud->display_as('id_cliente','Nome/Ragione Sociale');
						//$crud->display_as('citta','Città');
						$crud->set_relation('id_cliente','clienti','rag_soc');
			  		$crud->set_language('italian');
						// Non posso cancellare un Cliente
			  		//$crud->unset_delete();
			  		$crud->unset_bootstrap();
			  		$this->data = $crud->render();
						// Genero la view
						$this->codemakers->genera_vista_admin('crud', $this->data, $this->opzioni);
					}

} //Fine controller Clienti
