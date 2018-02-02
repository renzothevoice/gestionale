<?php
/* Pagina che consente di visualizzare gli item di un preventivo */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="tabelleDT">
  <h5> INTESTAZIONE PREVENTIVO </h5>
  Numero: <?php echo $data['intestazione']['id_preventivo'];?><br/>
  Data:
  <?php $data_creazione = new DateTime($data['intestazione']['data_creazione']);
  echo $data_creazione->format('d/m/Y');?> <br/>
  Oggetto: <?php echo $data['intestazione']['oggetto'];?><br/>
  Validità:  <?php echo $data['intestazione']['validita'];?><br/>
  Note:  <?php echo $data['intestazione']['note_preventivo'];?><br/>
  Modalità di Pagamento:  <?php echo $data['intestazione']['modalita_pagamento'];?><br/>
  <a href="<?php echo base_url();?>preventivi/elenco/edit/<?php echo $data['intestazione']['id_preventivo'];?>">MODIFICA</a>
</div>
<!-- JQuery -->
<script src="<?php echo base_url(); ?>assets/jquery/jquery.form.js"></script>
<hr/>
<script lang="javascript">
$(document).ready(function() {
    $('#items_preventivo').DataTable( {
        "language": {
            "lengthMenu": "Mostra _MENU_ voci per pagina  ",
            "zeroRecords": "Non ci sono voci caricate.",
            "info": "Sei nella pagina _PAGE_ di _PAGES_",
            "infoEmpty": "Nessuna voce.",
            "infoFiltered": "(filtrato tra _MAX_ voci totali)",
            "search": "Cerca: "
        }
    } );
} );
</script>

<div class="riquadro_bianco">
<table id="items_preventivo" class="table table-striped table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Tipologia</th>
                <th>Descrizione</th>
                <th>Qnt</th>
                <th>Prezzo</th>
                <th>Sconto</th>
                <th>IVA</th>
                <th>Sub Totale IE</th>
                <th>Sub Totale II</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tfoot>
          <tr>
              <th>Tipologia</th>
              <th>Descrizione</th>
              <th>Qnt</th>
              <th>Prezzo</th>
              <th>Sconto</th>
              <th>IVA</th>
              <th>Sub Totale IE</th>
              <th>Sub Totale II</th>
              <th>Azioni</th>
          </tr>
        </tfoot>
        <tbody>
<?php
/* Istanzio variabil per i conteggi */
$totale_ie=0;
$totale_ii=0;
$imposta=0;
foreach ($data['items']->result() as $row){
 ?>
            <tr>
                <td><?php echo $row->tipologia; ?></td>
                <td><?php echo $row->descrizione; ?></td>
                <td><?php echo $row->qnt; ?></td>
                <td><b><?php echo money_format('%.2n', $row->prezzo); ?></b></td>
                <td><?php
                if($row->sconto){
                    echo $row->sconto."%";
                }else{
                  echo " - ";
                }
                ?>  </td>
                <td><?php echo $row->iva; ?>%</td>
                <td><?php
                  $subtotale_ie=$row->qnt*($row->prezzo - (($row->prezzo/100)*$row->sconto));
                  echo money_format('%.2n',$subtotale_ie);
                  $totale_ie+=$subtotale_ie;
                ?>
                </td>
                <td><?php
                $subtotale_ii=$subtotale_ie + (($subtotale_ie/100)*$row->iva);
                echo money_format('%.2n',$subtotale_ii);
                $totale_ii+=$subtotale_ii;
                ?> </td>
                <!-- pulsanti azioni -->
                <td>
                  <a href="<?php echo base_url();?>preventivi/edit_item/<?php echo $row->id_item_preventivo; ?>"><span class="glyphicon glyphicon-edit" data-toggle="tooltip" data-placement="top" title="Modifica"></span></a> |
                  <a href="<?php echo base_url();?>preventivi/clona_item/<?php echo $row->id_item_preventivo; ?>"><i class="fa fa-clone" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Clona Voce"></i></a> |
                  <a href="<?php echo base_url();?>preventivi/elimina_item/<?php echo $row->id_item_preventivo; ?>"><span class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="top" title="Cancella"></span></a>
                </td>
            </tr>
<?php } ?>
        </tbody>
    </table>
    <table>
      <tr>
        <td>Totale Iva Esclusa: </td>
        <td>€ <?php echo money_format('%.2n',$totale_ie); ?>
      </tr>
      <tr>
        <td>Totale Imposta: </td>
        <td>€ <?php echo money_format('%.2n',$totale_ii-$totale_ie); ?>
      </tr>
      <tr>
        <td>Totale Iva Inclusa: </td>
        <td>€ <?php echo money_format('%.2n',$totale_ii); ?>
</td>
      </tr>
    </table>
</div>
