<section id="banner">
	<h2><?php echo App_Name;  ?></h2>
	<p>Le meilleur service au prix le moins cher</p>
	<ul class="actions special">
		<?php
		if (!isset($_SESSION['user_id'])){
			echo '<li><a href="connexion.php" class="button primary">Connexion</a></li>';
		}
		?>
		
		<li><a href="reserver.php" class="button">Reserver</a></li>
	</ul>
</section>