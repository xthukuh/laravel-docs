<?php
/**
*	Page HTML
*	Shows documentation listing/contents
*
*/

//import head html
require_once __DIR__ . '/meta.php';

/** @var string $doc_html Generated documentation file html. */
$doc_html = isset($doc_html) && ($doc_html = trim($doc_html)) ? $doc_html : '';

/** @var string $list_html Generate list html. */
$list_html = isset($list_html) && ($list_html = trim($list_html)) ? $list_html : '';
?>
<!DOCTYPE html>
<html>
<head>
    <!-- meta -->
	<?php echo meta_tags_html() . "\r\n"; ?>

    <!-- icon -->
	<link rel="shortcut icon" type="image/x-icon" href="./assets/icon.png">
	<link rel="apple-touch-icon-precomposed" href="./assets/icon.png">
    
    <!-- title -->
    <title><?php echo isset($page_title) && ($page_title = trim($page_title)) ? $page_title : 'Untitled' ?></title>
    
    <!-- styles -->
    <link rel="stylesheet" href="./assets/styles.css">
    
    <?php if (isset($page_code_highlight) && $page_code_highlight){ ?>
    <!-- code highlight library -->
    <link rel="stylesheet" href="./assets/highlight/styles/default.css">
	<script type="text/javascript" src="./assets/highlight/highlight.pack.js"></script>
	<?php } ?>

</head>
<body>
	<div class="<?php echo trim(sprintf('wrapper %s', $doc_html ? 'doc' : '')); ?>">
		<div class="list-wrapper">
			<!-- title -->
			<h2>Laravel Markdown Docs In HTML</h2>
			
			<!-- search -->
			<form id="search-form" action="" method="GET">
				<input name="s" type="text" placeholder="Search" value="<?php if (isset($_GET['s'])) echo $_GET['s']; ?>">
			</form>

			<!-- results -->
			<p><?php echo empty($list) ? 'No results found!' : sprintf('Found %s doc files.', count($list)) . (isset($_GET['s']) ? ' | <a href="./" title="Show All">Show All</a>' : ''); ?></p>
			
			<?php
			//list html
			if ($list_html) echo $list_html;
			?>
		</div>
		<?php if ($doc_html){ ?>
		<!-- doc wrapper -->
		<div class="doc-wrapper">
			<div class="nav-wrapper">
				<a href="./" title="Lising">Home</a>
			</div>
			<div class="doc-content">
				<?php echo $doc_html; ?>
			</div>
		</div>
		<?php } ?>
	</div>
	<script>0</script>
</body>
</html>