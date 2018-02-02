<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
* Name:  Mod_Report.php *
* Model di gestione informazioni nel controller Report
*/

class Mod_Report extends CI_Model{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  } // fine __construct

  /** estraggo i dati anagrafici dell'azienda corrente **/

    public function dati_azienda($id_azienda){
      $this->db->where('id_azienda', $id_azienda);
      $query = $this->db->get('aziende');
      if ($query->num_rows() >= 1) {
          return $query->result();
      }else{
          return 0;
      }
    } // fine dati_azienda

  /** Funzione che estrae i dati di base di una fattura **/
    public function testa_fattura($id_fattura){
      $this->db->where('id_fattura', $id_fattura);
      $query = $this->db->get('fatture');
      if ($query->num_rows() >= 1) {
          return $query->result();
      }else{
        // non ho trovato alcuna fattura, meglio andarsene
        redirect('dashboard');
      }
    } //fine testa_fatture

    /** Funzione che estrae gli elementi (corpo) di una fattura **/
    public function corpo_fattura($id_fattura){
      $this->db->where('id_fattura', $id_fattura);
      $query = $this->db->get('item_fatture');
      return $query;
    } //fine corpo_fatture


}//fine class
