<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
* Name:  Mod_eventi.php *
* Model di gestione Eventi
*/

class Mod_eventi extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

  /* Estraggo tutti gli eventi associati ad un cliente */
  public function eventi_cliente($id_cliente){
      $this->db->where('id_cliente', $id_cliente);
      $query = $this->db->get('eventi');
      return $query->result();
  }

}
