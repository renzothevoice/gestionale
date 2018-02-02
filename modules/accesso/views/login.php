</head>
<?php
echo '<body class="login_page';
echo rand(1, 3);
echo '">'
?>
<div class="container">
  <div class="row">
      <div class="col-md-3"></div>
        <div class="col-md-6">
          <div class="well" style="margin-top: 77px;">
            <div style="text-align: center;">
            <img class="logo" src="<?php echo base_url(); ?>assets/images/logo.png" alt="codemakers">
          </div>
          <h2><?php echo lang('login_heading');?></h2>
          <p><?php echo lang('login_subheading');?></p>
          <div class="infoMessage"><?php echo $message;?></div>
            <?php echo form_open("accesso/login");
            echo '<div class="form-group input-group">';
            // Input username
            echo lang('login_identity_label', 'identity');
            echo '<div class="input-group">';
            echo '<span class="input-group-addon" id="basic-addon1">@</span>';
            echo form_input($identity);
            echo form_error('identity');
            echo '</div>';
            // Input password
            echo lang('login_password_label', 'password');
            echo '<div class="input-group">';
            echo '<span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-lock"></i></span>';
            echo form_input($password);
            echo form_error('password');
            echo '</div>';
            echo '<br/>';
            echo form_submit('submit', lang('login_submit_btn'));
            echo form_close();
            ?>
            <p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>
          </div>
        </div>
      <div class="col-md-3"></div>
  </div>
  <!--
  <div class="fixed">
    <img class="img-responsive" src="<?php echo base_url(); ?>assets/images/logo.png" height="150px;">
      Some links go here.
  </div>
-->

</div>
