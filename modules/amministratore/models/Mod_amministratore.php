<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Name:  Mod_Dashboard.php *
* Model di gestione informazioni nella Dashboard
*/

class Mod_Amministratore extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  } // fine __construct


  /** estraggo i ToDo **/
  public function estrai_todo($cliente="0",$stato="0"){
    //$this->db->select('numero, data_creazione, rag_soc');
    $this->db->select('todo.*');
    $this->db->select('clienti.rag_soc');
    $this->db->from('todo');
    $this->db->join('clienti', 'clienti.id_cliente = todo.id_cliente');
    //$this->db->where('id_azienda', $id_azienda);
    if($stato==0){
    $this->db->where('todo.stato !=', 'CHIUSO');
    }
    $this->db->order_by('data_apertura', 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  } // fine estrai_todo


/** OLD **/

/** elenco clienti gestiti da una determinata azienda **/
/*
    public function elenco_clienti($id_azienda, $limite=0){
      $squery="SELECT DISTINCT clienti.id, clienti.rag_soc, clienti.piva, clienti.citta ";
      $squery.="FROM clienti INNER JOIN fatture ";
      $squery.="ON clienti.id=fatture.id_cliente ";
      $squery.="WHERE fatture.id_azienda='$id_azienda' ";
      //$squery.="ORDER BY fatture.data_creazione";
      $query = $this->db->query($squery);
      return $query;
      } // fine fatture_insolute
*/

/** ESTRAZIONE DATI FATTURE PER CLIENTE/AZIENDA ***
* Questa Funzione restituisce un array con gli elementi relativi alle fatture di un
* determinato cliente. Occorre passare l'id_cliente e si suppone l'id_azienda
***/
public function estraiFatture($id_cliente=0,$stato){
  // seleziono i campi che mi interessano
  //$this->db->select('numero','data_creazione','data_scadenza', 'tipo', 'totaleii','rag_soc','stato');

  // filtro per azienda
  $id_azienda = $_SESSION['id_azienda'];
  $this->db->where('id_azienda', $id_azienda);
  // filtro l'anno contabile
  $anno=$this->session->anno_contabile;
  $this->db->where("data_creazione BETWEEN '$anno-01-01' AND '$anno-12-31'");
  // se presente, filtro per id_cliente
  if($id_cliente){
    $this->db->where('id_cliente', $id_cliente);
  }
  if(!$stato==""){
    $this->db->where('stato', $stato);
  }
  // Eseguo la Query
  $data = $this->db->get('fatture');
  //$dataset=$data->row_array();
  $dataset=$data->result_array();
  foreach ($dataset as $key => $value) {
    $dataset[$key]['acconti']=$this->totAccontiFattura($dataset[$key]['id_fattura']);
  }
return $dataset;
}
/*****/


/** estraggo le sole Fatture insolute **/
  public function fatture_insolute($id_azienda, $limite=0){
    //$this->db->select('numero, data_creazione, rag_soc');
    $this->db->where('id_azienda', $id_azienda);
    $this->db->where('stato', 'A');
    if(!$limite==0){
    $this->db->limit(100, 0);
    }// fine if
    $this->db->order_by('data_creazione', 'DESC');
    $query = $this->db->get('fatture');
    return $query;
    } // fine fatture_insolute

/** Estraggo le fatture di una determinata azienda **/
  public function fatture($id_azienda, $limite=0){
    //$this->db->select('numero, data_creazione, rag_soc');
    $anno=$this->session->anno_contabile;
    $this->db->where('id_azienda', $id_azienda);
    $this->db->where("data_creazione BETWEEN '$anno-01-01' AND '$anno-12-31'");
    if(!$limite==0){
    $this->db->limit(100, 0);
    }// fine if
    $this->db->order_by('data_creazione', 'DESC');
    $query = $this->db->get('fatture');
    return $query;
    } // fine fatture_insolute

/** elenco clienti gestiti da una determinata azienda **/
    public function elenco_clienti($id_azienda, $limite=0){
      $squery="SELECT DISTINCT clienti.id, clienti.rag_soc, clienti.piva, clienti.citta ";
      $squery.="FROM clienti INNER JOIN fatture ";
      $squery.="ON clienti.id=fatture.id_cliente ";
      $squery.="WHERE fatture.id_azienda='$id_azienda' ";
      //$squery.="ORDER BY fatture.data_creazione";
      $query = $this->db->query($squery);
      return $query;
      } // fine fatture_insolute

/** SPOSTARE?? La uso in REPORT??  - estraggo i dati anagrafici dell'azienda corrente **/

  public function dati_azienda($id_azienda){
    $this->db->where('id_azienda', $id_azienda);
    $query = $this->db->get('aziende');
    if ($query->num_rows() >= 1) {
        return $query->result();
    }else{
        return 0;
    }
  } // fine dati_azienda

    /*
  	* Funzione che calcola l'ammontare totale che una azienda deve incassare.
  	* SELECT SUM() from item_fatture WHERE stato=A AND id_azienda=$id_azienda
  	*/
  	public function totale_avere($id_azienda){
  		/* TO DO */
  	}//fine totale_avere

    /*
    seleziono gli ID di tutte le fatture APERTE e associate al CLIENTE e Azienda
    per ogni ID_FATTURA effettuo una SUM fra tutti i PAGAMENTI ricevuti
    */
    public function insoluti_cliente($id_cliente){
      $this->db->where('id_azienda', $id_azienda);
      $this->db->where('id_cliente', $id_cliente);
      $query = $this->db->get('fatture');
    } // fine insoluti_cliente
  } // fine classe
