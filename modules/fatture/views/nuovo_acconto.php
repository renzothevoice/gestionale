<div class="griglia">
    <div class="container">
        <h3>Nuovo acconto</h3>
        <form action="<?php echo base_url().'fatture/acconti/inserisci'; ?>" method="POST">
            <?php
                if(isset($error) && $error == 1){
                    echo "<div class=\"alert alert-danger margintop40\">ATTENZIONE: Compila tutti i campi.</div>";
                }
                if(isset($error) && $error == 2){
                    echo "<div class=\"alert alert-danger margintop40\">ATTENZIONE: Non puoi inserire un importo superiore all'importo mancante!</div>";
                }
            ?>
            <div class="row margintop40 marginbottom40">
                <div class="col-lg-6 text-right">
                    <div class="form-group text-left">
                        <label>Data acconto:</label>
                        <input type="text" class="form-control" id="datefatt" autocomplete="off" name="data">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Seleziona la fattura a cui fa riferimento l'acconto:</label>
                        <select class="form-control" name="fatturascelta">
                            <option value="-">-</option>
                            <?php foreach($fatture as $row){
                                $avere = $row->totaleii - $this->mod_fatture->getIdfattAvuto($row->id_fattura);
                                if($avere != 0) {
                                    if (isset($numerofattura) && $numerofattura == $row->numero) {
                                        echo '<option value="' . $row->id_fattura . '|' . $avere . '" selected="selected">' . $row->numero . " - " . $row->rag_soc . " - Totale: " . number_format($row->totaleii, 2, ',', ' ') . ' € - Mancano: ' . number_format(($avere), 2, ',', ' ') . ' €</option>';
                                    } else {
                                        echo '<option value="' . $row->id_fattura . '|' . $avere . '">' . $row->numero . " - " . $row->rag_soc . " - Totale: " . number_format($row->totaleii, 2, ',', ' ') . ' € - Mancano: ' . number_format(($avere), 2, ',', ' ') . ' €</option>';
                                    }
                                }
                            }?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group text-left">
                        <label>Importo €:</label>
                        <input type="text" class="form-control" autocomplete="off" placeholder="Importo acconto" name="importo">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group text-left">
                        <label>Note:</label>
                        <textarea name="note" placeholder="Inserisci una nota" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-lg-12 text-right">
                    <button type="submit" class="margintop40 pull-right btn btn-success">Inserisci acconto</button>
                </div>
            </div>
        </form>
    </div>
</div>
