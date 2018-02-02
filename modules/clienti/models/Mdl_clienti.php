<?php
/***********************************
* CODEMAKERS.                           *
* Ver. 0.1                         *
* 2018 © Tessitore Luigi           *
* Mdl_clienti.php          *
***********************************/

class Mdl_clienti extends CI_Model {

	function __construct(){
		parent::__construct();
	}



function estrai_dati_cliente($cliente_id=0){
  if(!is_null($cliente_id)){
    $this->db->where('cliente_id', $cliente_id);
    $query = $this->db->get('clienti');
    if($query->num_rows()==1){
      $row=$query->row();
        $dati_cliente=array();
        $dati_cliente['cliente_id']=strip_tags($cliente_id);
        $dati_cliente['ragione_sociale']=strip_tags($row->ragione_sociale);
        $dati_cliente['email']=strip_tags($row->email);
        $dati_cliente['telefono']=strip_tags($row->telefono);
        $dati_cliente['indirizzo']=strip_tags($row->indirizzo);
        $dati_cliente['citta']=strip_tags($row->citta);
        $dati_cliente['piva']=strip_tags($row->piva);
        $dati_cliente['attivita']=strip_tags($row->attivita);
        $dati_cliente['persona_di_riferimento']=strip_tags($row->persona_di_riferimento);
      } // fine num_rows
    return $dati_cliente;
  }  // fine if
} // fine estrai_dati_cliente





} // fine model
