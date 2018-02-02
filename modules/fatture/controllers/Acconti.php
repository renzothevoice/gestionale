<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
* 2016-2017 - Clienti.php - Classe Controller di gestione clienti
* Permette di operare con l'anagrafica dei vari clienti.
*
*
* Rev. 1.0 : 01/01/2017 - Tessitore
*/

class Acconti extends CI_Controller
{
    // $footer contiene variabili visualizzabile nel piedone
    protected $footer = array();
    // $aiuto contiene variabili con testo di aiuto
    protected $aiuto = array();
    // $data contiene variabili visualizzabili nel corpo della pagina
    protected $data = array();

    function __construct()
    {
        parent::__construct();
        // controllo se l'utente si è loggato
        if (!$this->ion_auth->logged_in()) {
            // se non si è loggato lo spedisco al controller login
            // TODO: RIMPIAZZARE IL METODO LOGIN CON IL SEMPLICE INDEX
            redirect('login/login');
        }
        $this->load->database();
        //$this->load->library('ion_auth');
        $this->load->library('grocery_CRUD');
    }


    /* redirect per metodo index, non posso accedere senza specificare un metodo */
    public function index(){
      redirect('/');
    }

    /* Visualizzo una griglia con gli acconti dell'azienda, per clienti */
    public function elenco($id_cliente=0){
        $this->aiuto['aiuto_titolo'] = "ACCONTI";
        $this->aiuto['aiuto_msg'] = "Elenco di tutti gli acconti ricevuti dai clienti dell'Azienda selezionata.";
        $this->load->model('mod_acconti');
        $data['acconti'] = $this->mod_acconti->getAcconti($_SESSION['id_azienda']);
        $datah['datatables_css'] = 1;
        if($id_cliente===0){
             $data['tipo_vista']=" per Azienda";
           }else{
             $data['tipo_vista']=" per Cliente";
           }
        $this->load->view("template/tpl_header");
        $this->load->view("template/tpl_header_datatables");
        $this->load->view("jsh_index_view");
        $this->load->view("template/tpl_menu", $this->aiuto);
        $this->load->view("_menu_fatture");
        $this->load->view('index_view_acc.php', $data);
        $this->load->view("template/tpl_footer");
        $this->load->view("template/tpl_end_page");
    } // fine elenco

    public function accontifattura($numerofattura=0){
        //$numerofattura = $this->uri->segment(4);
        /** exit **/
        $this->aiuto['aiuto_titolo'] = "ACCONTI";
        $this->aiuto['aiuto_msg'] = "Elenco di tutti gli acconti ricevuti dai clienti dell'Azienda selezionata e della fattura selezionata.";
        $this->load->model('mod_acconti');
        $data['acconti'] = $this->mod_acconti->getAccontiFatt($_SESSION['id_azienda'], $numerofattura);
        $datah['datatables_css'] = 1;
        $data['numerofattura'] = $numerofattura;

        $this->load->view("template/tpl_header");
        $this->load->view("template/tpl_header_datatables");
        $this->load->view("jsh_index_view");
        $this->load->view("template/tpl_menu", $this->aiuto);
        $this->load->view("_menu_fatture");
        $this->load->view('index_view_acc_fatt.php', $data);
        $this->load->view("template/tpl_footer");
        $this->load->view("template/tpl_end_page");
    }

    public function nuovo($numerofattura=0){
          $this->aiuto['aiuto_titolo'] = "NUOVO ACCONTO";
          $this->aiuto['aiuto_msg'] = "Inserisci un nuovo acconto.";
          $this->load->model('mod_fatture');
          $data['fatture'] = $this->mod_fatture->getFatture();
          if ($this->input->get('err') == 1) {
              $data['error'] = 1;
          }
          if ($this->input->get('err') == 2) {
              $data['error'] = 2;
          }
          if(is_numeric($numerofattura)&&!$numerofattura=0){
              $data['numerofattura'] = $numerofattura;
          }
          $this->load->view("template/tpl_header");
          $this->load->view("template/tpl_header_datatables");
          $this->load->view("jsh_index_view");
          $this->load->view("template/tpl_menu", $this->aiuto);
          $this->load->view("_menu_fatture");
          $this->load->view('nuovo_acconto', $data);
          $this->load->view("template/tpl_footer");
          $this->load->view("template/tpl_end_page");
      }


    public function modifica(){
        $this->aiuto['aiuto_titolo'] = "MODIFICA ACCONTO";
        $this->aiuto['aiuto_msg'] = "Modifica l'acconto.";
        $idacconto = $this->uri->segment(4);
        $this->load->model('mod_fatture');
        $data['fatture'] = $this->mod_fatture->getFatture();
        $this->load->model('mod_acconti');
        $data['acconto'] = $this->mod_acconti->getAcconto($idacconto);
        if ($this->input->get('err') == 1) {
            $data['error'] = 1;
        }
        $this->load->view("template/tpl_header");
        $this->load->view("template/tpl_header_datatables");
        $this->load->view("jsh_index_view");
        $this->load->view("template/tpl_menu", $this->aiuto);
        $this->load->view("_menu_fatture");
        $this->load->view('modifica_acc', $data);
        $this->load->view("template/tpl_footer");
        $this->load->view("template/tpl_end_page");
    }

    public function inserisci(){
        $data = addslashes($this->input->post('data'));
        $importo = str_replace(",",".",$this->input->post('importo'));
        $note = addslashes($this->input->post('note'));
        $fatturascelta = $this->input->post('fatturascelta');

        if ($fatturascelta == '-' || empty($data) || empty($importo) || empty($note)) { //controllo dati in input
            redirect("fatture/acconti/nuovo/" . "?err=1");
        } else {
            $aux = explode("|", $fatturascelta);
            $maxvalue = $aux[1];//valore che mnaca per chiudere la fattura
            $idfattura = $aux[0];
            if(!empty($maxvalue)) {
                if ($importo <= $maxvalue) {
                    $this->load->model('mod_acconti');
                    $this->mod_acconti->insAcconto($idfattura, $data, $importo, $note);
                    if ($importo == $maxvalue) {
                        $this->load->model('mod_fatture');
                        $this->mod_fatture->chiudiFatt($idfattura);
                    }
                    redirect("fatture/acconti/elenco");
                } else {
                    redirect("fatture/acconti/nuovo/" . "?err=2");
                }
            }else{
                redirect("fatture/acconti/elenco");
            }
        }
    }

    public function exmod(){
        $idacconto = $this->input->post('idacconto');
        $data = addslashes($this->input->post('data'));
        $idfattura = $this->input->post('idfattura');
        $importo = $this->input->post('importo');
        $note = addslashes($this->input->post('note'));

        if ($idfattura == '-' || empty($data) || empty($importo) || empty($note) || empty($idacconto)) { //controllo dati in input
            redirect("fatture/acconti/modifica/" . $idacconto . "?err=1");
        } else {
            $this->load->model('mod_acconti');
            $this->mod_acconti->modAcconto($idfattura, $idacconto, $data, $importo, $note);
            redirect("fatture/acconti");
        }
    }

    public function elimina($idacconto=0){
         /** ESCAPE **/
        $this->load->model('mod_acconti');
        $this->mod_acconti->deleteAcconto($idacconto);
        redirect("fatture/acconti/elenco");
    }
} // fine acconti
