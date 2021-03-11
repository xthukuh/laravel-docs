<?php
/**
*	Main page processor
*	Processes request to show documentation listing/file page.
*
*/

//import funcs methods
require_once __DIR__ . '/inc/funcs.php';

/** @var array $list Found documentation file names array (no ext) */
$list = [];

/** @var array $docs Scanned documentation folder files name and path assoc array i.e. ['NAME' => 'PATH'...] */
$docs = get_docs();

//search $docs
if (isset($_GET['s'])){
	//get search string
	if ($search = trim($_GET['s'])){
		foreach ($docs as $name => $path){
			//search doc file contents for string
			if (is_file($path) && ($content = file_get_contents($path))){
				if (strpos($content, $search) !== false){
					$list[] = $name; //add matched doc
				}
			}
		}
	}
}
else $list = array_keys($docs); //add all docs to list (no search)

/** @var string $doc_html Generated documentation file html. */
$doc_html = null;

/** @var bool $page_code_highlight Enables use of code highlight library */
$page_code_highlight = 0;

/** @var string $page_title Page title. */
$page_title = 'Laravel Docs';

/** @var string $request_doc Request path document name. */
$request_doc = trim(str_replace(REQUEST_BASE, '', REQUEST_PATH), '/');

//if requesting document
if ($request_doc){
	//change page title
	$page_title = sprintf('%s | Laravel Docs', title($request_doc));
	
	//generate request doc html
	$cache_html = !(isset($_GET['cache']) && $_GET['cache'] == '0');
	$doc_html = get_doc_html($request_doc, $cache_html, "\t\t");

	//use highlight library
	$page_code_highlight = 1;
}

/** @var string $list_html Generate list html. */
$list_html = get_list_html($list);

//show page
require_once __DIR__ . '/inc/page.php';