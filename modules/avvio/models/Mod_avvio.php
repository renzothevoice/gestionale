<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Name:  Mod_Avvio.php *
* Model di gestione Aziende
*/

class Mod_avvio extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  } // fine __construct

  public function estrai_dati_azienda($id_azienda){
    $this->db->where('id_azienda', $id_azienda);
    $query = $this->db->get('aziende');
    		if($query->num_rows()==1){
    		  $dati_sessione=array();
    			$row=$query->row();
    			$dati_sessione['id_azienda']=$row->id_azienda;
    			$dati_sessione['rag_soc_azienda']=$row->rag_soc;
          $dati_sessione['anno_contabile']=date('Y');
          $this->session->set_userdata($dati_sessione);
    			return true;
      } // fine if
    } // fine estrai_dati_azienda

    public function reset_dati_azienda(){
  	  $dati_sessione=array();
  		$dati_sessione['id_azienda']="";
  		$dati_sessione['rag_soc_azienda']="";
  	  $this->session->set_userdata($dati_sessione);
  		return true;
    } // fine reset_dati_azienda

}
