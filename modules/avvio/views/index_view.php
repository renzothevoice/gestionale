<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
</head>
<body id="home">
<div class="container-fluid">
  <div class="alert alert-info" role="alert">
    <p style="text-align: center; font-weight: bold;">BENVENUTO <?php echo strtoupper($this->session->utente_nome);?>, SELEZIONA L'AZIENDA CON CUI OPERARE<br />
    <span style="font-weight: normal;">oppure <a href="<?php echo base_url(); ?>accesso/logout">DISCONNETTITI</a></span></p>
  </div>
<!-- Prima riga aziende -->
<div class="row">
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <div class="caption">
        <h3>Ventuno Srl</h3>
        <p><a href="<?php echo base_url(); ?>avvio/index/1" class="btn btn-primary" role="button">Gestisci</a></p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail thumbnail_1">
      <div class="caption">
        <h3>Ventuno Sas</h3>
<p><a href="<?php echo base_url(); ?>avvio/index/2" class="btn btn-primary" role="button">Gestisci</a></p>      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <div class="caption">
        <h3>Polar Srl</h3>
<p><a href="<?php echo base_url(); ?>avvio/index/3" class="btn btn-primary" role="button">Gestisci</a></p>      </div>
    </div>
  </div>
  <!-- Seconda riga aziende -->
  <div class="row">
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail thumbnail_1">
      <div class="caption">
        <h3>Polven.re Srl</h3>
<p><a href="<?php echo base_url(); ?>avvio/index/4" class="btn btn-primary" role="button">Gestisci</a></p>      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail thumbnail_1">
      <div class="caption">
        <h3>S.A.C. Srl</h3>
<p><a href="<?php echo base_url(); ?>avvio/index/5" class="btn btn-primary" role="button">Gestisci</a></p>      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <div class="caption">
        <h3>VUOTO</h3>
<p><a href="<?php echo base_url(); ?>avvio/index/6" class="btn btn-primary" role="button">Gestisci</a></p>      </div>
    </div>
  </div>
</div>
<!-- fine seconda riga aziende -->
</div>
