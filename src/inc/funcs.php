<?php
//use namespaces
use Michelf\Markdown;
use Michelf\SmartyPants;

/**
*	Reads doc file markdown and returns generated html.
*
*	@param  array $list Doc names array
*	@param  string $indent Prepend indentation on each generated code line
*	@return string Genetated formatted html
*/
function get_list_html($list){
	//list must be an non-assoc array
	if (!(is_array($list) && !is_assoc($list) && !empty($list))) return null;
	
	//listing wrapper
	$html = '<div class="listing">';
	
	//listing column items
	$column_items = 0;
	$column_items_max = 20;

	//listing column wrapper
	$html .= '<ul class="list">';
	foreach ($list as $name){

		//listing column items break
		$column_items ++;
		if ($column_items == $column_items_max){
			$html .= '</ul>'; //close column wrapper
			$html .= '<ul class="list">'; //new column wrapper
			$column_items = 0; //reset column items
		}

		//generate listing column item
		$link = sprintf('./%s%s', $name, isset($_GET['s']) && ($s = trim($_GET['s'])) ? "?s=$s" : '');
		$html .= sprintf('<li><a href="%s">%s</a></li>', $link, title($name));
	}
	$html .= '</ul>'; //close last column
	$html .= '</div>'; //close listing wrapper

	//return generated html
	return $html;
}

/**
*	Reads doc file markdown and returns generated html.
*
*	@param  string $name Doc file name (no ext)
*	@param  bool $cache_html Whether to use cached/cache generated doc html
*	@return string Genetated formatted html
*/
function get_doc_html($name, $cache_html=true){
	//cached html
	$cache_path = sprintf('%s/%s.html', LARAVEL_DOCS_CACHE_DIR, $name);
	if (!$cache_html) file_delete($cache_path);
	if ($cache_html && is_file($cache_path)){
		if ($content = file_get_contents($cache_path)){
			if ($html = trim($content)) return $html;
		}

		//remove cache on error
		file_delete($cache_path);
	}

	//get doc markdown content
	$path = sprintf('%s/%s.md', LARAVEL_DOCS_DIR, $name);
	if (!is_file($path)) abort(sprintf('Documentation "%s" not found!', $name), 404);
	if (!($content = file_get_contents($path))) abort(sprintf('Failed to get file "%s"!', $path));
	if (!($content = trim($content))) abort(sprintf('Empty markdown content for file "%s"!', $path));
	
	//generate doc html
	$html = Markdown::defaultTransform($content);
	$html = SmartyPants::defaultTransform($html);

	//cache html
	if ($cache_html) file_put($cache_path, $html);

	//return html
	return $html;
}

/**
*	Create file with content
*
*	@param  string $path
*	@param  string $content
*	@return int
*/
function file_put($path, $content){
	$dir = dirname($path);
	if (!is_dir($dir)){
		mkdir($dir, 0775, true);
		if (!is_dir($dir)) abort(sprintf('Failed to create folder "%s"!', $dir));
	}
	return file_put_contents($path, $content);
}

/**
*	Delete file
*
*	@param  string $path
*	@return void
*/
function file_delete($path){
	if (is_file($path)){
		unlink($path);
		if (is_file($path)) abort(sprintf('Failed to delete file "%s"!', $path));
	}
}

/**
*	Scans the docs folder for *.md files (non recursive) and returns an associative array [FILE_NAME_NO_EXT => FILE_PATH...]
*
*	@return array
*/
function get_docs(){
	$files = [];
	$dir = LARAVEL_DOCS_DIR;
	foreach (scandir($dir, SCANDIR_SORT_ASCENDING) as $basename){
		if (in_array($basename, ['.', '..'])) continue;
		$path = $dir . '/' . $basename; //loop path
		if (!is_file($path)) continue; //filter files only
		$tmp = explode('.', $basename);
		$ext = end($tmp); //file ext
		if (!in_array($ext, ['md'])) continue; //filter .md files only
		$name = trim(str_replace('.' . $ext, '', $basename)); //file name
		$files[$name] = $path; //add file
	}
	return $files;
}

/**
*	Abort processing with error
*
*	@param  string  $error
*	@param  int  $code
*	@return void
*/
function abort($error, $code=500){
	http_response_code($code); //response code (500 - internal server error)
	header('Content-Type: text/plain'); //content type - text
	echo $error; //output error text
	die(); //abort
}

/**
*	Abort processing and print_r data
*
*	@param  mixed  $data
*	@return void
*/
function dd($data, $code=503){
	http_response_code($code); //response code (503 - service unavailable)
	header('Content-Type: text/plain'); //content type - text
	print_r($data); //print_r data
	die(); //abort
}

/**
*	Convert slug case name to title. i.e. "database-testing" -> "Database Testing"
*
*	@param  string  $name
*	@return string
*/
function title($name){
	$words = explode('-', trim($name));
	$title = ucwords(implode(' ', $words));
	return $title;
}

/**
*	Checks if value ($val) is an associative array
*
*	@param  mixed $val
*	@return bool
*/
function is_assoc($val){
	return is_array($val) && !empty($val) && ($c = count($val)) && array_keys($val) !== range(0, $c - 1);
}