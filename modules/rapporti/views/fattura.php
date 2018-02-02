<?php
setlocale(LC_ALL, 'it_IT.UTF-8');
$subTotaleII=0;
$subTotaleImposta=0;
$subTotaleIE=0;
?>
<body>
<div id="container">
  <div id="testa"><img src="<?php echo base_url("assets/img/aziende/".$dati_azienda[0]->url_logo."") ;?>" ></div>
<h4>FATTURA</h4>
  <!-- INTESTAZIONE -->
  <p> Numero <b><?php echo $testa_fattura[0]->numero; ?></b> del <?php echo date('d/m/Y', strtotime($testa_fattura[0]->data_creazione)); ?> | Scadenza: <?php echo date('d/m/Y', strtotime($testa_fattura[0]->data_scadenza)); ?></br>
</p>
  <div id="left">
    <!-- DATI AZIENDA -->
    <p><b>AZIENDA:</b><br/>
    <?php echo $dati_azienda[0]->rag_soc; ?><br/>
    <?php echo $dati_azienda[0]->indirizzo; ?><br/>
    <?php echo $dati_azienda[0]->citta; ?> (<?php echo $dati_azienda[0]->prov; ?>)<br/>
    PIVA: <?php echo $dati_azienda[0]->piva; ?><br/></p>
  </div>
  <div id="right">
    <!-- DATI CLIENTE -->
    <p><b>CLIENTE:</b><br/>
    <?php echo $testa_fattura[0]->rag_soc; ?><br/>
    <?php echo $testa_fattura[0]->indirizzo; ?><br/>
    <?php echo $testa_fattura[0]->citta; ?> (<?php echo $testa_fattura[0]->prov; ?>)<br/>
    PIVA: <?php echo $testa_fattura[0]->piva; ?><br/></p>
  </div>
  <br/>
</div>
  <!-- CORPO -->
<table width="100%">
    <thead>
      <tr style="background-color: grey;">
        <td style="color: white;">DESCRIZIONE</td>
        <td style="color: white; text-align: center;">QNT</td>
        <td style="color: white; text-align: center;">PREZZO IE</td>
        <td style="color: white; text-align: center;">IVA</td>
        <td style="color: white; text-align: center;">SubTOT II</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($corpo_fattura->result() as $value) { ?>
      <tr>
        <td><?php echo $value->descrizione;?></td>
        <td style="text-align: center;"><?php echo $value->qnt;?></td>
        <td style="text-align: right;"><?php echo  money_format('%.2n', $value->prezzo);?></td>
        <td style="text-align: center;"><?php echo $value->iva;?>%</td>
        <td style="text-align: right;"><?php echo  money_format('%.2n', $value->tot_item);?></td>
      </tr>
      <?php
      $subTotaleII+=$value->tot_item;
      $subTotaleIE+=$value->prezzo*$value->qnt;
      $subTotaleImposta=$subTotaleII-$subTotaleIE;
      }
      ?>
    </tbody>
  </table>
<br/><br/>
    <div colspan="4" style="border-top: 2px solid grey; text-align: right; color: black;">TOTALE IVA ESCLUSA: <?php echo money_format('%.2n',$subTotaleIE); ?></div>
    <div colspan="4" style="text-align: right; color: black;">TOTALE IMPOSTA: <?php echo money_format('%.2n',$subTotaleImposta); ?></div>
    <div colspan="4" style="border-bottom: 2px solid grey; text-align: right; color: black;"><b>TOTALE IVA INCLUSA: <?php echo money_format('%.2n',$subTotaleII); ?></b></div>

<div id="piedone1">Modalità di pagamento: <?php echo $testa_fattura[0]->pagamento;?> - Coordinate Bancarie: <?php echo $testa_fattura[0]->iban;?></div>
<div id="piedone2">NOTE: <?php echo $testa_fattura[0]->note;?></div>
