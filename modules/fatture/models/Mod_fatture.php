<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
* Name:  Mod_fatture.php *
* Model di gestione Fatture
*/

class Mod_fatture extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function insFattura($idazienda, $cliente, $datafatt, $datascad, $pagamento, $iban, $totalefatt, $tipo)
    {
        $query="SELECT numero FROM fatture WHERE id_azienda = '$idazienda' ORDER BY numero DESC";
        $querynumero = $this->db->query($query);
        if($querynumero->num_rows() == 0){
            $numerofattura = 1;
        }else{
            $querynumero = $querynumero->row();
            $numerofattura = $querynumero->numero + 1;
        }

        $anno = date('Y');
        $this->db->query("INSERT INTO fatture (id_fattura, id_azienda, id_cliente, numero, anno, data_creazione, data_scadenza, tipo, pagamento, iban, totaleii, rag_soc, indirizzo, citta, prov, piva, stato)
                          VALUES('','$idazienda', '$cliente->id','$numerofattura','$anno','$datafatt','$datascad','$tipo', '$pagamento','$iban','$totalefatt','$cliente->rag_soc','$cliente->indirizzo','$cliente->citta','$cliente->prov','$cliente->piva','A')");
        return $this->db->insert_id(); //last insert id
    }

    public function modFattura($idfattura, $datafatt, $datascad, $pagamento, $iban, $totalefatt, $tipo)
    {
        $this->db->query("UPDATE fatture SET data_creazione = '$datafatt', data_scadenza = '$datascad', pagamento = '$pagamento', iban = '$iban', totaleii = '$totalefatt', tipo = '$tipo' WHERE id_fattura = '$idfattura'");
        return;
    }

    public function insFatturaItem($descrizione, $qnt, $prezzo, $iva, $totitem, $idfattura)
    {
        $dataeora = date('Y-m-d H:i:s');
        $this->db->query("INSERT INTO item_fatture (id_item, data, descrizione, qnt, prezzo, iva, tot_item, id_fattura)
                          VALUES('','$dataeora','$descrizione','$qnt','$prezzo','$iva','$totitem','$idfattura')");
        return true;
    }

    public function getFattura($idfattura){
        $query = $this->db->query("SELECT * FROM fatture WHERE id_fattura = '$idfattura'");
        return $query->row();
    }

    public function getFatture(){
        $idazienda = $_SESSION['id_azienda'];
        $query = $this->db->query("SELECT * FROM fatture WHERE id_azienda = '$idazienda'");
        return $query->result();
    }

    public function getFattAvuti($fatture){
      //soldi avuti dai clienti per la fattura i
        $avere = array();
        for ($i = 0; $i < count($fatture); $i++) {
            $idfatt = $fatture[$i]->id_fattura;
            $query = $this->db->query("SELECT COALESCE(SUM(valoreii),0) AS avuti FROM acconti WHERE id_fattura = '$idfatt'");
            $avere[$i] = $query->result();
        }
        return $avere;
    }

    public function getIdfattAvuto($idfattura){
        $query = $this->db->query("SELECT COALESCE(SUM(valoreii),0) AS avuti FROM acconti WHERE id_fattura = '$idfattura'");
        $avere = $query->row();
        return $avere->avuti;
    }

    public function getItemFattura($idfattura){
        $query = $this->db->query("SELECT * FROM item_fatture WHERE id_fattura = '$idfattura'");
        return $query->result();
    }

    public function deleteItemFatt($idfattura){
        $this->db->query("DELETE FROM item_fatture WHERE id_fattura = '$idfattura'");
        return true;
    }

    public function getIban($idazienda) {
        $query = $this->db->query("SELECT * FROM iban LEFT JOIN aziende ON aziende.id_azienda=iban.id_azienda WHERE iban.id_azienda = '$idazienda'");
        if ($query->num_rows() >= 1) {
            return $query->result();
        }else{
            return 0;
        }
    } // fine getIban

    public function chiudiFatt($idfatt){
        $this->db->query("UPDATE fatture SET stato = 'C' WHERE id_fattura = '$idfatt'");
        return 1;
    }

    public function clona($idfattura){
        $query = $this->db->query("SELECT * FROM fatture WHERE id_fattura = '$idfattura'");
        $fattura = $query->row();//fattura da clonare

        $query = $this->db->query("SELECT * FROM item_fatture WHERE id_fattura = '$idfattura'");
        $itemfattura = $query->result();//item fattura da clonare
        $idazienda = $_SESSION['id_azienda'];

        $query = $this->db->query("SELECT numero FROM fatture WHERE id_azienda = '$idazienda' ORDER BY numero DESC LIMIT 1");
        $numero = $query->row()->numero + 1;//ultimo numero fatture incrementato

        $this->db->query("INSERT INTO fatture VALUES('','$idazienda','$fattura->id_cliente','$numero','$fattura->anno','$fattura->data_creazione','$fattura->data_scadenza','$fattura->tipo',
                        '$fattura->totaleii','$fattura->rag_soc','$fattura->indirizzo','$fattura->citta','$fattura->prov','$fattura->piva','$fattura->pagamento','$fattura->iban',
                        'A','$fattura->note','$fattura->note_private')");

        $idfattura = $this->db->query("SELECT id_fattura FROM fatture WHERE id_azienda = '$idazienda' ORDER BY numero DESC LIMIT 1")->row()->id_fattura;

        foreach($itemfattura as $row){
            $this->db->query("INSERT INTO item_fatture VALUES('','$row->data','$row->descrizione','$row->qnt','$row->prezzo','$row->iva','$row->tot_item','$idfattura')");
        }
        return 1;
    }


    /*** GESTIONE SALDO INSOLUTI **************************************************/

        public function saldoInsoluti($id_cliente=0){
          // Saldo insoluti di tutta l'azienda o di un cliente ad esso associato
          $id_azienda = $_SESSION['id_azienda'];
          // Creo il dataset con le info da elaborare
          $this->db->where('id_azienda', $id_azienda);
          if(!$id_cliente=="0"){
            $this->db->where('id_cliente', $id_cliente);
          }
          $this->db->where('stato', 'A');
          $fatture = $this->db->get('fatture');
          $saldo=0;
          //$avere = array();
          foreach ($fatture->result() as $row){
            $idfatt = $row->id_fattura;
            $query = $this->db->query("SELECT COALESCE(SUM(valoreii),0) AS avuti FROM acconti WHERE id_fattura = '$idfatt'");
            //$query_tot = $this->db->query("SELECT COALESCE(SUM(valoreii),0) AS avuti FROM acconti WHERE id_fattura = '$idfatt'");
            foreach ($query->result_array() as $raw) {
                    $saldo+=$raw['avuti'];
            }
          }
          return $this->totaleFattureInsolute($id_cliente)-$saldo;
        } // fine getFattAvuti

        function totaleFattureInsolute($id_cliente=0){
          // Saldo di tutte le fatture attualmente aperte (insolute) dell'azienda o di un cliente ad esso associato
          $id_azienda = $_SESSION['id_azienda'];
          // Seleziono l'azienda
          $this->db->where('id_azienda', $id_azienda);
          // Filtro solo quelle con lo stato A - Aperte
          $this->db->where('stato', 'A');
          // Se necessario filtro tutte quelle di un dato cliente
          if(!$id_cliente=="0"){
            $this->db->where('id_cliente', $id_cliente);
          }
          // Sommo il totale dei valori contenuti nel campo totaleii
          $this->db->select_sum('totaleii');
          // Eseguo la Query
          $data = $this->db->get('fatture');
          // Estraggo il dataset
          $dataset=$data->row_array();
          //$totii=0;
          // Restituisco il totale calcolato
          return $dataset['totaleii'];
        }
    /*** FINE GESTIONE SALDO INSOLUTI ***/

  /** Numero di Fatture Insolute, filtro per Azienda e per Cliente **/
  function numeroFattureInsolute($id_cliente=0){
    $id_azienda= $_SESSION['id_azienda'];
    $this->db->where('id_azienda', $id_azienda);
    // Filtro solo quelle con lo stato A - Aperte
    $this->db->where('stato', 'A');
    // Se necessario filtro tutte quelle di un dato cliente
    if(!$id_cliente=="0"){
      $this->db->where('id_cliente', $id_cliente);
    }
    // select count
    $risultato=$this->db->get('fatture');
    return $risultato->num_rows();
  }// end numeroFattureInsolute




    /** TOTALE ACCONTI PER ID_FATTURA ***
    * Questa Funzione restituisce un valore numerico corrispondente alla somma
    * degli acconti associati ad una generica fattura di cui si conosce l'id_fattura
    ***/
      public function totAccontiFattura($id_fattura=0){
        if(!$id_fattura){
          redirect('/', 'refresh');
        }else{
          // sommo gli acconti
          $this->db->select_sum('valoreii');
          // della fattura $id_fattura
          $this->db->where('id_fattura', $id_fattura);
          // Eseguo la Query
          $data = $this->db->get('acconti');
          $dataset=$data->row_array();
          // Restituisco il totale calcolato
          return $dataset['valoreii'];
        }
      }

    /** ESTRAZIONE DATI FATTURE PER CLIENTE/AZIENDA ***
    * Questa Funzione restituisce un array con gli elementi relativi alle fatture di un
    * determinato cliente. Occorre passare l'id_cliente e si suppone l'id_azienda
    ***/
    public function estraiFatture($id_cliente=0){
      // seleziono i campi che mi interessano
      //$this->db->select('numero','data_creazione','data_scadenza', 'tipo', 'totaleii','rag_soc','stato');
      $anno=$this->session->anno_contabile;
      // filtro per azienda
      $id_azienda = $_SESSION['id_azienda'];
      $this->db->where('id_azienda', $id_azienda);
      $this->db->where("data_creazione BETWEEN '$anno-01-01' AND '$anno-12-31'");
      // se presente, filtro per id_cliente
      if($id_cliente){
        $this->db->where('id_cliente', $id_cliente);
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

}
