    <div class="container griglia">
        <form action="<?php echo base_url().'fatture/inserisci/mod'; ?>" method="POST" >
            <?php
                if(isset($error) && $error == 1){
                    echo "<div class=\"alert alert-danger margintop40\">ATTENZIONE: Compila tutti i campi.</div>";
                }
            ?>
            <div class="row">
              <div class="col-md-12 intestazione"><h4><b>MODIFICA FATTURA EMESSA</b></h4></div>
            </div>
            <!-- Numero e Date -->
            <div class="row margintop20">
              <div class="col-md-4"><b>Numero fattura:</b> <input type="text" id="numfattura" disabled value="<?php echo $fattura->numero; ?>" size="4"></input> <button type="button" onclick="javascript:alert();" class="btn btn-primary btn-sm">Modifica</button></div>
              <div class="col-md-4 form-inline"><label>Data fattura: </label>
                  <input type="text" class="form-control" id="datemod" autocomplete="off" value="<?php echo date_format(date_create($fattura->data_creazione), "d-m-Y"); ?>" name="data">
              </div>
              <div class="col-md-4 form-inline"><label>Scadenza fattura: </label>
                <input type="text" class="form-control" id="datescmod" autocomplete="off" value="<?php echo date_format(date_create($fattura->data_scadenza), "d-m-Y"); ?>" name="datascad">
              </div>
            </div>
            <!-- Cliente e tipo Fattura -->
            <div class="form-group row margintop20">
              <div class="col-md-1 form-inline"></div>
              <div class="col-md-7 form-inline">
                <label for="lblCliente" class="col-form-label">Cliente: </label>
                <select class="form-control" name="cliente">
                  <option value="-" selected="selected">-</option>
                    <?php foreach($clienti as $row){
                        if($fattura->rag_soc == $row->rag_soc){
                            echo '<option selected="selected" value="' . $row->id . '">' . $row->rag_soc . ' - ' . $row->indirizzo . ' - P. IVA: ' . $row->piva . '</option>';
                        }else {
                            echo '<option value="' . $row->id . '">' . $row->rag_soc . ' - ' . $row->indirizzo . ' - P. IVA: ' . $row->piva . '</option>';
                        }
                    }?>
                </select>
              </div>
              <div class="col-md-4 form-inline">
                <label for="lblTipoFattura" class="col-form-label">Tipo Fattura: </label>
                <select class="form-control" name="tipo">
                    <option value="-">-</option>
                    <option <?php if($fattura->tipo == 'generica') echo 'selected="selected"'; ?> value="generica">Fattura generica</option>
                    <option <?php if($fattura->tipo == 'affitto') echo 'selected="selected"'; ?> value="affitto">Fattuta affitto</option>
                    <option <?php if($fattura->tipo == 'utenze') echo 'selected="selected"'; ?> value="utenze">Fattuta utenze</option>
                </select>
              </div>
            </div>
            <!-- Righe Fattura -->
            <div class="row">
                <div class="col-lg-12">
                    <div id="righeapp">
                        <?php
                        $i=0;
                        $totale = 0;
                        foreach($itemfatt as $row) {
                            echo '<div class="rigaitem" id="row'.$i.'"><div class="row">';
                            echo '<div class="col-sm-5">';
                            echo '<label>Descrizione</label>';
                            echo '<input class="form-control" id="descrizione'.$i.'" name="descrizione[]" type="text" value="'.$row->descrizione.'"></div>';
                            echo '<div class="col-sm-1">';
                            echo '<label>Quantità</label>';
                            echo '<input class="form-control" id="qnt'.$i.'" name="qnt[]" type="text" placeholder="3" value="'.$row->qnt.'"></div>';
                            echo '<div class="col-sm-2">';
                            echo '<label>Prezzo €</label>';
                            echo '<input class="form-control" id="prezzo'.$i.'" name="prezzo[]" type="text" placeholder="200,00" value="'.number_format($row->prezzo, 2, '.','').'"></div>';
                            echo '<div class="col-sm-1">';
                            echo '<label>IVA %</label>';
                            echo '<input class="form-control" id="iva'.$i.'" name="iva[]" value="22" type="text" value="'.$row->iva.'"></div>';
                            echo '<div class="col-sm-2">';
                            echo '<label>Totale riga €</label>';
                            echo '<input class="form-control" id="totr'.$i.'" placeholder="0,00" name="totr[]" value="'.number_format($row->tot_item, 2, '.','').'" type="text"></div>';
                            if($i == 0){
                                echo '</div></div>';
                            }else{
                                echo '<div class="col-sm-1"><label>Elimina</label><br><button class="btn btn-danger" onclick="hiderow('.$i.');" value="Elimina" type="button"><i class="fa fa-remove"></i></button></div></div></div>';
                            }
                            $i++;
                            $totale = $totale + $row->tot_item;
                        }
                        ?>
                    </div>
                    <div style="text-align: right;">
                      <button type="button" class="margintop40 btn btn-primary" id="addriga">Aggiungi riga</button>
                    </div>
            <!-- Fine Date -->
                <div class="col-lg-12">
                    <div class="form-group text-left">
                        <label>Modalità di pagamento: </label>
                        <select class="form-control" id="pagamento" name="pagamento">
                            <option value="-">-</option>
                            <option value="bonifico bancario" <?php if ($fattura->pagamento == 'bonifico bancario') echo 'selected';?>>Bonifico bancario</option>
                            <option value="rimessa diretta" <?php if ($fattura->pagamento == 'rimessa diretta') echo 'selected';?>>Rimessa diretta</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12" id="iban">
                    <div class="form-group text-left">
                        <label>IBAN per pagamento:</label>
                        <select class="form-control" name="iban">
                            <option value="-">-</option>
                            <?php
                            foreach($iban as $row){
                                if($row->iban == $fattura->iban){
                                    echo "<option selected='selected' value='$row->iban'>$row->rag_soc - $row->iban</option>";
                                }else{
                                    echo "<option value='$row->iban'>$row->rag_soc - $row->iban</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 text-right">
                    <h4>Totale fattura</h4><h3 id="totale"><?php echo number_format($totale, 2, ',',''); ?> €</h3>
                    <input type="hidden" name="idfatt" value="<?php echo $idfattura; ?>">
                    <input type="hidden" id="count" value="<?php echo $count; ?>">
                    <button type="submit" class="margintop40 pull-right btn btn-success">Modifica fattura</button>
                </div>

        </form>
    </div>
