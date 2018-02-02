CIAO</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-md-2"></div>
      <div class="col-md-8 griglia">
				<h1><?php echo lang('index_heading');?></h1>
				<p><?php echo lang('index_subheading');?></p>
				<div id="infoMessage"><?php echo $message;?></div>
        <table class="display compact table-bordered table-striped" width="100%" cellspacing="0" id="dtutenti">
        <thead>
					<tr>
						<th><?php echo lang('index_fname_th');?></th>
						<th><?php echo lang('index_lname_th');?></th>
						<th><?php echo lang('index_email_th');?></th>
						<th><?php echo lang('index_groups_th');?></th>
						<th><?php echo lang('index_status_th');?></th>
						<th><?php echo lang('index_action_th');?></th>
					</tr>
        </thead>
        <tbody>
					<?php foreach ($users as $user):?>
						<tr>
				      <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
				      <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
				      <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
							<td>
							<?php foreach ($user->groups as $group):?>
							<?php echo anchor("accesso/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
				      <?php endforeach?>
							</td>
							<td><?php echo ($user->active) ? anchor("accesso/deactivate/".$user->id, lang('index_active_link')) : anchor("accesso/activate/". $user->id, lang('index_inactive_link'));?></td>
              <td><a href="<?php echo base_url()."accesso/edit_user/".$user->id.'"';?> class="btn btn-default navbar-btn" role="button"><i class="fa fa-user" aria-hidden="true"></i> Modifica Utente</a></td>
						</tr>
					<?php endforeach;?>
        </tbody>
				</table>
        <br />
				<h5>ALTRE AZIONI:</h5>
        <a href="<?php echo base_url();?>accesso/create_user" class="btn btn-default navbar-btn" role="button"><i class="fa fa-user-plus" aria-hidden="true"></i> Crea Utente</a>
        <a href="<?php echo base_url();?>accesso/create_group" class="btn btn-default navbar-btn" role="button"><i class="fa fa-users" aria-hidden="true"></i> Crea Gruppo</a>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
