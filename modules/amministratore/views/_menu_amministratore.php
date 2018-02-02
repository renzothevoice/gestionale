<?php /***** TEMPLATE MENU TOP *****/ ?>
</head>
<body id="home">
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url();?>avvio/index/<?php echo $this->session->id_azienda; ?>"><?php echo $this->session->rag_soc_azienda; ?></a>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?php echo base_url();?>amministratore"><i class="glyphicon glyphicon-home"></i><span class="sr-only">(current)</span></a></li>
      </ul>



  <ul class="nav navbar-nav navbar-left">
  <!-- Inizio codice Menu ToDo -->
  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-list-alt"></i> TODO <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li><a href="<?php echo base_url();?>todo/nuovo"><i class="fa fa-file-text"></i> Nuovo Task</a></li>
      <li><a href="<?php echo base_url();?>todo"><i class="glyphicon glyphicon-folder-open"></i> Elenco Completo</a></li>
    </ul>
  </li>

  <!-- Menu Acconti -->
  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-import"></i> Acconti <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li><a href="<?php echo base_url();?>fatture/acconti/nuovo"><i class="glyphicon glyphicon-plus-sign"></i> Nuovo Acconto</a></li>
      <li><a href="<?php echo base_url();?>fatture/acconti/elenco"><i class="glyphicon glyphicon-indent-left"></i> Elenco Acconti</a></li>
    </ul>
  </li>

  <!-- Menu Anagrafiche -->
  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-import"></i> Acconti <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li><a href="<?php echo base_url();?>fatture/acconti/nuovo"><i class="glyphicon glyphicon-plus-sign"></i> Nuovo Acconto</a></li>
      <li><a href="<?php echo base_url();?>fatture/acconti/elenco"><i class="glyphicon glyphicon-indent-left"></i> Elenco Acconti</a></li>
    </ul>
  </li>
  </ul>

  </ul>
  <!-- Inizio codice lato destro della navbar -->
        <ul class="nav navbar-nav navbar-right">
          <!-- Inizio codice Menu Utilità -->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-cog"></i> Utilità <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?php echo base_url();?>clienti"><i class="glyphicon glyphicon-user"></i> Gestione Clienti</a></li>
              <?php /*<li><a href="eventi"><i class="glyphicon glyphicon-home"></i> Gestione Eventi</a></li>*/ ?>
              <li><a href="<?php echo base_url();?>todo"><i class="glyphicon glyphicon-flash"></i> Gestione SEGNALAZIONI</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo base_url();?>fatture/gestisci_iban"><i class="fa fa-cc-diners-club"></i> Gestione IBAN</a></li>
              <li><a href="<?php echo base_url();?>aziende"><i class="fa fa-university"></i> Anagrafica AZIENDE</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="<?php echo base_url();?>accesso/elenco"><i class="fa fa-comments"></i> Gestione Accessi</a></li>
              <li><a href="<?php echo base_url();?>avvio/backup_db"><i class="glyphicon glyphicon-floppy-save"></i> Backup Database</a></li>
            </ul>
          </li>
          <!-- Codice Aiuto -->
          <li class=""><a href="#help_modal" data-toggle="collapse" data-target="#aiuto" rel="modal:open"><i class="glyphicon glyphicon-question-sign"></i></a></li>

          <!-- Inizio Codice Gestione Account Utente -->
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url();?>assets/images/user160x160.png" class="user-image" alt="User Image">
                  <span class="hidden-xs"> <?php echo $this->session->utente_nome." ".$this->session->utente_cognome;?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <?php
                    // Controllo l'esitenza della foto del profilo
                    $fotografia = "./assets/img/utenti/".$this->session->utente_id."_utente.jpg";
                    // Se presente la visualizzo, altrimenti metto una default
                    if (file_exists($fotografia)) {
                      $foto_url=base_url()."assets/img/utenti/".$this->session->utente_id."_utente.jpg";;
                    } else {
                      $foto_url=base_url()."assets/img/utenti/utente_default.jpg";
                    }
                    echo '<img src="'.$foto_url.'" alt="Foto Utente" width="160px" class="img-circle" alt="User Image"/>';
                    ?>
                    <p class="nomeutente">
                       <?php echo $this->session->utente_nome." ".$this->session->utente_cognome;?>
                      <small><?php echo $this->session->utente_email;?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo base_url();?>accesso/elenco" class="btn btn-default btn-flat"><i class="fa fa-users" aria-hidden="true"></i> Gestione Account</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url();?>accesso/logout" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-off"></i> Logout</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          <!-- fine codice utente -->
        </ul>
      </div>
    </div>
  </nav>
  <!-- div di aiuto -->
  <div id="help_modal" style="display:none;">
  <p class="help"><span class="titolo"><?php if(isset($aiuto_titolo)){echo $aiuto_titolo;}else{echo "ERRORE!";} ?>:</span> <?php if(isset($aiuto_msg)){echo $aiuto_msg;}else{echo "ERRORE!";} ?><br/> <a href="#" rel="modal:close">Clicca per chiudere o premi ESC</a></p>
  </div>
  <!-- fine aiuto -->
