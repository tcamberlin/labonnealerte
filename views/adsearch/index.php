<h1><?php echo $title ?></h1>

<h2><?php echo count($search_results) . ' results found'; ?></h2>

<ol>
<?php foreach ($search_results as $search_result): ?>

    <li><a href="<?php echo $search_result['url'] ?>"><?php echo $search_result['title'] . ' (' . $search_result['creation_date'] . ')'; ?></a></li>

<?php endforeach; ?>
</ol>