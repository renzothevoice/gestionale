<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_eventi extends CI_Model {


/*Leggo i dati degli eventi dal DB */
	Public function getEvents($id_cliente=1){
		// Imposto l'azienda di riferimento
		$id_azienda=$this->session->id_azienda;
		// Inizio a creare la query
	  $sql = "SELECT * FROM eventi"; // WHERE eventi.inizio";
		// Aggiungo il limite per l'azienda
		$sql.=" WHERE eventi.id_azienda=$id_azienda ";
		// Aggiungo l'eventuale limite per il cliente selezionato
		$sql.=" AND eventi.id_cliente=$id_cliente ";
		$sql.="AND eventi.inizio BETWEEN ? AND ? ORDER BY eventi.inizio ASC";
  	return $this->db->query($sql, array($_GET['start'], $_GET['end']))->result();
	}

/* Creo un nuovo evento */
	Public function addEvent(){
  // Imposto l'azienda di riferimento
	$id_azienda=$this->session->id_azienda;
	// Costruisco l'array contentente i campi _POST: titolo, inizio, fine, descrizione, colore, url
	$dati_evento = array(
		'id_azienda' => $id_azienda,
		'id_cliente' => $_POST['id_cliente'],
		'titolo' => $_POST['titolo'],
    'inizio' => $_POST['inizio'],
		'fine' => $_POST['fine'],
		'descrizione' => $_POST['descrizione'],
		'colore' => $_POST['colore'],
		'url' => $_POST['url']
	);

	$this->db->insert('eventi', $dati_evento);
	return ($this->db->affected_rows()!=1)?false:true;

	/* Imposto la query
	$sql = "INSERT INTO eventi (id_cliente, id_azienda, title,events.date, description, color) VALUES ";
	$sql.="(?,?,?,?)";
	$this->db->query($sql, array($_POST['title'], $_POST['date'], $_POST['description'], $_POST['color']));
		return ($this->db->affected_rows()!=1)?false:true;
		*/
	}

	/*Update  event */

	Public function updateEvent()
	{

	$sql = "UPDATE events SET title = ?, events.date = ?, description = ?, color = ? WHERE id = ?";
	$this->db->query($sql, array($_POST['title'], $_POST['date'], $_POST['description'], $_POST['color'], $_POST['id']));
		return ($this->db->affected_rows()!=1)?false:true;
	}


	/*Delete event */

	Public function deleteEvent()
	{

	$sql = "DELETE FROM events WHERE id = ?";
	$this->db->query($sql, array($_GET['id']));
		return ($this->db->affected_rows()!=1)?false:true;
	}

	/*Update  event */

	Public function dragUpdateEvent()
	{
			$date=date('Y-m-d h:i:s',strtotime($_POST['date']));

			$sql = "UPDATE events SET  events.date = ? WHERE id = ?";
			$this->db->query($sql, array($date, $_POST['id']));
		return ($this->db->affected_rows()!=1)?false:true;


	}






}
