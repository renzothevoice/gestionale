<div class="griglia">
    <div class="container">
            <?php
                if(isset($error) && $error == 1){
                    echo "<div class=\"alert alert-danger margintop40\">ATTENZIONE: Compila tutti i campi.</div>";
                }
            ?>
            <div class="row">
                <div class="col-lg-6">
                    <h3>Azienda</h3>
                    <p><b>Nome:</b> <?php echo $_SESSION['rag_soc_azienda']; ?></p>
                </div>
                <div class="col-lg-6">
                    <h3>Cliente</h3>
                    <p>
                        <b><?php echo $fattura->rag_soc; ?></b>
                    </p>
                </div>
            </div>
            <div class="row margintop40">
                <div class="col-lg-12">
                        <?php
                        $i=0;
                        $totale = 0;
                        foreach($itemfatt as $row) {
                            echo '<div class="rigaitem"><div class="row">';
                            echo '<div class="col-sm-6">';
                            echo '<label>Descrizione</label><br>';
                            echo $row->descrizione."</div>";

                            echo '<div class="col-sm-1">';
                            echo '<label>Quantità</label><br>';
                            echo $row->qnt."</div>";
                            echo '<div class="col-sm-2">';
                            echo '<label>Prezzo €</label><br>';
                            echo number_format($row->prezzo, 2, '.','')."</div>";
                            echo '<div class="col-sm-1">';
                            echo '<label>IVA %</label><br>';
                            echo $row->iva."</div>";
                            echo '<div class="col-sm-2">';
                            echo '<label>Totale €</label><br>';
                            echo number_format($row->tot_item, 2, '.','')."</div>";
                            echo '</div></div>';
                            $i++;
                            $totale = $totale + $row->tot_item;
                        }
                        ?>
                </div>
            </div>
            <div class="row margintop40 marginbottom40">
                <div class="col-lg-6 text-right">
                    <div class="form-group text-left">
                        <label>Data fattura:</label><br>
                        <b><? $date = new DateTime($fattura->data_creazione); echo $date->format('d/m/y');?></b>
                    </div>
                </div>
                <div class="col-lg-6 text-right">
                    <div class="form-group text-left">
                        <label>Scadenza fattura:</label><br>
                        <b><? $date = new DateTime($fattura->data_scadenza); echo $date->format('d/m/y');?></b>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group text-left">
                        <label>Modalità di pagamento:</label><br>
                        <b><? echo $fattura->pagamento;?></b>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group text-left">
                        <label>IBAN per pagamento:</label><br>
                        <b><?php if($fattura->pagamento == 'bonifico bancario'){ echo $fattura->iban;}else{echo "-";} ?></b>
                    </div>
                </div>
                <div class="col-lg-12 text-right">
                    <h4>Totale fattura</h4><h3><?php echo number_format($totale, 2, ',','.');?></h3>
                </div>
            </div>
    </div>
</div>
