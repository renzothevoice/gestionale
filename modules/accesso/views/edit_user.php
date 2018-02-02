<div class="container.fluid">
  <div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Dati Utente</a></li>
          <li><a href="#tabs-2">Fotografia Profilo</a></li>
          <li><a href="#tabs-3">Cambia Password</a></li>
        </ul>
        <!--Inizio tab Edit dati utente -->
        <div id="tabs-1">
          <h1><?php echo lang('edit_user_heading');?></h1>
          <p><?php echo lang('edit_user_subheading');?></p>
          <div id="infoMessage"><?php echo $message;?></div>
              <!-- form start -->
              <?php echo form_open(uri_string());?>
                <div class="box-body">
                  <!-- Nome -->
                  <div class="form-group">
                    <label for="first_name" class="col-sm-2 control-label">
                      <?php echo lang('edit_user_fname_label', 'first_name');?>
                    </label>
                    <div class="col-sm-10">
                      <?php echo form_input($first_name, 'Nome', "class='form-control'");?>
                    </div>
                  </div>
                  <!-- Cognome -->
                  <div class="form-group">
                    <label for="last_name" class="col-sm-2 control-label">
                      <?php echo lang('edit_user_lname_label', 'last_name');?>
                    </label>
                    <div class="col-sm-10">
                      <?php echo form_input($last_name, 'Cognome', "class='form-control'");?>
                    </div>
                  </div>
                  <!-- Company -->
                  <div class="form-group">
                    <label for="company" class="col-sm-2 control-label">
                      <?php echo lang('edit_user_company_label', 'company');?>
                    </label>
                    <div class="col-sm-10">
                      <?php echo form_input($company, 'Azienda',"class='form-control'"); ?>
                    </div>
                  </div>
                  <!-- Telefono -->
                  <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">
                      <?php echo lang('edit_user_phone_label', 'phone');?>
                    </label>
                    <div class="col-sm-10">
                      <?php echo form_input($phone, 'Telefono',"class='form-control'"); ?>
                    </div>
                  </div>
                  <!-- Gruppi -->
                  <div class="form-group">
                  <?php if ($this->ion_auth->is_admin()): ?>
                      <h3><?php echo lang('edit_user_groups_heading');?></h3>
                      <?php foreach ($groups as $group):?>
                          <div class="checkbox">
                          <?php
                              $gID=$group['id'];
                              $checked = null;
                              $item = null;
                              foreach($currentGroups as $grp) {
                                  if ($gID == $grp->id) {
                                      $checked= ' checked="checked"';
                                  break;
                                  }
                              }
                          ?>
                          <label>
                          <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                          <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                        </label>
                        </div>
                      <?php endforeach?>
                  <?php endif ?>
                  <?php echo form_hidden('id', $user->id);?>
                  <?php echo form_hidden($csrf); ?>
                  </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-default">Cancel</button>
                  <?php echo form_submit('submit', lang('edit_user_submit_btn'),'class="btn btn-info pull-right"');?>
                </div>
                <!-- Chiusura Form </form> -->
                <?php echo form_close();?>
            </div>
            <!-- /.box -->

        <!--Fine tab Edit dati utente,  Inizio tab Foto Profilo -->
        <div id="tabs-2">
          <?php
          // Controllo l'esitenza della foto del profilo
          $fotografia = "./assets/img/utenti/".$user->id."_utente.jpg";
          // Se presente la visualizzo, altrimenti metto una default
          if (file_exists($fotografia)) {
            $foto_url=base_url()."assets/img/utenti/".$user->id."_utente.jpg";;
          } else {
            $foto_url=base_url()."assets/img/utenti/utente_default.jpg";
          }
          echo '<img src="'.$foto_url.'" alt="Foto Utente" width="160px"/>';
          ?>
          <br />
          <?php echo form_open_multipart('accesso/foto_profilo');?>
          <div class="form-group">
            <label for="foto" class="col-sm-2 control-label">
              <?php echo 'Foto Profilo';?>
            </label>
            <input type="file" name="fotografia" size="20" class="form-control" id="fotografia"  />
            <?php
              echo form_hidden('id', $user->id);
              echo form_hidden($csrf);
            ?>
            <br /><br />
            <div class="box-footer">
              <input type="submit" value="Carica Foto" class="btn btn-info pull-right"/>
            </div>
          </div>
          </form>
        </div>
        <!-- Fine tab Foto Profilo -->
        <div id="tabs-3">
          <?php echo form_open('accesso/imposta_password/'.$user->id);?>
            <div class="box-body">
          <!-- Password -->
          <div class="form-group">
            <label for="phone" class="control-label">
              <?php echo lang('edit_user_password_label', 'password');?>
            </label>
              <?php echo form_password('password', '',"class='form-control' id='password'"); ?>
            <label for="phone" class="control-label">
              <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?>
            </label>
              <?php echo form_password('password_confirm', '',"class='form-control' id='password_confirm'"); ?>
          </div>
          <?php
            echo form_hidden('id', $user->id);
            echo form_hidden($csrf);
          ?>
          <div class="box-footer">
            <button type="submit" class="btn btn-default">Cancel</button>
            <?php echo form_submit('submit', 'Aggiorna Password','class="btn btn-info pull-right"');?>
          </div>
        </div>
        <!-- Chiusura Form </form> -->
        <?php echo form_close(); ?>
      </div><!-- fine tabs-3 -->
      </div><!-- fine tab -->
    </div><!-- fine col-md-8 -->
    <div class="col-md-2">
    </div>
  </div>
