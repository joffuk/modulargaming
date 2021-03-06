<div class="stats">
	<?php if ( $character->loaded() ): ?>

	<h2><?php echo $character->name; ?></h2>
	<p style="margin-top: -8px;">Level 1 <?php echo $character->race->name; ?> Warrior</p>

	<span class="bar hp">
		<?php echo '<span style="width: ' . $char->percent_hp() . '%"></span>'; ?>
		<p><?php echo $character->hp . ' / '. $character->max_hp; ?></p>
	</span>
	
	<ul class="left">
		<li>Alignment <span><?php echo $char->alignment( ); ?></span></li>
		<li>Gold <span><?php echo $character->money; ?></span></li>
	</ul>
	
	<ul class="right">
		<li>Energy <span><?php echo $character->energy; ?></span></li>
		<li>Gold <span>2135</span></li>
	</ul>
	
	<h2 style="text-align: left">Actions</h2>
	
	<?php echo html::anchor( 'battle', 'Attack a Monster' ); ?><br />
	<?php echo html::anchor( 'character/heal', 'Heal' ); ?><br />
	<?php echo html::anchor( 'travel', 'Travel' ); ?><br />
	<?php echo html::anchor( 'zone', 'Zone info' ); ?><br />
	
	<?php else: ?>
	
	<p>You do not have a character yet, <?php echo html::anchor( 'character', 'create one?' ) ?>.</p>
	
	<?php endif ?>
</div>

<div class="right">
	<h2>History</h2>
	<ul class="no-bullets history">
		<?php foreach ( $history as $h ): ?>
		
		<li><span><?php echo Time::date($h->time, NULL) ?>:</span> <?php echo $h->history ?> </li>
		
		<?php endforeach;?>
	</ul>
</div>
