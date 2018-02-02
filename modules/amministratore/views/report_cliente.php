<div class="row">
           <!-- prima colonna -->
       <div class="col-md-4">
         <!-- Box Report Cliente -->
         <div class="box box-widget widget-user-2">
           <div class="widget-user-header palette_2">
              <div class="logo-cliente"><?php echo substr($cliente[0]->rag_soc, 0, 1); ?></div>
             <h3 class="widget-user-username"><?php echo $cliente[0]->rag_soc; ?></h3>
             <h5 class="widget-user-desc">PIVA <?php echo $cliente[0]->piva; ?></h5>
           </div>
           <div class="box-footer no-padding">
             <ul class="nav nav-stacked">
               <li><a href="#">Numero Fatture Aperte: <span class="pull-right badge bg-blue"><?php echo $numero_fatture_insolute; ?></span></a></li>
               <li><a href="#">Totale Insoluti: <span class="pull-right badge bg-aqua"><?php echo money_format('%.2n', $saldo_insoluti) . "\n";?></span></a>
               </li>
               <li><a href="#" class="btn btn-app"><i class="fa fa-edit"></i> Gestisci Solleciti</a></li>
               <li><a href="#" class="btn btn-app"><i class="fa fa-money"></i> Registra Pagamento</a></li>
             </ul>
           </div>
         </div>
       </div>
         <!-- fine Box Cliente -->
       <!-- seconda colonna -->
       <div class="col-md-8">
       <!-- Box Tabella Fatture Emesse -->
       <div class="box box-solid box-default">
         <div class="box-header">
           <h3 class="box-title"><i class="fa fa-bars" aria-hidden="false"></i> Fatture Emesse anno <?php echo $this->session->anno_contabile; ?></h3>
         </div>
         <div class="box-body elenco">
           <table class="table table-responsive" id="dtfatture">
               <thead>
               <tr>
                   <th>Numero</th>
                   <th>Data fattura</th>
                   <th>Data Scadenza</th>
                   <th>Cliente</th>
                   <th>Totale Fattura</th>
                   <th>Saldo Avere</th>
                   <th>Stato</th>
                   <th>AZIONI</th>
               </tr>
               </thead>
               <tbody>
               <?php
               $i=0;
               foreach ($fatture as $row) { ?>
                   <tr>
                       <td>
                           <?php echo $row['numero']; ?>
                       </td>
                       <td>
                           <?php $date = new DateTime($row['data_creazione']);
                           echo $date->format('d/m/y'); ?>
                       </td>
                       <td>
                           <?php $date = new DateTime($row['data_scadenza']);
                           echo $date->format('d/m/y'); ?>
                       </td>
                       <td>
                           <?php echo $row['rag_soc']; ?>
                       </td>
                       <td>
                           <?php echo money_format('%.2n', $row['totaleii']) . " €"; ?>
                       </td>
                       <td>
                           <?php
                           // importo mancante
                           if ($row['stato'] == "C"){
                               echo "FATTURA SALDATA";
                           }else{
                               echo money_format('%.2n', $row['totaleii']-$row['acconti']);
                           } ?>
                       </td>
                       <td>
                           <?php echo $row['stato']; ?>
                       </td>
                       <td>
                           <a href="<?php echo base_url();?>fatture/duplica/<?php echo $row['id_fattura']; ?>">
                               <i class="fa fa-clone" title="Duplica"></i>
                           </a>&nbsp;
                           <a href="<?php echo base_url();?>fatture/modifica/<?php echo $row['id_fattura']; ?>">
                               <i class="fa fa-cogs" aria-hidden="true" title="Modifica"></i>
                           </a>&nbsp;
                           <a href="<?php echo base_url();?>rapporti/fattura_pdf/<?php echo $row['id_fattura']; ?>">
                               <i class="fa fa-file-pdf-o" aria-hidden="true" title="Genera PDF"></i>
                           </a>&nbsp;
                       </td>
                   </tr>
               <?php $i++;} ?>
               </tbody>
           </table>
         </div>
         </div>
       <!-- Fine Box Tabella Fatture Emesse -->
       <?php /*
       <div id='calendar'></div>
       */ ?>
       </div>

  </div> <!-- fine row -->
