<?php
/***********************************
* CODEMAKERS.                           *
* Ver. 0.1                         *
* 2018 © Tessitore Luigi           *
* Mdl_preventivi.php          *
***********************************/

class Mdl_preventivi extends CI_Model {

	function __construct(){
		parent::__construct();
	}


/* Funzione che estrae le info relative all'intestazione di un preventivo */
function estrai_intestazione_preventivo($id_preventivo=0){
  if(!is_null($id_preventivo)){
		$intestazione_preventivo=array();
		$this->db->from('preventivi');
		$this->db->join('clienti', 'clienti.id_cliente = preventivi.id_cliente');
		$this->db->join('mod_pagamento', 'mod_pagamento.id_mod_pagamento = preventivi.id_mod_pagamento');
    $this->db->where('id_preventivo', $id_preventivo);
    $query = $this->db->get();
    if($query->num_rows()==1){
      $row=$query->row();
        $intestazione_preventivo['id_preventivo']=strip_tags($row->id_preventivo);
        $intestazione_preventivo['id_cliente']=strip_tags($row->id_cliente);
				$intestazione_preventivo['nome']=strip_tags($row->nome);
				$intestazione_preventivo['cognome']=strip_tags($row->cognome);
        $intestazione_preventivo['ragione_sociale']=strip_tags($row->rag_soc);
        $intestazione_preventivo['data_creazione']=strip_tags($row->data_creazione);
        $intestazione_preventivo['id_utente']=strip_tags($row->id_utente);
        $intestazione_preventivo['oggetto']=strip_tags($row->oggetto);
        $intestazione_preventivo['note_preventivo']=strip_tags($row->note_preventivo);
        $intestazione_preventivo['validita']=strip_tags($row->validita);
        $intestazione_preventivo['modalita_pagamento']=strip_tags($row->modalita_pagamento);
      } // fine num_rows | se non ho
    return $intestazione_preventivo;
  }  // fine if
} // fine estrai_intestazione_preventivo

/* Funzione che estrae le voci relative ad un preventivo */
function estrai_item_preventivo($id_preventivo=0){
  if(!is_null($id_preventivo)){
		$item_preventivo=array();
		$this->db->from('item_preventivi');
    $this->db->where('id_preventivo', $id_preventivo);
    $query = $this->db->get();
		return $query;
  }  // fine if
} // fine estrai_item_preventivo

/** GESTIONE RIGHE PREVENTIVO - 23012018 **/
function inserisci_item($data){
		$query=$this->db->insert('item_preventivi', $data);
		$nuovo_id_item=$this->db->insert_id();
		if ($this->db->affected_rows() >= 1) {
			//return true;
			return $nuovo_id_item;
		} else {
			return false;
		}
	} // fine inserisci_item

	function aggiorna_item($data){
			$this->db->where('id_item_preventivo', $data['id_item_preventivo']);
			$this->db->update('item_preventivi', $data);
			return true;
		} // fine aggiorna_item

	 function visualizza_item($id_item_preventivo){
		$this->db->select('*');
		$this->db->from('item_preventivi');
		$this->db->where('id_item_preventivo', $id_item_preventivo);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	 } // fine visualizza_item

	 /* Funzione che duplica un preventivo */
	 function duplica_preventivo($id_preventivo=0){
		 // duplico il preventivo
		$this->db->where('id_preventivo',$id_preventivo);
 		$query = $this->db->get('preventivi');
  	 	foreach ($query->result() as $row){
	 			foreach($row as $key=>$val){
	 				if($key != 'id_preventivo'){
	 			 	/* $this->db->set can be used instead of passing a data array directly to the insert or update functions */
	 			 	$this->db->set($key, $val);
	 			 	}//endif
	 			}//endforeach
  		}//endforeach
 	 //return $this->db->insert('preventivi');
	 $this->db->insert('preventivi');
	 $nuovo_id_preventivo = $this->db->insert_id();
   // duplico gli item con lo stesso $id_preventivo
	 $this->db->where('id_preventivo',$id_preventivo);
	 $query = $this->db->get('item_preventivi');
	 foreach ($query->result() as $row){
		// print_r($row);
		 foreach($row as $key=>$val){
			 if(($key != 'id_item_preventivo')&&($key!='id_preventivo')){
			 $this->db->set($key, $val);
			 }//endif
			 if($key=='id_preventivo'){
				 $this->db->set($key, $nuovo_id_preventivo);
			 }
		 }//endforeach
		 $this->db->insert('item_preventivi');
	 }//endforeach
	 return TRUE;
	 } // fine duplica

	 /* Funzione che clona la voce di un preventivo */
	 function clona_item($id_item_preventivo=0){
		$this->db->where('id_item_preventivo',$id_item_preventivo);
		$query = $this->db->get('item_preventivi');
 	 	foreach ($query->result() as $row){
			foreach($row as $key=>$val){
				if($key != 'id_item_preventivo'){
			 	/* $this->db->set can be used instead of passing a data array directly to the insert or update functions */
			 	$this->db->set($key, $val);
			 	}//endif
			}//endforeach
 		}//endforeach
	 return $this->db->insert('item_preventivi');
 } // fine clona_item


} // fine model
