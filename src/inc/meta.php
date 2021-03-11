<?php
/**
*	HTML Meta Tags (Generator)
*/

//import funcs (needed to be able to use function "is_assoc")
require_once __DIR__ . '/funcs.php';

/** @var array $meta_values Meta tags attribute (::name) replacement values assoc array */
$meta_values = [
	'title' => $page_title,
	'author' => 'Martin Thuku @isthuku',
	'name' => 'Laravel Markdown Docs',
	'description' => 'A PHP Server for Laravel Markdown docs in HTML.',
	'keywords' => 'laravel,docs,php,server,markdown,to,html',
	'image' => sprintf('%s/assets/icon.png', rtrim(REQUEST_BASE_URL, '/')),
	'url' => REQUEST_PATH_URL,
];

/** @var array $meta_tags Meta tags (meta tag attributes assoc array) array */
$meta_tags = [
	['charset' => 'utf-8'],
	['name' => 'google', 'content' => 'notranslate'],
	['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'],
	['name' => 'author', 'content' => '::author'],
	['name' => 'description', 'content' => '::description'],
	['name' => 'keywords', 'content' => '::keywords'],

	['itemprop' => 'name', 'content' => '::name'],
	['itemprop' => 'description', 'content' => '::description'],
	['itemprop' => 'image', 'content' => '::image'],
	
	['property' => 'og:title', 'content' => '::title'],
	['property' => 'og:type', 'content' => 'page'],
	['property' => 'og:url', 'content' => '::url'],
	['property' => 'og:image', 'content' => '::image'],
	['property' => 'og:site_name', 'content' => '::name'],
	['property' => 'og:description', 'content' => '::description'],
];

/**
*	Generates meta tags html from meta config values ($meta_tags, $meta_values)
*
*	@param  string $indent
*	@param  array $meta_tags
*	@param  array $meta_values
*	@return string
*/
function meta_tags_html(){
	global $meta_tags; //get global meta tags
	global $meta_values; //get global meta values

	//meta tags must be an array containing tags
	if (!is_array($meta_tags)) abort('Invalid meta tags array!');
	
	//get tags html
	$tags_html = [];
	foreach ($meta_tags as $i => $meta_tag){
		//meta tag must be an associative array i.e. ['key(meta attribute)' => 'value']
		if (!is_assoc($meta_tag)) abort(sprintf('Invalid meta tag assoc array at index (%s)!', $i));
		
		//get tag attributes (html)
		$tag_attrs = [];
		foreach ($meta_tag as $key => $value){
			//add tag html
			$tag_attrs[] = sprintf('%s="%s"', $key, meta_value_replace($value, $meta_values));
		}

		//get tag html
		if (!empty($tag_attrs)){
			$tag_html = sprintf('<meta %s>', implode(' ', $tag_attrs));

			//add tag html
			$tags_html[] = $tag_html;
		}
	}

	//return tags html
	return !empty($tags_html) ? implode("\r\n", $tags_html) : null;
}

/**
*	Replaces string meta values using pattern (::([0-9a-z_-]+)/is)
*	i.e. "::title" replaced with meta values ['title' => 'Test'] = "Test"
*
*	@param  string $str
*	@param  array $meta_values
*	@return string
*/
function meta_value_replace($str, $meta_values){
	return preg_replace_callback('/::([0-9a-z_-]+)/is', function($matches) use (&$str, &$meta_values){
		if (!(is_array($matches) && count($matches) >= 2)) return $str;
		$key = trim($matches[1]);
		$value = is_array($meta_values) && array_key_exists($key, $meta_values) ? $meta_values[$key] : sprintf('<ERROR(%s)>', $key);
		return str_replace($matches[0], $value, $str);
	}, $str);
}
