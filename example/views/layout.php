

<?php include './base.php'; ?>

<?php block::start('body'); ?>

	<header>
		<?php block::start('header'); ?>
			Header
		<?php block::end(); ?>
	</header>





	<main>
	<?php block::define('main'); ?>
	</main>



	<footer>
	<?php block::start('footer'); ?>
		Footer
	<?php block::end(); ?>
	</footer>

<?php block::end(); ?>
