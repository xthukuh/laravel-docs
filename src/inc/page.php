<?php
/**
*	Page HTML
*	Shows documentation listing/contents. Uses shodown js to parse markdown to html.
*
*/

//import head html
require_once __DIR__ . '/meta.php';

/** @var string $doc_content Documentation file markdown content. */
$doc_content = isset($doc_content) && ($doc_content = trim($doc_content)) ? $doc_content : '';

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

    <?php if ($doc_content){ ?>
    <!-- showdown markdown-html parser -->
	<script type="text/javascript" src="./node_modules/showdown/dist/showdown.min.js"></script>
    <?php } ?>
</head>
<body>
	<div class="<?php echo trim(sprintf('wrapper %s', $doc_content ? 'doc' : '')); ?>">
		
		<div class="list-wrapper">
			<!-- title -->
			<h2>Laravel Docs</h2>
			
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
		
		<?php if ($doc_content){ ?>
		<!-- doc wrapper -->
		<div class="doc-wrapper">
			<div class="nav-wrapper">
				<a href="./" title="Lising">Home</a>
			</div>
			<div class="doc-content markdown"><?php echo base64_encode($doc_content); ?></div>
		</div>

		<!-- parse markdown -->
		<script type="text/javascript" src="./assets/doc-parser.js"></script>
		<?php } ?>

	</div>

	<!-- script -->
</body>
</html>