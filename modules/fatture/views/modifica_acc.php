<div class="griglia">
    <div class="container">
        <h3>Modifica acconto</h3>
        <form action="<?php echo base_url().'fatture/acconti/exmod'; ?>" method="POST">
            <?php
                if(isset($error) && $error == 1){
                    echo "<div class=\"alert alert-danger margintop40\">ATTENZIONE: Compila tutti i campi.</div>";
                }
            ?>
            <div class="row margintop40 marginbottom40">
                <div class="col-lg-6 text-right">
                    <div class="form-group text-left">
                        <label>Data acconto:</label>
                        <input type="text" class="form-control" id="datefatt" autocomplete="off" name="data" value="<?php echo $acconto[0]->data_registrazione ?>">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Seleziona la fattura a cui fa riferimento l'acconto:</label>
                        <select class="form-control" name="idfattura">
                            <option value="-" selected="selected">-</option>
                            <?php foreach($fatture as $row){
                                if($row->id_fattura == $acconto[0]->id_fattura) {
                                    echo '<option selected="selected" value="' . $row->id_fattura . '">' . $row->numero . " - " . $row->rag_soc . " - Totale: " . number_format($row->totaleii, 2, ',', ' '). ' €</option>';
                                }else{
                                    echo '<option value="' . $row->id_fattura . '">' . $row->numero . " - " . $row->rag_soc . " - Totale: " . $row->totaleii . ' €</option>';
                                }
                            }?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group text-left">
                        <label>Importo €:</label>
                        <input type="text" class="form-control" autocomplete="off" placeholder="es. 200.00" name="importo" value="<?php echo number_format($acconto[0]->valoreii, 2, ',', ' '); ?>">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group text-left">
                        <label>Note:</label>
                        <textarea name="note" class="form-control"><?php echo $acconto[0]->note; ?></textarea>
                    </div>
                </div>
                <div class="col-lg-12 text-right">
                    <input type="hidden" name="idacconto" value="<?php echo $acconto[0]->idacconto; ?>">
                    <button type="submit" class="margintop40 pull-right btn btn-success">Modifica acconto</button>
                </div>
            </div>
        </form>
    </div>
</div>
