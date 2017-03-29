<h1><?php echo $title ?></h1>

<ul>

<?php foreach($emails as $email) : ?>

<li><?php echo var_dump($emails);//'Subject: ' . $email['subject'] . '. <br /> Body: ' . $email['body'] . '. Email address: ' . $email['email_address'] . '.'; ?></li>

<?php endforeach; ?>

</ul>