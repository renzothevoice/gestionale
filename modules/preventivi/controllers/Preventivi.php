<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
* 2018 - Preventivi.php - Classe Controller gestione Preventivi
*/
class Preventivi extends CI_Controller {
  // $data contiene variabili visualizzabili nel corpo della pagina
	protected $data = array();
	protected $opzioni = array();

  function __construct() {
          parent::__construct();
							$this->load->model('mdl_preventivi');
          if($this->ion_auth->logged_in()===FALSE){
						// TODO: RIMPIAZZARE IL METODO LOGIN CON IL SEMPLICE INDEX
            redirect('accesso/login');
          } // fine if
  } // fine construct


/*
* Visualizzo la dashboard relativa ai Preventivi
*/
  public function index(){
		$this->codemakers->genera_vista_admin('dashboard', $this->data, $this->opzioni);
	}

	/*
	* Visualizzo l'elenco dei preventivi emessi
	*/
	  public function elenco(){
  		// Istanzio Grocery Crud
  		$crud = new grocery_CRUD();
  		$crud->set_theme('bootstrap');
  		$crud->set_table('preventivi');
			$crud->set_subject('Elenco Preventivi');
			$crud->columns('id_preventivo','id_cliente','data','oggetto','note');
			$crud->display_as('id_preventivo','Numero');
			$crud->display_as('id_cliente','Ragione Sociale');
			$crud->set_relation('id_cliente','clienti','rag_soc');
			$crud->set_relation('id_mod_pagamento','mod_pagamento','modalita_pagamento');
			$crud->unset_columns('id_operatore');
			$crud->unset_edit_fields('id_operatore');
			$crud->add_action('Stampa', '', 'preventivi/stampa', 'fa-print');
			$crud->add_action('Modifica Preventivo', '', 'preventivi/modifica', 'fa-edit');
			$crud->add_action('Edita Righe', '', 'preventivi/seleziona', 'fa-edit');
			$crud->callback_column('id_cliente',array($this,'_callback_seleziona_preventivo'));
			$crud->callback_column('rag_soc',array($this,'_callback_seleziona_preventivo'));
			$crud->callback_column('data_preventivo',array($this,'_callback_seleziona_preventivo'));
			$crud->callback_column('oggetto',array($this,'_callback_seleziona_preventivo'));
			$crud->callback_column('note',array($this,'_callback_seleziona_preventivo'));
  		$crud->set_language('italian');
			// Non posso cancellare un Cliente
  		$crud->unset_delete();
  		$crud->unset_bootstrap();
  		$this->data = $crud->render();
			// Genero la view
			$this->codemakers->genera_vista_admin('crud', $this->data, $this->opzioni);
		} // fine elenco

		/* Callback che genera i link per selezionare un preventivo */
		function _callback_seleziona_preventivo($value = '', $primary_key = null){
			return '<a href="'.base_url().'preventivi/seleziona/'.$primary_key->id_preventivo.'">'.$value.'<a/>';
		} // fine _callback_seleziona_preventivo


		/*
		* Funzione che carica l'intefaccia di selezione del preventivo
		*/
		public function seleziona($id_preventivo=""){
			// Per prima cosa creo una var di sessione con l'id_preventivo in uso
			$this->session->id_preventivo=$id_preventivo;
			// Recupero dalla tabella preventivi tutto il necessario
			$this->load->model('mdl_preventivi');
			$this->data['intestazione']=$this->mdl_preventivi->estrai_intestazione_preventivo($id_preventivo);
			$this->data['items']=$this->mdl_preventivi->estrai_item_preventivo($id_preventivo);
			// Definisco l'uso di DataTable nella view
			$this->opzioni=array("datatables");
			// Preparo il necessario per istanziare grocery_CRUD
			$crud = new grocery_CRUD();
			$crud->set_theme('bootstrap');
			$crud->set_table('preventivi');
			$crud->unset_delete();
			$crud->unset_bootstrap();
			// Renderizzo Grocery
			$output=$crud->render();
			//$output->content_view='crud_content_view';
			$output->data=$this->data;
			// Genero la view
			$this->codemakers->genera_vista_admin('seleziona', $output, $this->opzioni);
		} // fine seleziona

		/*
		* Visualizzo l'elenco delle voci di un preventivo
		*/
		  public function item($id_preventivo=0){
	  		// Istanzio Grocery Crud
	  		$crud = new grocery_CRUD();
	  		$crud->set_theme('bootstrap');
	  		$crud->set_table('item_preventivi');
				$crud->set_subject('Elenco Voci');
				//$crud->set_relation('id_cliente','clienti','rag_soc');
				if($id_preventivo==0){
					$crud->where('id_preventivo',$this->session->id_preventivo);
				}
				//$crud->where('id_preventivo','active');
				$crud->set_language('italian');
	  		$crud->unset_bootstrap();
	  		$this->data = $crud->render();

				$state = $crud->getState();
				$state_info = $crud->getStateInfo();

				if($state == 'add'){
				//Do your cool stuff here . You don't need any State info you are in add
					$crud->where('id_preventivo',$this->session->id_preventivo);
				}elseif($state == 'edit'){
					$primary_key = $state_info->primary_key;
				}else{
					$this->codemakers->genera_vista_admin('crud', $this->data, $this->opzioni);
				}
				$this->codemakers->genera_vista_admin('crud', $this->data, $this->opzioni);

			} // fine item

			function call_insert($post_array,$primary_key){
				$this->db->set('id_preventivo', $this->session->id_preventivo);
				$this->db->update('item_preventivi');
				return true;
			}



			public function _reindirizza($post_array, $primary_key){
				//$link = site_url(strtolower(__CLASS__) . "your_method/" . $primary_key);
				$data = "dsdsada.<br/>eqwewqher page.";
        //$data .= "<script type='text/javascript'> window.location = '" . $link . "';</script><div style='display:none'></div>";

        // set it in gc crud
        $this->crud->set_lang_string('insert_success_message', $data);

        // return array to complete action
        return $true;
			} // fine _item_after_update
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
			} // fine ws

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
				} // fine prn

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
					} // fine mobile



/** GESTIONE RIGHE PREVENTIVO - 23012018 **/

	public function inserisci_item($id_preventivo=0){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->config->set_item('language', 'italian');
		$id_preventivo=$this->session->id_preventivo;
		// imposto le regole
		$this->form_validation->set_rules('qnt', 'Quantità', 'required|numeric');
		$this->form_validation->set_rules('prezzo', 'Prezzo', 'required|numeric');
		// procedo con l'analisi della situazione
		if ($this->form_validation->run() == FALSE){
			// Non ho intercettato un SUBMIT; Carico la vista
			$this->data['errore']="Tutto OKAPPA!";
			$this->codemakers->genera_vista_admin('ins_item', $this->data, $this->opzioni);
		}else{
			// Ho intercettato un SUBMIT; Recupero i valori dal form
			$data = array(
				'tipologia' => $this->input->post('tipologia'),
				'descrizione' => $this->input->post('descrizione'),
				'qnt' => $this->input->post('qnt'),
				'unita_misura' => $this->input->post('unita_misura'),
				'prezzo' => $this->input->post('prezzo'),
				'iva' => $this->input->post('iva'),
				'sconto' => $this->input->post('sconto'),
				'note_item_preventivo'=> $this->input->post('note_item_preventivo'),
				'immagine' => $this->input->post('immagine'),
				'id_preventivo' => $id_preventivo
			);
			// Trasmetto i dati testuali al modello, se restituisce FALSE qualcosa è andato storto
			// altrimenti ottengo l'id inserito!
			$risultato_insert=$this->mdl_preventivi->inserisci_item($data);
			if($risultato_insert==FALSE){
				redirect($risultato_insert);
			}else{
				// Setup della libreria upload
				$config['upload_path']   = './uploads/item_preventivi';
				$config['allowed_types'] = 'jpg';
				$config['max_size']      = 500;
				$config['max_width']     = 2048;
				$config['max_height']    = 2048;
				$config['file_name']				    = $risultato_insert.'___'.$id_preventivo.'.jpg';
				$config['file_ext_tolower']     = TRUE;
				$config['overwrite']            = TRUE;
				$this->load->library('upload', $config);
				// Controllo se è presente realmente una Immagine
				if($this->upload->do_upload('immagine')){
					// Upload andato a buon fine
					// Resize e altre manipolazioni
					$config1['image_library'] = 'gd2';
					$config1['source_image'] = './uploads/item_preventivi/'.$id_preventivo.'_utente.jpg';
					$config1['create_thumb'] = FALSE;
					$config1['maintain_ratio'] = TRUE;
					$config1['width']         = 160;
					$this->load->library('image_lib', $config1);
					$this->image_lib->resize();
	        $data = array('upload_data' => $this->upload->data());
	        $this->load->view('upload_success', $data);
					redirect(base_url().'preventivi/seleziona/'.$id_preventivo);
				}else{
					// upload immagine fallito. todo:flashdata con errore
					//$errore = array('error' => $this->upload->display_errors());
					redirect('http://www.bing.it');
				}
			}

			//


			// Ritorno all'home del preventivo
			redirect('preventivi/seleziona/'.$this->session->id_preventivo);
		}
	}// fine inserisci_item

	function aggiorna_item() {
		//$id_item_preventivo= $this->input->post('id_item_preventivo');
		$data = array(
			'id_item_preventivo' => $this->input->post('id_item_preventivo'),
			'tipologia' => $this->input->post('tipologia'),
			'descrizione' => $this->input->post('descrizione'),
			'qnt' => $this->input->post('qnt'),
			'unita_misura' => $this->input->post('unita_misura'),
			'prezzo' => $this->input->post('prezzo'),
			'iva' => $this->input->post('iva'),
			'sconto' => $this->input->post('sconto'),
			'note_item_preventivo'=> $this->input->post('note_item_preventivo'),
			'id_preventivo' => $this->session->id_preventivo
		);
		$this->mdl_preventivi->aggiorna_item($data);
		// Ritorno all'home del preventivo
		redirect('preventivi/seleziona/'.$this->session->id_preventivo, 'location');
	} // fine aggiorna_item

	function edit_item(){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->config->set_item('language', 'italian');
	    $id_item_preventivo = $this->uri->segment(3);
	    if($this->data['post'] = $this->input->post()){
				// imposto le regole
				$this->form_validation->set_rules('qnt', 'Quantità', 'required|numeric');
				$this->form_validation->set_rules('prezzo', 'Prezzo', 'required|numeric');
	      if($this->form_validation->run() == TRUE){
					// Recupero i dati inviati via post
					$this->post_data = array(
						//'id_item_preventivo' => $this->input->post('id_item_preventivo'),
						'id_item_preventivo' => $id_item_preventivo,
						'tipologia' => $this->input->post('tipologia'),
						'descrizione' => $this->input->post('descrizione'),
						'qnt' => $this->input->post('qnt'),
						'unita_misura' => $this->input->post('unita_misura'),
						'prezzo' => $this->input->post('prezzo'),
						'iva' => $this->input->post('iva'),
						'sconto' => $this->input->post('sconto'),
						'note_item_preventivo'=> $this->input->post('note_item_preventivo'),
						'id_preventivo' => $this->session->id_preventivo
					);
					// Aggiorno il database
					$this->mdl_preventivi->aggiorna_item($this->post_data);
					// Ritorno all'home del preventivo
					redirect('preventivi/seleziona/'.$this->session->id_preventivo, 'location');
		    }else{
					// Visualizza e riempie il form
					$this->data['item_preventivo'] = $this->mdl_preventivi->visualizza_item($id_item_preventivo);
					//$this->data['item_preventivo']=$visualizza_item['test'];
					// Carico la vista
					$this->codemakers->genera_vista_admin('edit_item', $this->data, $this->opzioni);
		    }
	    }else{
					// Visualizza e riempie il form
					$this->data['item_preventivo'] = $this->mdl_preventivi->visualizza_item($id_item_preventivo);
					// Carico la vista
					$this->codemakers->genera_vista_admin('edit_item', $this->data, $this->opzioni);
	    }
	} // fine edit


	public function visualizza_item($id_item_preventivo=0){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('qnt', 'Quantità', 'required|numeric');
		$this->form_validation->set_rules('prezzo', 'Prezzo', 'required|numeric');
		$this->data['item_preventivo'] = $this->mdl_preventivi->visualizza_item($id_item_preventivo);
		// Carico la vista
		if ($this->form_validation->run() == FALSE){
			// Carico la vista
			$this->codemakers->genera_vista_admin('show_item', $this->data, $this->opzioni);
		} // fine if
	} // fine visualizza_item

	/* Funzione che duplica un preventivo */
	public function duplica_preventivo($id_preventivo=0){
		if($id_preventivo){$id_preventivo=$this->session->id_preventivo;}
		// duplico un PREVENTIVO
		$this->mdl_preventivi->duplica_preventivo($id_preventivo);
		// carico la selezione con il nuovo preventivo clonato
		redirect('preventivi/elenco', 'location');
	} // fine duplica

	/* Funzione che clona la voce di un preventivo */
	public function clona_item($id_item_preventivo=0){
		if(!$id_item_preventivo==0){
		// duplico una voce di PREVENTIVO
		$this->mdl_preventivi->clona_item($id_item_preventivo);
		}
		// carico la selezione con il nuovo preventivo clonato
		redirect('preventivi/seleziona/'.$this->session->id_preventivo, 'location');
	} // fine clona_item

	/* Funzione che elimina la voce di un preventivo */
	public function elimina_item($id_item_preventivo=0){
		if(!$id_item_preventivo==0){
		// duplico una voce di PREVENTIVO
		$this->mdl_preventivi->elimina_item($id_item_preventivo);
		}
		// carico la selezione con il nuovo preventivo clonato
		redirect('preventivi/seleziona/'.$this->session->id_preventivo, 'location');
	} // fine elimina_item

} //Fine controller Clienti
