<?php
/* dashboard dedicata ai clienti AQP */
?>
</head>
<body>
  <div class="container">
  <div class="row">
    <div class="col-md-8" style="">
      <!-- Box Lista Prossime Scadenze -->
      <ul class="list-group">
      <?php
      $i=0;
      foreach ($tasks as $row) {
        // Determino i giorni mancanti
        $adesso=new DateTime("now");
        $scadenza = new DateTime($row['scadenza']);
        $interval = $adesso->diff($scadenza, FALSE);
        $giorni_mancanti=(int)$interval->format("%r%a");
        // Definisco lo stile in funzione dello stato
        switch ($row['stato']){
          case 'CHIUSO':
            $task_style="task_chiuso";
            $badge="<b>CHIUSO!</b>";
            $badge_style="badge_chiuso";
            $barra="100";
          break;
          case 'ANNULLATO':
            $badge="<b>ANNULLATO!</b>";
            $badge_style="badge_annullato";
            $task_style="task_annullato";
            $barra="100";
          break;
          default:
            if($giorni_mancanti>101){
              $barra="100";
            }else{
              $barra=$giorni_mancanti;
            }
            if($giorni_mancanti<1){
              // Task Scaduto
              $badge="Evento <b>SCADUTO</b>";
              $badge_style="badge_scaduto";
              $task_style="task_scaduto";
            }else{
              // Task Attivo
              $badge="Mancano <b>".$giorni_mancanti." Giorni</b>";
              $badge_style="badge_attivo";
              $barra=$giorni_mancanti;
              $task_style="";
            }
          break;
        }
      ?>
      <div class="row">
        <div class="col-sm-1">
          <div class="btn-group-vertical" role="group" aria-label="">
           <a href="<?php echo base_url();?>tasks/modifica/<?php echo $row['id_task'];?>"><button type="button" class="btn btn-warning"><i class="fa fa-cog" aria-hidden="true"></i></button></a>
       </div>
        </div>
        <div class="col-sm-11  <?php echo $task_style; ?>">
          <li class="list-group-item task_element">
            <!-- Data Scadenza -->
            <span class="scadenza">
              <?php
              $data_mysql = strtotime($row['scadenza']);
              echo strftime("%a %d/%m/%Y", $data_mysql);
              ?>
            </span>
            <!-- Badge Giorni Mancanti -->
            <span class="badge <?php echo $badge_style;?>"><?php echo $badge;?></span>
            <!-- Categoria -->
            <span class="categoria" style="background-color:#<?php echo $row['colore'];?>">
              <?php echo $row['categoria'];?>
            </span>
            <br/>
            <?php echo $row['descrizione']; ?>
            <div class="progress">
              <div class="progress-bar-tasks" role="progressbar" aria-valuenow="<?php echo $barra;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barra."%";?>;">
              </div>
            </div>
          </li>
        </div>
      </div>
      <?php
      }
      ?>
      </ul>
      <!-- Fine Box Lista Prossime Scadenze -->
    </div>
    <!-- fine colonna -->
    <div class="col-md-4">
<!-- Calendario -->
<div id='calendar'></div>
    </div>
  </div>
  <!-- Fine ROW-->
  </div> <!-- fine container-->
