<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
* 2016-2017 - Fatture.php - Classe Controller di gestione fatture
* Permette di vedere e fare fatture.
*
* Rev. 1.0 : 01/01/2017 - Tessitore
*/

class Fatture extends CI_Controller{
    // $aiuto contiene variabili con testo di aiuto
    protected $aiuto = array();
    // $data contiene variabili visualizzabili nel corpo della pagina
    protected $data = array();

    function __construct() {
        parent::__construct();
        // controllo se l'utente si è loggato
        if (!$this->ion_auth->logged_in()){
          redirect('accesso/login');
        }
        $this->load->database();
        $this->load->library('ion_auth');
        $this->load->library('grocery_CRUD');
    }


    /* Visualizzo una griglia con le fatture dell'Azienda */
    public function index() {
        $this->aiuto['aiuto_titolo'] = "ELENCO FATTURE";
        $this->aiuto['aiuto_msg'] = "Elenco delle fatture emesse per l'Azienda attualmente selezionata.";
        // Carico il model fatture
        $this->load->model('mod_fatture');
        // Preparo i dati da passare alla view
        $this->data['fatture'] = $this->mod_fatture->getFatture();
        $this->data['avuti'] = $this->mod_fatture->getFattAvuti($this->data['fatture']);
        // Istanzio la vista
        $this->load->view("template/tpl_header");
        $this->load->view("template/tpl_header_datatables");
        $this->load->view("jsh_index_view");
        $this->load->view("template/tpl_menu", $this->aiuto);
        $this->load->view("_menu_fatture");
        $this->load->view('index_view', $this->data);
        $this->load->view("template/tpl_footer");
        $this->load->view("template/tpl_end_page");
    } // fine index()

    /* Mostro una view per creare una nuova fattura */
    public function nuova(){
        $this->aiuto['aiuto_titolo'] = "NUOVA FATTURA";
        $this->aiuto['aiuto_msg'] = "Genera una nuova fattura per l'Azienda attualmente selezionata.";
        $this->load->model('mod_clienti');
        $this->load->model('mod_fatture');
        $this->data['clienti'] = $this->mod_clienti->getClienti();
        $this->data['iban'] = $this->mod_fatture->getIban($_SESSION['id_azienda']);
        if ($this->uri->segment(4) == "err") {
            $this->data['error'] = 1;
        }
        // Istanzio la vista
        $this->load->view("template/tpl_header");
        $this->load->view("template/tpl_header_datatables");
        $this->load->view("jsh_index_view");
        $this->load->view("template/tpl_menu", $this->aiuto);
        $this->load->view("_menu_fatture");
        $this->load->view('nuova', $this->data);
        $this->load->view("template/tpl_footer");
        $this->load->view("template/tpl_end_page");
    } // fine nuova()

    public function visualizza(){
        $this->aiuto['aiuto_titolo'] = "MODIFICA FATTURA";
        $this->aiuto['aiuto_msg'] = "Modifica una fattura per le Aziende del Gruppo Specchio.";
        $this->load->model('mod_clienti');
        $idfattura = $this->uri->segment(3);
        $this->load->model('mod_fatture');
        $this->data['fattura'] = $this->mod_fatture->getFattura($idfattura);
        $this->data['itemfatt'] = $this->mod_fatture->getItemFattura($idfattura);
        $this->data['idfattura'] = $idfattura;
        // Istanzio la vista
        $this->load->view("template/tpl_header");
        $this->load->view("template/tpl_header_datatables");
        $this->load->view("jsh_index_view");
        $this->load->view("template/tpl_menu", $this->aiuto);
        $this->load->view("_menu_fatture");
        $this->load->view('visualizza', $this->data);
        $this->load->view("template/tpl_footer");
        $this->load->view("template/tpl_end_page");
    }

    /* Codice che mi permette di inserire una nuova fattura */
    public function inserisci() {
      // Recupero i dati da inserire nella fattura
      $idazienda = $this->session->id_azienda;
      $idcliente = $this->input->post('cliente');
      $tipo = $this->input->post('tipo');
      $datafatt = date("Y-m-d",strtotime($this->input->post('data')));
        $datascad = date("Y-m-d",strtotime($this->input->post('datascad')));
      $pagamento = $this->input->post('pagamento');
      $totr = $this->input->post('totr');
      $iban = $this->input->post('iban');
      if(!isset($iban)){
          $iban = null;
      }
      // Calcolo il totale della fattura
      $totalefatt = 0;
      for($i = 0; $i < count($totr); $i++){
          $totalefatt+=$totr[$i];
      }
      // Questi sono array degli item della fattura
      $descrizione = $this->input->post('descrizione');
      $qnt = $this->input->post('qnt');
      $prezzo = $this->input->post('prezzo');
      $iva = $this->input->post('iva');
      //$totr = $this->input->post('totr'); totale da javscript

      $mod = $this->uri->segment(3);

      if ($idcliente == '-' || empty($descrizione[0]) || empty($datafatt) || $pagamento == '-' || $tipo == '-') { //controllo dati in input
          if($mod == 'mod'){
              $idfattura = $totr = $this->input->post('idfatt');
              redirect("fatture/modifica/" . $idfattura . "/err");
          }else{
              redirect("fatture/nuova/" . $_SESSION['id_azienda'] . "/err");
          }
      } else {
          $this->load->model('mod_clienti');
          $cliente = $this->mod_clienti->getCliente($idcliente);

          //fattura model
          $this->load->model('mod_fatture');

          if ($mod == 'mod') {
              //cancello item se mod è selezionato
              $idfattura = $totr = $this->input->post('idfatt');
              $this->mod_fatture->modFattura($idfattura, $datafatt, $datascad, $pagamento, $iban, $totalefatt, $tipo);
              $this->mod_fatture->deleteItemFatt($idfattura);
          } else {
              //creo fattura
              $idfattura = $this->mod_fatture->insFattura($idazienda, $cliente, $datafatt, $datascad, $pagamento, $iban, $totalefatt, $tipo);
          }
          //inserisco item
          for ($i = 0; $i < count($descrizione); $i++) {
              if (!empty($descrizione[$i]) && !empty($qnt[$i]) && !empty($prezzo[$i]) && !empty($iva)) {//se la riga non è vuota inserisci l'item
                  $prezzotot = $prezzo[$i] * $qnt[$i];
                  $ivacalc = ($prezzotot / 100) * $iva[$i];
                  $totaleriga = $prezzotot + $ivacalc;
                  $this->mod_fatture->insFatturaItem($descrizione[$i], $qnt[$i], $prezzo[$i], $iva[$i], $totaleriga, $idfattura);
              }
          }
          //fattura inserita
          redirect('fatture');
      }
    } // fine inserisci()

    public function modifica(){
        $this->aiuto['aiuto_titolo'] = "MODIFICA FATTURA";
        $this->aiuto['aiuto_msg'] = "Modifica una fattura per le Aziende del Gruppo Specchio.";
        // Carico i model
        $this->load->model('mod_fatture');
        $this->load->model('mod_clienti');
        // Estraggo i dati dei clienti
        $this->data['clienti'] = $this->mod_clienti->getClienti();
        if ($this->input->get('err') == 1) {
            $this->data['error'] = 1;
        }
        // Recupero l'id della fattura da modificare
        $idfattura = $this->uri->segment(3);
        // Estraggo i dati associati
        $this->data['fattura'] = $this->mod_fatture->getFattura($idfattura);
        $this->data['itemfatt'] = $this->mod_fatture->getItemFattura($idfattura);
        $this->data['count'] = count($this->data['itemfatt']);
        $this->data['idfattura'] = $idfattura;
        $this->data['iban'] = $this->mod_fatture->getIban($_SESSION['id_azienda']);
        // Istanzio la vista
        $this->load->view("template/tpl_header");
        $this->load->view("template/tpl_header_datatables");
        $this->load->view("jsh_index_view");
        $this->load->view("template/tpl_menu", $this->aiuto);
        $this->load->view("_menu_fatture");
        $this->load->view('modifica', $this->data);
        $this->load->view("template/tpl_footer");
        $this->load->view("template/tpl_end_page");
    } // fine modifica

    public function duplica($idfattura){
        //fattura duplicata
        $this->load->model('mod_fatture');
        $this->mod_fatture->clona($idfattura);
        redirect('fatture');
    }

    /* **** IBAN ***/
		public function gestisci_iban(){
  		$this->aiuto['aiuto_titolo']="IBAN";
  		$this->aiuto['aiuto_msg']="Gestisco gli IBAN associati alle Aziende del Gruppo.";
  		// Istanzio Grocery Crud
  		$crud = new grocery_CRUD();
  		$crud->set_theme('bootstrap');
  		$crud->set_table('iban');
  		$crud->set_language('italian');
  		$crud->display_as('id_azienda','Azienda');
  		$crud->columns('id_azienda', 'banca', 'iban');
  		$crud->unset_delete();
  		$crud->set_relation('id_azienda', 'aziende', 'rag_soc');
  		$crud->unset_bootstrap();
  		$output = $crud->render();
  		// Istanzio la vista
  		$this->load->view("template/tpl_header");
  		$this->load->view("template/tpl_menu", $this->aiuto);
  		$this->load->view('crud', $output);
  		$this->load->view("template/tpl_footer");
  		$this->load->view("template/tpl_end_page");
    } // fine gestisci_iban

/** **/
public function setup(){
  $this->aiuto['aiuto_titolo']="SETUP FATTURAZIONE";
  $this->aiuto['aiuto_msg']="Imposto gli indici e le annualità di riferimento per le future fatture";
  // Istanzio Grocery Crud
  $crud = new grocery_CRUD();
  $crud->set_theme('bootstrap');
  $crud->set_table('config');
  $crud->set_language('italian');
  $crud->display_as('id_azienda','Azienda');
  //$crud->columns('id_azienda', 'banca', 'iban');
  $crud->unset_delete();
  $crud->unset_add();
  $crud->set_relation('id_azienda', 'aziende', 'rag_soc');
  //$crud->unset_search();
  $crud->unset_bootstrap();
  $output = $crud->render();
  // Istanzio la vista
  $this->load->view("template/tpl_header");
  $this->load->view("template/tpl_menu", $this->aiuto);
  $this->load->view('crud', $output);
  $this->load->view("template/tpl_footer");
  $this->load->view("template/tpl_end_page");
}// end function setup


} // fine class
