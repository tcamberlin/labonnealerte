<?php if($res) : ?>
    <p>Alert <?php echo $id; ?> has been deleted successfully.</p>
<?php else : ?>
    <p>There was an error deleting row <?php echo $id; ?>, please try again.</p>
<?php endif; ?>
