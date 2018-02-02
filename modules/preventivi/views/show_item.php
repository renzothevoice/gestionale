<?php
  /* Modifica una voce in preventivo */
  foreach ($item_preventivo as $item):
?>
<div class="tabelleDT">
  <h5>MODIFICA NUOVA VOCE PREVENTIVO</h5>
  <?php echo form_open('preventivi/edit_item/'.$item->id_item_preventivo); ?>
      <label for="title">Tipologia</label><br />
      <?php
      $tipologia = array(
              'SERVIZIO'         => 'SERVIZIO',
              'HARDWARE'           => 'HARDWARE',
              'TRASPORTO'         => 'TRASPORTO',
              'ALTRO'        => 'ALTRO',
      );
      $iva = array(
              '22'        => '22%',
              '10'        => '10%',
              '0'         => 'I.E.',
      );
      $unita_misura = array(
              'pz'        => 'pezzi',
              'kg'        => 'kilogrammi',
              'mt'         => 'metri',
              'n.a.'    => 'N.A.'
      );
      echo form_dropdown('tipologia', $tipologia, set_value('tipologia'));
      ?>
      <br />

      <label for="text">Descrizione</label><br />
      <textarea name="descrizione"><?php echo set_value('descrizione'); echo $item->descrizione;?></textarea><br />

      <label for="text">Quantità</label><br />
      <input type="input" name="qnt" value="<?php echo set_value('qnt'); echo $item->qnt;?>" /><br />

      <label for="text">Unità di misura</label><br />
      <?php echo form_dropdown('unita_misura', $unita_misura, set_value('unita_misura')); ?><br />

      <label for="text">Prezzo</label><br />
      <input type="input" name="prezzo" value="<?php echo set_value('prezzo'); echo $item->prezzo;?>" /><br />

      <label for="text">IVA</label><br />
      <?php echo form_dropdown('iva', $iva, set_value('iva')); ?><br />

      <label for="text">Sconto</label><br />
      <input type="input" name="sconto" value="<?php echo set_value('sconto'); echo $item->sconto;?>" /><br />

      <label for="text">Note</label><br />
      <textarea name="note_item_preventivo" ><?php echo set_value('note_item_preventivo'); echo $item->note_item_preventivo;?></textarea><br />

      <input type="submit" name="submit" value="Inserisci Voce" />
      <input type="hidden" name="id_item_preventivo" value="<?php echo set_value('id_item_preventivo'); echo $item->id_item_preventivo;?>" />
      <?php   echo validation_errors();  ?>
  </form>
</div>
<?php
   endforeach;
   echo validation_errors();
?>
