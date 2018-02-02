<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- tooltip JQuery -->
<script>
    $(document).ready(function () {
        $('#fatture').DataTable({
            "paging": false,
            "ordering": true,
            "info": false,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": true,
            "order": [[ 1, "desc" ]]
        });
    });

    $(function () {
        $(document).tooltip();
    });
</script>
<!-- Fine tooltip-->
<div class="griglia">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Elenco fatture</h3>
                    <div class="box box-solid box-default">
                        <div class="box-header">
                            <h3 class="box-title" title="Visualizza TUTTE le fatture emesse."><a href="fatture"><i
                                        class="fa fa-bars" aria-hidden="false"></i>Fatture Emesse</a></h3>
                        </div>
                        <table class="table table-responsive" id="fatture">
                            <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Data fattura</th>
                                <th>Data Scadenza</th>
                                <th>Cliente</th>
                                <th>Importo da avere</th>
                                <th>Importo mancante</th>
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
                                        <?php echo $row->numero; ?>
                                    </td>
                                    <td>
                                        <?php $date = new DateTime($row->data_creazione);
                                        echo $date->format('d/m/y'); ?>
                                    </td>
                                    <td>
                                        <?php $date = new DateTime($row->data_scadenza);
                                        echo $date->format('d/m/y'); ?>
                                    </td>
                                    <td>
                                        <?php echo $row->rag_soc; ?>
                                    </td>
                                    <td>
                                        <?php echo number_format($row->totaleii, 2, ',', ' ') . " €"; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $tot = number_format(($row->totaleii - $avuti[$i][0]->avuti), 2, ',', ' ');
                                        if ($tot <= 0){
                                            //chiudere fattura
                                            echo "0.00 €";
                                        }else{
                                            echo $tot." €";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $row->stato; ?>
                                    </td>
                                    <td>
                                        <a href="fatture/duplica/<?php echo $row->id_fattura; ?>">
                                            <i class="glyphicon glyphicon-file" title="Duplica"></i>
                                        </a>&nbsp;
                                        <a href="fatture/visualizza/<?php echo $row->id_fattura; ?>">
                                            <i class="glyphicon glyphicon-eye-open" title="Visualizza"></i>
                                        </a>&nbsp;
                                        <a href="fatture/modifica/<?php echo $row->id_fattura; ?>">
                                            <i class="fa fa-cogs" aria-hidden="true" title="Modifica"></i>
                                        </a>&nbsp;
                                        <a href="rapporti/fattura_pdf/<?php echo $row->id_fattura; ?>">
                                            <i class="fa fa-file-pdf-o" aria-hidden="true" title="Genera PDF"></i>
                                        </a>&nbsp;
                                    </td>
                                </tr>
                            <?php $i++;} ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Fine Box Tabella Fatture Emesse -->
                </div>
        </div>
    </div>
</div>
