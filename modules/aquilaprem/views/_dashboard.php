<?php
/* dashboard dedicata ai clienti AQP */
?>
</head>
<body>
  <div class="container">
  <div class="row">
    <div class="col-md-8" style="">
      <!-- Box Lista Prossime Scadenze -->
      <?php
      $i=0;
      foreach ($tasks as $row) {
      ?>
      <div class="panel panel-default">
        <div class="panel-body task_element">
          <?php echo "[".$row['scadenza']."] ".$row['categoria'].$row['descrizione']; ?>
          <br/>
          <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
              60%
            </div>
          </div>
        </div>
      </div>
      <?php
}
      ?>
      <div class="well well-sm">
        <div class="panel-body">
          Basic panel example<br/>
          <div class="progress">
            <div class="progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
              60%
            </div>
          </div>
        </div>
      </div>


      <ul class="list-group">
        <li class="list-group-item">
          <span class="badge">14</span>
          Cras justo odio
        </li>
        <li class="list-group-item">
          <span class="badge">14</span>
          Cras justo odio
        </li>
        <li class="list-group-item">
          <span class="badge">14</span>
          Cras justo odio
          <div class="progress">
            <div class="progress-bar magenta" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
              60%
            </div>
          </div>
        </li>
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
