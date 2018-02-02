<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Name:  Mod_clienti.php *
* Model di gestione Clienti
*/

class Mod_clienti extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /** Estraggo tutti i dati anagrafici associati ad un cliente **/
    public function dati_cliente($id_cliente){
      $this->db->select('*');
      $this->db->from('clienti');
      $this->db->where('id', $id_cliente);
      $query = $this->db->get();
      if ($query->num_rows() >= 1) {
          return $query->result();
      }else{
          return 0;
      }
    }

    /** Estraggo le fatture associate ad un cliente, tutte o solo le ultime 20 **/
    public function fatture($id_cliente, $limite=0){
      $this->db->where('id_cliente', $id_cliente);
      if(!$limite==0){
      $this->db->limit(20, 0);
      }// fine if
      $this->db->order_by('data_creazione', 'DESC');
      $query = $this->db->get('fatture');
      if ($query->num_rows() >= 1) {
          return $query->result();
      }else{
          return 0;
      }
    }

    public function getCliente($idcliente=0)
    {
        $query = $this->db->query("SELECT * FROM clienti WHERE id = '$idcliente'");
        if ($query->num_rows() >= 1) {
            return $query->row();
        }else{
            return 0;
        }
    }

    public function getClienti()
    {
        $query = $this->db->query('SELECT * FROM clienti');
        if ($query->num_rows() >= 1) {
            return $query->result();
        }else{
            return 0;
        }
    }
} // fine class
