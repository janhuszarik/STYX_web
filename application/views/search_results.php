<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Search Results</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/search_results.css'); ?>">
</head>
<body>
<div class="container">
	<h1>Search Results for "<?php echo htmlspecialchars($query); ?>"</h1>
	<div class="search-form">
		<form action="<?php echo base_url('search'); ?>" method="get">
			<input type="search" name="q" value="<?php echo htmlspecialchars($query); ?>" placeholder="Search...">
			<button type="submit">Search</button>
		</form>
	</div>
	<?php if ($results): ?>
		<ul class="search-results">
			<?php foreach ($results as $result): ?>
				<li><?php echo htmlspecialchars($result); ?></li>
			<?php endforeach; ?>
		</ul>
	<?php else: ?>
		<p class="no-results">No results found.</p>
	<?php endif; ?>
</div>
</body>
</html>
