<div class="griglia">
    <div class="container">
        <form action="<?php echo base_url().'fatture/inserisci'; ?>" method="POST">
            <?php
                if(isset($error) && $error == 1){
                    echo '<div class="alert alert-danger margintop40">ATTENZIONE: Compila tutti i campi.</div>';
                }
            ?>
            <div class="row">
                <div class="col-lg-6">
                    <h3>Azienda</h3>
                    <p><b>Nome:</b> <?php echo $_SESSION['rag_soc_azienda']; ?></p>
                </div>
                <div class="col-lg-6">
                    <h3>Cliente</h3>
                    <div class="form-group">
                        <label>Seleziona il cliente a cui fa riferimento la fattura:</label>
                        <select class="form-control" name="cliente">
                            <option value="-" selected="selected">-</option>
                            <?php foreach($clienti as $row){
                                echo '<option value="'.$row->id.'">'.$row->rag_soc.' - '.$row->indirizzo.' - P. IVA: '.$row->piva.'</option>';
                            }?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group text-left">
                        <label>Tipo fattura:</label>
                        <select class="form-control" name="tipo">
                            <option value="-">-</option>
                            <option value="generica">Fattura generica</option>
                            <option value="affitto">Fattuta affitto</option>
                            <option value="utenze">Fattuta utenze</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row margintop40">
                <div class="col-lg-12">
                    <div id="righeapp">
                        <div class="rigaitem" id="row0">
                            <div class="row">
                                <div class="col-sm-5">
                                    <label>Descrizione</label>
                                    <input class="form-control" id="descrizione0" name="descrizione[]" type="text">
                                </div>
                                <div class="col-sm-1">
                                    <label>Quantità</label>
                                    <input class="form-control" id="qnt0" name="qnt[]" type="text" placeholder="3">
                                </div>
                                <div class="col-sm-2">
                                    <label>Prezzo €</label>
                                    <input class="form-control" id="prezzo0" name="prezzo[]" type="text" placeholder="200,00">
                                </div>
                                <div class="col-sm-1">
                                    <label>IVA %</label>
                                    <input class="form-control" id="iva0" name="iva[]" value="22" type="text">
                                </div>
                                <div class="col-sm-2">
                                    <label>Totale riga €</label>
                                    <input class="form-control totr" id="totr0" placeholder="0,00" name="totr[]" type="text">
                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="margintop40 btn btn-primary" id="addriga">Aggiungi riga</button>
                </div>
            </div>
            <div class="row margintop40 marginbottom40">
                <div class="col-lg-6 text-right">
                    <div class="form-group text-left">
                        <label>Data fattura:</label>
                        <input type="text" class="form-control" id="datefatt" autocomplete="off" name="data">
                    </div>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="form-group text-left">
                        <label>Data scadenza:</label>
                        <input type="text" class="form-control" id="datescad" autocomplete="off" name="datascad">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group text-left">
                        <label>Modalità di pagamento:</label>
                        <select class="form-control" id="pagamento" name="pagamento">
                            <option value="-">-</option>
                            <option value="bonifico bancario">Bonifico bancario</option>
                            <option value="rimessa diretta">Rimessa diretta</option>
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
                                echo "<option value='$row->iban'>$row->rag_soc - $row->iban</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 text-right">
                    <h4>Totale fattura</h4><h3 id="totale">0,00 €</h3>
                    <input type="hidden" id="count" value="1">
                    <button type="submit" class="margintop40 pull-right btn btn-success">Inserisci fattura</button>
                </div>
            </div>
        </form>
    </div>
</div>
