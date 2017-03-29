<h2>Liste des annonces</h2>

<?php foreach ($ads as $ad_item): ?>

    <h2><a href="<?php echo site_url('ads/single/id/' . $ad_item['id']); ?>"><?php echo $ad_item['title']; ?></a></h2>
    <?php  /* (<?php echo anchor("alerts/delete/${ad_item['id']}", 'supprimer'); ?>) */ ?>

<?php endforeach ?>

Pages : 

<?php foreach ($pagination as $p_key => $p_value): ?>

	<?php if($p_value['type'] == 'previous') : ?>

		<?php echo sprintf('<a href="%s">%s</a>', site_url('ads/index/page/' . $p_value['page_number']), '<<'); ?>

	<?php elseif($p_value['type'] == 'standard') : ?>

		<?php echo sprintf('<a href="%s">%s</a>', site_url('ads/index/page/' . $p_value['page_number']), $p_value['page_number']); ?>

	<?php elseif($p_value['type'] == 'next') : ?>

		<?php echo sprintf('<a href="%s">%s</a>', site_url('ads/index/page/' . $p_value['page_number']), '>>'); ?>

	<?php endif ?>

<?php endforeach ?>