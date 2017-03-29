
<?php if($res == 1) : ?>
	<div class="success"><?php echo $this->config->item('email_validation_ok'); ?></div>
<?php elseif($res == 2) : ?>
		<div class="success"><?php echo $this->config->item('alert_deactivation_ok'); ?></div>
<?php elseif($res == 3) : ?>
			<div class="success"><?php echo sprintf($this->config->item('resend_validation_ok'), $email); ?></div>
<?php else : ?>
		<div class="success"><?php echo $this->config->item('alert_operation_nok'); ?></div>
<?php endif ; ?>
