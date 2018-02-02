<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Name:  Mod_acconti.php *
* Model di gestione Acconti
*/

class Mod_acconti extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getAcconti($idazienda){
        $query = $this->db->query("SELECT idacconto, numerofatt, data_registrazione, valoreii, acconti.note, rag_soc, acconti.id_fattura FROM acconti LEFT JOIN fatture ON fatture.id_fattura=acconti.id_fattura WHERE acconti.id_azienda = '$idazienda'");
        return $query->result();
    }

    public function getAccontiFatt($idazienda, $numerofattura){
        $query = $this->db->query("SELECT idacconto, numerofatt, data_registrazione, valoreii, acconti.note, rag_soc, acconti.id_fattura FROM acconti LEFT JOIN fatture ON fatture.id_fattura=acconti.id_fattura WHERE acconti.id_azienda = '$idazienda' AND acconti.numerofatt='$numerofattura'");
        return $query->result();
    }

    public function getAcconto($idacconto){
        $query = $this->db->query("SELECT idacconto, numerofatt, data_registrazione, valoreii, acconti.note, rag_soc, acconti.id_fattura FROM acconti LEFT JOIN fatture ON fatture.id_fattura=acconti.id_fattura WHERE acconti.idacconto = '$idacconto'");
        return $query->result();
    }

    public function insAcconto($idfattura, $data, $importo, $note){
        $data = date_format(date_create($data), "Y-m-d");
        $res = $this->db->query("SELECT * FROM fatture WHERE id_fattura = '$idfattura'")->row();
        $idazienda = $res->id_azienda;
        $numerofatt = $res->numero;
        $importo = str_replace(",",".",$importo);
        $datareg = date("Y-m-d");
        $this->db->query("INSERT INTO acconti (idacconto, id_fattura, id_azienda, numerofatt, data_registrazione, data_creazione, valoreii, note)
                        VALUES('','$idfattura','$idazienda','$numerofatt','$datareg','$data','$importo','$note')");
        return;
    }

    public function modAcconto($idfattura, $idacconto, $data, $importo, $note)
    {
        $data = date_format(date_create($data), "Y-m-d");
        $importo = str_replace(",",".",$importo);
        $this->db->query("UPDATE acconti SET data_registrazione = '$data', id_fattura = '$idfattura', valoreii = '$importo', note = '$note' WHERE idacconto = '$idacconto'");
        return;
    }

    public function deleteAcconto($idacconto)
    {
        $this->db->query("DELETE FROM acconti WHERE idacconto = '$idacconto'");
        return;
    }

}
