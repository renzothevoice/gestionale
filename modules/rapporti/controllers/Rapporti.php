<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* 2017 - report.php - Classe Controller gestione Azienda
* Qui sono racchiusi tutti i metodi che consentono di stampare o visualizzare report.
*/
class Rapporti extends CI_Controller {
  // $aiuto contiene variabili con testo di aiuto
	protected $aiuto = array();
  // $data contiene variabili visualizzabili nel corpo della pagina
	protected $data = array();

  function __construct() {
          parent::__construct();
          $this->load->library('ion_auth');
					$this->load->helper(array('form', 'url'));
          if($this->ion_auth->logged_in()===FALSE){
            redirect('accesso/login');
          } // fine if
  } // fine construct


/*
* Visualizzo la home page della dashboard. Non posso chiamare report senza una function.
*/
  public function index(){
		redirect('dashboard');
	} // fine index



	public function fattura_pdf($id_fattura){
		// se non passo il parametro id_azinda esco nella dashboard
		if($id_fattura==0){
			redirect('dashboard');
			exit;
		}else{
			$id_azienda=$this->session->id_azienda;
			$this->load->model('mod_report');
			// Recupero i dati necessari per la creazione del PDF
			$this->data['dati_azienda']=$this->mod_report->dati_azienda($id_azienda);
			$this->data['testa_fattura']=$this->mod_report->testa_fattura($id_fattura);
			$this->data['corpo_fattura']=$this->mod_report->corpo_fattura($id_fattura);
			ini_set('memory_limit','64M'); // boost the memory limit if it's low ;)
			$html = $this->load->view('head', '', true);
			$html .= $this->load->view('fattura', $this->data, true);
			// Carico la libreria
			$pdf = new \Mpdf\Mpdf();
			// Imposto il footer
			$pdf->SetFooter('2017 © Tessitore&Cappelli'.'| Pag. {PAGENO} di {nbpg}|'.date(DATE_RFC822));
			$pdf->WriteHTML($html); // write the HTML into the PDF
			// lancio la funzione che invia un pdf
			$content = $pdf->Output('', 'S');
			//$this->invia_email($content,$email_cliente);
			// Visualizzo il file PDF nel browser
			$pdf->Output();
		} // fine if $id_fattura=0
	}//fine fattura


	public function test(){
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML('<h1>Hello world!</h1>');
		$mpdf->Output();
	}

	public function upload(){
		$this->load->view('upload');
	}

/** UPLOAD **/
	public function do_upload(){
							//ini_set('memory_limit','64M'); // boost the memory limit if it's low ;)
							 $config['upload_path']          = './uploads/';
							 $config['allowed_types']        = 'jpg';
							 $config['max_size']             = 1024;
							 $config['max_width']            = 1024;
							 $config['max_height']           = 1024;
							 $config['file_name']				     = 'test_';
							 $config['file_ext_tolower']     = TRUE;
							 $config['overwrite']            = TRUE;

							 $this->load->library('upload', $config);
							 if ( ! $this->upload->do_upload('userfile')) {
											 $error = array('error' => $this->upload->display_errors());
											 $this->load->view('upload', $error);
							 } else {
											 $data = array('upload_data' => $this->upload->data());
											 // Resize e altre manipolazioni
											 $config1['image_library'] = 'gd2';
 											 $config1['source_image'] = './uploads/test_.jpg';
											 $config1['create_thumb'] = FALSE;
											 $config1['maintain_ratio'] = TRUE;
											 $config1['width']         = 160;
											 //$config1['height']       = 50;
                       $this->load->library('image_lib', $config1);
 											 $this->image_lib->resize();
											 $data['display_errors']=$this->image_lib->display_errors();
											 // Quindi carico la vista terminata
											 $this->load->view('success', $data);
							 }
	 } // aggiungi_immagine

}// fine class report
