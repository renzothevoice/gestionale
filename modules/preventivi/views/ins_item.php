<?php
  /* Aggiunge un nuovo item preventivo */
?>
<div class="tabelleDT">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="nuovavoce-tab" data-toggle="tab" href="#nuovavoce" role="tab" aria-controls="nuovavoce" aria-selected="true">Nuova Voce</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="archivio-tab" data-toggle="tab" href="#archivio" role="tab" aria-controls="archivio" aria-selected="false">Archivio</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade in active" id="nuovavoce" role="tabpanel" aria-labelledby="nuovavoce-tab">
      <h5>INSERISCI NUOVA VOCE PREVENTIVO</h5>

      <?php echo form_open_multipart('preventivi/inserisci_item'); ?>
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
          <textarea name="descrizione"><?php echo set_value('descrizione'); ?></textarea><br />

          <label for="text">Quantità</label><br />
          <input type="input" name="qnt" value="<?php echo set_value('qnt'); ?>" /><br />

          <label for="text">Unità di misura</label><br />
          <?php echo form_dropdown('unita_misura', $unita_misura, set_value('unita_misura')); ?><br />

          <label for="text">Prezzo</label><br />
          <input type="input" name="prezzo" value="<?php echo set_value('prezzo'); ?>" /><br />

          <label for="text">IVA</label><br />
          <?php echo form_dropdown('iva', $iva, set_value('iva')); ?><br />

          <label for="text">Sconto</label><br />
          <input type="input" name="sconto" value="<?php echo set_value('sconto'); ?>" /><br />

          <label for="text">Note</label><br />
          <textarea name="note_item_preventivo" ><?php echo set_value('note_item_preventivo'); ?></textarea><br />

          <label for="text">Immagine</label><br />
          <input name="immagine" id="immagine" size="30" type="file" class="fileUpload" />

          <input type="submit" name="submit" value="Inserisci Voce" />
          <?php   echo validation_errors();  ?>
          <?php echo $errore;?>
      </form>


    </div>
    <div class="tab-pane fade" id="archivio" role="tabpanel" aria-labelledby="contact-tab">...</div>
  </div>



</div>
