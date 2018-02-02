<?php /***** MENU SECONDARIO SELEZIONA *****/ ?>
<div class="container">
  <nav class="breadcrumb">
    <span class="breadcrumb-item"><i class="glyphicon glyphicon-equalizer" aria-hidden="true"></i> <b>DETTAGLIO PREVENTIVO:</b></span>
    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <a href="<?php echo base_url();?>preventivi/inserisci_item">INSERISCI VOCE</a> | <i class="fa fa-clone" aria-hidden="true"></i> <a href="<?php echo base_url();?>preventivi/duplica_preventivo/<?php echo $this->uri->segment(3); ?>">CLONA</a>
  </nav>
</div>
