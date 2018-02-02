<div class="container">
  <div id="signupbox" style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
    <div class="panel panel-info">
      <div class="panel-heading">
          <div class="panel-title">Crea Nuova SCADENZA</div>
            </div>
            <?php echo validation_errors(); ?>
            <div class="panel-body" >
                <?php echo form_open('tasks/nuovo','class="form-horizontal"'); ?>
                        <!-- Categoria -->
                          <div id="div_categoria" class="form-group required">
                              <label for="categoria" class="control-label col-md-4  requiredField"> Categoria: </label>
                              <div class="controls col-md-8 ">
                               <?php
                               $categorie3=array();
                               for($i=0;$i<sizeof($categorie);$i++){
                                 $categorie3[$categorie[$i]['id_categoria']] = $categorie[$i]['categoria'];
                               }
                               echo form_dropdown('id_categoria', set_value('categorie', $categorie3), "", 'class="input-md form-control"');
                               ?>
                            </div>
                          </div>
                        <!-- -->
                        <!-- Data Scadenza -->
                        <div id="div_scadenza" class="form-group required">
                            <label for="scadenza" class="control-label col-md-4  requiredField"> Scadenza:<span class="asteriskField">*</span> </label>
                            <div class="controls col-md-8 ">
                                <input class="input-md form-control" id="data_scadenza" name="data_scadenza" autocomplete="off" style="margin-bottom: 10px" value="<?php echo set_value('scadenza'); ?>" type="date" />
                            </div>
                        </div>
                        <!-- Descrizione -->
                        <div id="div_descrizione" class="form-group required">
                            <label for="id_descrizione" class="control-label col-md-4 requiredField">Descrizione:<span class="asteriskField">*</span> </label>
                            <div class="controls col-md-8 ">
                                <textarea rows="4" cols="50" class="input-md form-control" id="descrizione" name="descrizione" placeholder="Descrivi la scadenza" style="margin-bottom: 10px" type="text"><?php echo set_value('descrizione'); ?></textarea>
                            </div>
                        </div>
                        <!-- Note -->
                        <div id="div_note" class="form-group">
                             <label for="id_note" class="control-label col-md-4  requiredField"> Note: </label>
                             <div class="controls col-md-8 ">
                                <input class="input-md textinput textInput form-control" id="note" name="note" placeholder="Note aggiuntive" style="margin-bottom: 10px" type="text" value="<?php echo set_value('note'); ?>" />
                            </div>
                        </div>
                        <!-- Stato -->
                        <div id="div_categoria" class="form-group required">
                            <label for="stato" class="control-label col-md-4  requiredField"> Stato: </label>
                            <div class="controls col-md-8 ">
                              <select class="input-md form-control" id="stato" name="stato" style="margin-bottom: 10px">
                               <option value="APERTO">APERTO</option>
                               <option value="CHIUSO">CHIUSO</option>
                               <option value="ANNULLATO">ANNULLATO</option>
                             </select>
                          </div>
                        </div>
                      <!-- Invio -->
                        <div class="form-group">
                            <div class="aab controls col-md-4 "></div>
                            <div class="controls col-md-8 ">
                                <input type="submit" name="Registra" value="Registra" class="btn btn-primary btn btn-info" id="submit-id-signup" />
                            </div>
                        </div>
                    </form>
                </form>
            </div>
        </div>
    </div>
</div>
