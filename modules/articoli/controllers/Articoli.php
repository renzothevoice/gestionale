<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* 2018 - Articoli.php - Classe Controller gestione Articoli e Prestazioni
*/
class Articoli extends CI_Controller {
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
* Visualizzo la dashboard relativa agli articoli
*/
  public function index(){
		$opzioni=array("datatables");
		$this->codemakers->genera_vista_admin('dashboard', $this->data, $opzioni);
	}

	/*
	* Visualizzo la dashboard relativa agli articoli
	*/
	  public function elenco(){
  		// Istanzio Grocery Crud
  		$crud = new grocery_CRUD();
  		$crud->set_theme('bootstrap');
  		$crud->set_table('articoli');
			$crud->set_subject('Anagrafica Articoli');
			//$crud->columns('rag_soc','citta','piva','pec', 'email');
			$crud->display_as('marca_modello','Marca/Modello');
			$crud->display_as('costo_medio','Costo Medio IE');
			$crud->display_as('prezzo_medio','Prezzo Medio IE');
  		$crud->set_language('italian');
			// Non posso cancellare un Artiolo
  		$crud->unset_delete();
  		$crud->unset_bootstrap();
  		$this->data = $crud->render();
			// Genero la view
			$this->codemakers->genera_vista_admin('crud', $this->data, $this->opzioni);
		}


} //Fine controller Clienti
