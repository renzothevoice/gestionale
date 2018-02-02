        <div class="container">
            <div class="row clearfix">
                <div class="col-md-12 column">
                        <div id='calendar'></div>
                </div>
            </div>
        </div>
<!-- Codice modal per la visualizzazione del form di inserimento/modifica evento -->
        <div class="modal" style="display:none;" id="edit_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="error"></div>
                        <form class="form-horizontal" id="crud-form">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="title">Titolo</label>
                                <div class="col-md-4">
                                    <input id="titolo" name="titolo" type="text" class="form-control input-md" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="time">Inizio</label>
                                <div class="col-md-4 input-append bootstrap-timepicker">
                                    <input id="inizio" name="inizio" type="text" class="form-control input-md" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="time">Fine</label>
                                <div class="col-md-4 input-append bootstrap-timepicker">
                                    <input id="fine" name="fine" type="text" class="form-control input-md" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="description">Descrizione</label>
                                <div class="col-md-4">
                                    <textarea class="form-control" id="descrizione" name="descrizione"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="color">Color</label>
                                <div class="col-md-4">
                                    <input id="color" name="color" type="text" class="form-control input-md" readonly="readonly" />
                                    <span class="help-block">Click to pick a color</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="color">Colore da Lista</label>
                                <div class="col-md-4">
                                  <select id="colore" name="colore">
                                    <option value="#CD1919">ROSSO</option>
                                    <option value="#E9FF00">GIALLO</option>
                                    <option value="#159715">VERDE</option>
                                    <option value="#2A1597">BLU</option>
                                    <option value="#E9FF00">FUCSIA</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="url">URL</label>
                                <div class="col-md-4">
                                  <input id="url" name="url" type="text" class="form-control input-md" />
                                </div>
                            </div>
                            <!-- campo hidden con l'id del cliente associato -->
                            <input type="hidden" name="id_cliente" id="id_cliente" value="1" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a href="#" rel="modal:close">Clicca per chiudere o premi ESC</a></p>
                    </div>
                </div>
            </div>
        </div>
