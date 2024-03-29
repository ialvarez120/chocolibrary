<?php
// include our wordpress functions
// change relative path to find your WP dir
define('WP_USE_THEMES', false);

 
// set header for json mime type
header('Content-type: application/json;');
 
// get latest single post
// exclude a category (#5)
query_posts(array(
  'posts_per_page' => 1,
  'cat' => -5,
));
 
$jsonpost = array();
if (have_posts()) {
  // initialize functions used below
  the_post();
 
  // construct our array for json
  // apply_filters to content to process shortcodes, etc
  $jsonpost["id"] = get_the_ID();
  $jsonpost["title"] = get_the_title();
  $jsonpost["url"] = apply_filters('the_permalink', get_permalink());
  $jsonpost["content"] = apply_filters('the_content', get_the_content());
 
  // would rather do iso 8601, but not supported in gwt (yet)
  $jsonpost["date"] = get_the_time('d F Y');
 
} else {
  // deal with no posts returned
}
 
// output json to file
echo json_encode($jsonpost);
?>