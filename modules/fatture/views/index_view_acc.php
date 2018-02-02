?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- tooltip JQuery -->
<script>
    $(document).ready(function () {
        $('#acconti').DataTable({
            "paging": false,
            "ordering": false,
            "info": false,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": true
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
            <div class="col-lg-8">
                <h3>Elenco Acconti <?php echo $tipo_vista; ?></h3>
            </div>
            <div class="col-lg-4">
                <a href="<?php echo base_url();?>acconti/nuovo" class="btn btn-success margintop20 marginbottom20 pull-right">Nuovo acconto</a>
            </div>
            <div class="col-lg-12">
                <div class="box box-solid box-default">
                    <div class="box-header">
                        <h3 class="box-title" title="Visualizza TUTTE le fatture emesse."><a href="fatture">Acconti registrati</a></h3>
                    </div>
                    <table id="acconti" class="table table-responsive">
                        <tr>
                            <th>Numero fattura</th>
                            <th>Vedi fattura</th>
                            <th>Data acconto</th>
                            <th>Cliente</th>
                            <th>Importo dato</th>
                            <th>Note</th>
                            <th>AZIONI</th>
                        </tr>
                        <?php
                        $i=0;
                        foreach ($acconti as $row) { ?>
                            <tr>
                                <td>
                                    <?php echo $row->numerofatt; ?>
                                </td>
                                <td>
                                    <?php echo "<a target='_blank' href='".base_url()."fatture/visualizza/$row->id_fattura'>Link</a>"; ?>
                                </td>
                                <td>
                                    <?php $date = new DateTime($row->data_registrazione);
                                    echo $date->format('d/m/y'); ?>
                                </td>
                                <td>
                                    <?php echo $row->rag_soc; ?>
                                </td>
                                <td>
                                    <?php echo number_format($row->valoreii, 2)." €"; ?>
                                </td>
                                <td>
                                    <?php echo $row->note; ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url();?>fatture/acconti/modifica/<?php echo $row->idacconto; ?>">
                                        <i class="fa fa-cogs" aria-hidden="true" title="Modifica"></i>
                                    </a>&nbsp;
                                        <a onclick="conferma('<?php echo base_url();?>fatture/acconti/elimina/<?php echo $row->idacconto; ?>');" href="#"><i class="fa fa-trash" aria-hidden="true" title="Elimina"></i></a>
                                </td>
                            </tr>
                            <?php $i++;} ?>
                    </table>
                </div>
                <!-- Fine Box Tabella Fatture Emesse -->
            </div>
        </div>
    </div>
</div>


<script lang="javascript">
function conferma(link) {
    var r=confirm("Vuoi veramente ELIMINARE questo Acconto???");
    if (r == true) {
    document.location.href=link;
    }
    <?php /*
<a href="<?php echo base_url();?>fatture/acconti/elimina/<?php echo $row->idacconto; ?>">
*/
     ?>
}
</script>
