<?php foreach ($alerts as $alert_item): ?>

    <h2>Alerte <?php echo $alert_item['id']; ?> (<?php echo anchor("alerts/delete/${alert_item['id']}", 'supprimer'); ?>)</h2>
    <p><?php echo $alert_item['email'] ?></p>
    <p><?php echo $alert_item['search_terms'] ?></p>
    <p><?php echo $alert_item['creation_date'] ?></p>

<?php endforeach ?>