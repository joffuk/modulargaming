<?php /* Hidden div for adding new users, will appear using ajax */ ?>
<div id="new">
	
	<?php
		echo form::open();
		
		
		
		
		echo form::close();
	?>
	
</div>

<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Username</th>
			<th>Email</th>
			<th>Last login</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $users as $v ): ?>
			<tr>
				<td><?php echo $v->id; ?></td>
				<td><?php echo $v->username; ?></td>
				<td><?php echo $v->email; ?></td>
				<td><?php echo $v->verbose( 'last_login' ); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>