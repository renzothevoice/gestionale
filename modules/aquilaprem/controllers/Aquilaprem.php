<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* 2017 - Clienti.php - Classe Controller gestione Cliente Aquilaprem
*/
class Aquilaprem extends CI_Controller {
  // $data contiene variabili visualizzabili nel corpo della pagina
	protected $data = array();
	// $opzioni: parametri passati al render delle views
	protected $opzioni=array();

  function __construct() {
          parent::__construct();
					// Referenzio l'uso del mod_tasks
					$this->load->model('tasks/mod_tasks');
          $this->load->library('ion_auth');
          if($this->ion_auth->logged_in()===FALSE){
						// TODO: RIMPIAZZARE IL METODO LOGIN CON IL SEMPLICE INDEX
            redirect('accesso');
          } // fine if
  } // fine construct

/** Fake index **/
public function index(){
	redirect('aquilaprem/elenco');
} // fine index


/*
* Visualizzo la home page della dashboard. Sto lavorando con AQUILAPREM
*/
	public function elenco($filtro=""){
		// Predispongo un array con i parametri da passare al Model
		$parametri=array(
			'stato'=>'',
			'categoria' => '',
			'reparto'=>''
		);
		// Preparo una variabile per contenere i pulsanti, A: annulla+chiudi, B: chiudi
		$pulsanti="";
		// intercetto i parametri passati da $filtro
		switch ($filtro) {
			case 'A':
				// Visualizzo Tutti gli eventi ANNULATI
				$parametri['stato']="ANNULLATO";
				break;
			case 'C':
				// Visualizzo Tutti gli eventi ANNULATI
				$parametri['stato']="CHIUSO";
			break;
			default:
				// Visualizzo tutti glie eventi APERTI - forse scaduti
				$parametri['stato']="APERTO";
				$pulsanti="ciao";
			break;
		}

		// Etraggo tutti i tasks anche filtrati. Ovviamente uso il model TASKS
		$this->data['tasks']=$this->mod_tasks->elencaTasks($parametri);
		// Istanzio la vista, passando un array con le opzioni per il template
		$this->opzioni=array("datatables","fullcalendar");
		$this->codemakers->genera_vista_aqp('dashboard', $this->data, $this->opzioni);
	} // fine index

/*
* Funzione che estrae i tasks per fullcalendar
*/
	public function calendario(){
		// Preparo l'array da restituire Json
		$jsondata=array();
		// Recupero i parametri _POST
		$azione=$_POST['azione']; // default: elenca
		$stato=$_POST['stato']; // ANNULATO, CHIUSO, NULL
		// Preparo l'array per l'estrazione dei tasks
		$parametri=array(
      'stato' => $stato,
			'categoria' => '',
			'reparto'=>''
		);
		$this->data['tasks']=$this->mod_tasks->elencaTasks($parametri);
		/** TODO: creare trasposizione da task a fullcalendar **/
		/***** demo
		echo "START<br/>";
		foreach ($this->data['tasks'] as $righe => $value) {
			// Ciclo le righe contenenti i task
			echo "Debug: analizzo l'indice :".$righe."<br/>";
			foreach ($this->data['tasks'][$righe] as $indice => $valore) {
				echo "Debug: il valore di :".$indice." è :".$valore."<br/>";
				$jsondata[$righe][$indice]=$valore;
			}
			echo "<br/>";
		}
		echo "<br/>END<br/>";
		****** fine demo **/
		foreach ($this->data['tasks'] as $righe => $value) {
			$jsondata[$righe]['id']=$value['id_task'];
			$jsondata[$righe]['title']=$value['categoria'];
			$jsondata[$righe]['start']=$value['scadenza'];
			$jsondata[$righe]['color']=$value['colore'];
		}
		//print_r($jsondata);
		echo json_encode($jsondata);
		/*
		id=tasks.id_task
		title=categoria
		start=scadenza
		url=""
		tasks		*/
	} // fine elenco


/*
* Gestione assegnazione Categorie -> Utenti
*/
	public function gestioneUtenti(){
		// Istanzio Grocery Crud
		$crud = new grocery_CRUD();
		$crud->set_model('Mod_GCR');
		$crud->set_theme('bootstrap');
		$crud->set_language('italian');
		// Determino la tabella di riferimento
		//$crud->set_table('utenti');
		$crud->set_table('users');
		// Imposto la relazione n-n
		$crud->set_relation_n_n('elenco_categorie', 'utenti_categorie', 'tasks_categorie', 'id', 'id_categoria', 'categoria');
		$crud->unset_columns(array('ip', 'password','salt'));
		//$crud->unset_fields(array('id_cliente','username','last_login','ip_address', 'password','salt','activation_code','forgotten_password_code','forgotten_password_time','remember_code','created_on','phone'));
		$crud->fields(array('last_name','first_name','email','active','elenco_categorie'));
		$crud->columns(array('last_name','first_name','email','active','elenco_categorie'));
		$crud->display_as('first_name', 'Nome');
		$crud->display_as('last_name', 'Cognome');
		$crud->display_as('active', 'Abilitato');

		$crud->unset_delete();
		$crud->unset_bootstrap();
		$output = $crud->render();
		// Definisco le opzioni
		$opzioni=array();
		// Carico la vista
		$this->opzioni=array();
		$this->codemakers->genera_vista_aqp('crud',$output,$this->opzioni);
	} // fine gestioneUtenti

/*
* Gestione CRUD tasks
*/
	public function tasksCrud(){
		// Istanzio Grocery Crud
		$crud = new grocery_CRUD();
		$crud->set_model('Mod_GCR');
		$crud->set_theme('bootstrap');
		$crud->set_language('italian');
		$crud->set_table('tasks');
		// Imposto le relazioni con la tabella tasks_categorie
		$crud->set_relation('id_categoria','tasks_categorie','categoria');
		// Nascondo
		$crud->unset_columns(array('id_reparto'));
		$crud->unset_delete();
		$crud->unset_bootstrap();
		$output = $crud->render();

		// Definisco le opzioni
		$opzioni=array();
		// Carico la vista
		$this->opzioni=array("datatables","fullcalendar");
		$this->codemakers->genera_vista_aqp('crud',$output,$this->opzioni);
	} // fine tasksCrud


}
