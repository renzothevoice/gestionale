
</head>
<body>
  <div class="container">
  <div class="row">
    <div class="col-md-8">
      <!-- Box Tabella ToDo -->
      <div class="box box-solid box-default">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-bars" aria-hidden="false"></i> ToDo </h3>
        </div>
        <div class="box-body elenco">
          <table class="table table-responsive" id="dttodo">
              <thead>
              <tr>
                  <th>Cliente</th>
                  <th>Apertura</th>
                  <th>Chiusura</th>
                  <th>Desrizione</th>
                  <th>Urgenza - Stato</th>
                  <th>Note</th>
                  <th>AZIONI</th>
              </tr>
              </thead>
              <tbody>
              <?php
              $i=0;
              foreach ($todo as $row) { ?>
                  <tr>
                      <td>
                          <?php echo $row['rag_soc']; ?>
                      </td>
                      <td>
                          <?php $date = new DateTime($row['data_apertura']);
                          echo $date->format('d/m/y'); ?>
                      </td>
                      <td>
                          <?php $date = new DateTime($row['data_chiusura']);
                          echo $date->format('d/m/y'); ?>
                      </td>
                      <td>
                          <?php echo $row['descrizione']; ?>
                      </td>
                      <td>
                          <?php echo $row['urgenza']." // ".$row['stato']; ?>
                      </td>
                      <td>
                        <?php echo $row['note']; ?>
                      </td>
                      <td>
                          <a href="<?php echo base_url();?>fatture/duplica/<?php echo $row['id']; ?>">
                              <i class="fa fa-clone" title="Duplica"></i>
                          </a>&nbsp;
                          <a href="<?php echo base_url();?>fatture/modifica/<?php echo $row['id']; ?>">
                              <i class="fa fa-cogs" aria-hidden="true" title="Modifica"></i>
                          </a>&nbsp;
                          <a href="<?php echo base_url();?>rapporti/fattura_pdf/<?php echo $row['id']; ?>">
                              <i class="fa fa-file-pdf-o" aria-hidden="true" title="Genera PDF"></i>
                          </a>&nbsp;
                      </td>
                  </tr>
              <?php $i++;} ?>
              </tbody>
          </table>
        </div>
        </div>
      <!-- Fine Box ToDo -->
    </div>
    <!-- fine colonna -->
    <div class="col-md-4">
<!-- Calendario -->
<div id='calendar'></div>
    </div>
  </div>
  <!-- Fine ROW-->
  </div> <!-- fine container-->
