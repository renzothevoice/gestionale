<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* 2016 - Avvio.php - Classe Controller di inizio
* Permette di selezionare l'azienda con sui si intende operare.
*/

class Avvio extends CI_Controller {
  // $aiuto contiene variabili con testo di aiuto
	protected $aiuto = array();
  // $data contiene variabili visualizzabili nel corpo della pagina
	protected $data = array();

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->lang->load('auth');
		// controllo se l'utente si è loggato
		if (!$this->ion_auth->logged_in()){
      // se non si è loggato lo spedisco al controller login
			redirect('accesso/login');
			}
			/*
			gruppo 1=amministratore
			gruppo 2=occasionali generici
			gruppo 3=aquilaprem
			*/
		if ($this->ion_auth->in_group(1)){
			// Accesso Amministratore
			redirect('amministratore');
		}elseif ($this->ion_auth->in_group(2)) {
			// Accesso Utenti Generici UNIVOCI
			redirect('clienti');
		}elseif($this->ion_auth->in_group(3)) {
			// Accesso Aquilaprem
			redirect('aquilaprem');
		}else{
			redirect('htp://www.virgilio.it');
		}
	} // fine construct

	/*
	* Funzione chiamata dopo il login o lo svincolo, permette di scegliere l'azienda con cui operare.
	*/


  public function index($id_azienda=0){
  /* Carico la view di LOGIN */

	  if (($id_azienda==0) OR !isset($id_azienda)){
			$this->load->view("template/tpl_header");
			$this->load->view('index_view', $this->data);
			$this->load->view("template/tpl_footer");
			$this->load->view("template/tpl_end_page");
    }// fine if
  } // fine index


  /* Funzione che assegna l'azienda selezionata ad una variabile di sessione
  *  quindi reindirizzo il controllo alla dashboard. */
  private function assegna_azienda($id_azienda=0) {
    /* TOO: spostare inizializzazine array $dati_sessione appena dopo login! */
		$this->load->model('mod_avvio');
    $controllo = $this->mod_avvio->estrai_dati_azienda($id_azienda);
    if($controllo){
      redirect('dashboard');
      } else {
      redirect('avvio');
    } // fine if
  } // fine _assegna_azienda

    /* Funzione che resetta il valore della variabile di sessione che
    * contiene l'azienda selezionata. Mi reindirizza al metodo index() di questa classe */
/*
    public function svincola(){
			$this->load->model('avvio/mod_avvio');
      $controllo = $this->mod_avvio->reset_dati_azienda();
      redirect('avvio');
    } // fine svincola
*/

/*** BUONA, MA NON DEVE STARE QUI. RIMUOVERE. ***/
    public function backup_db(){
  		$this->load->dbutil();
  		$backup =& $this->dbutil->backup();
  		$this->load->helper('file');
  		write_file('/downloads/dbBackup'.date("dmYHi").'.gz', $backup);
  		$this->load->helper('download');
  		force_download('dbBackup'.date("dmYHi").'.gz', $backup);
	  }// Fine backup
} // fine Avvio
