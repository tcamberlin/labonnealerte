<h1><?php echo $title ?></h1>

<?php foreach ($ads as $ad): ?>

    <p><a href="<?php echo $ad['url'] ?>"><?php echo $ad['title'] ?></a></p>

<?php endforeach; ?>

<?php if(! empty($message)) echo $message; ?>