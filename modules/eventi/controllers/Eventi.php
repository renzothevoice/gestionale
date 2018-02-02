<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eventi extends CI_Controller {
	// $footer contiene variabili visualizzabile nel piedone
	protected $footer = array();
  // $aiuto contiene variabili con testo di aiuto
	protected $aiuto = array();
  // $data contiene variabili visualizzabili nel corpo della pagina
	protected $data = array();
		function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model('Mod_eventi');
    }


	/** Visualizzo TUTTI gli eventi associati all'azienda in uso. **/
	Public function index()
	{
		$id_azienda=$this->session->id_azienda;
		$this->aiuto['aiuto_titolo']="EVENTI";
		$this->aiuto['aiuto_msg']="Visualizzo tutti gli eventi associati all'azienda in uso..";
		/** Istanzio la vista **/
		$this->load->view("template/tpl_header");
		$this->load->view("template/tpl_header_datatables");
		$this->load->view("jsh_eventi_view");
		$this->load->view("template/tpl_menu", $this->aiuto);
		$this->load->view('index_eventi', $this->data);
		$this->load->view("template/tpl_footer");
		$this->load->view("template/tpl_end_page");
	}

	/*Get all Events */
	Public function getEvents()
	{
		$result=$this->Mod_eventi->getEvents();
		$eventi_json=array();
		foreach ($result as $key) {
			# code...
			$row = array();
			$row['start'] = $key->inizio;
			$row['end'] = $key->fine;
			$row['title'] = $key->descrizione;
			$row['color'] = $key->colore;
			array_push($eventi_json, $row);
		}
		echo json_encode($eventi_json);


		//echo json_encode($result);
	}

	/*Add new event */
	Public function addEvent()
	{
		$result=$this->Mod_eventi->addEvent();
		echo $result;
	}

	/*Update Event */
	Public function updateEvent()
	{
		$result=$this->Mod_eventi->updateEvent();
		echo $result;
	}

	/*Delete Event*/
	Public function deleteEvent()
	{
		$result=$this->Mod_eventi->deleteEvent();
		echo $result;
	}

	Public function dragUpdateEvent()
	{
		$result=$this->Mod_eventi->dragUpdateEvent();
		echo $result;
	}
}
