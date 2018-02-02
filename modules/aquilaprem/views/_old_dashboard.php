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
        $adesso=new DateTime("now");
        $scadenza = new DateTime($row['scadenza']);
        $interval = $adesso->diff($scadenza);
        $giorni_mancanti=$interval->format("%d");

        if($giorni_mancanti>101){
          $barra="100";
        }else{
          $barra=$giorni_mancanti;
        }
        // Intercetto eventi scaduti e li rendo opachi e cambio il badge
        if($giorni_mancanti<1){
          $disabilita="disabilita";
          $badge="<b>SCADUTO!</b>";
          $badge_style="badge_scaduto";
        }else{
          $disabilita="";
          $badge="Mancano <b>".$giorni_mancanti." Giorni</b>";
          $badge_style="badge_attivo";
        }
      ?>
      <div class="row <?php echo $disabilita; ?>">
        <div class="col-sm-1">
          <div class="btn-group-vertical" role="group" aria-label="">
           <a href="#"><button type="button" class="btn btn-success">CHIUDI</button></a>
           <a href="#"><button type="button" class="btn btn-danger">ANNULLA</button></a>
         </div>
        </div>
        <div class="col-sm-11">
          <li class="list-group-item task_element">
            <!-- Data Scadenza -->
            <span class="scadenza">  <?php echo "[".$row['scadenza']."]";?></span>
            <!-- Badge Giorni Mancanti -->
            <span class="badge <?php echo $badge_style;?>"><?php echo $badge;?></span>
            <!-- Categoria -->
            <span class="categoria" style="background-color:<?php echo $row['colore'];?>">
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
