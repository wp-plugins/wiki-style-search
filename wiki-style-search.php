<?php
/*Plugin Name: Wiki Style Search
Plugin URI: http://thelargest.net/about/wiki-style-search-plugin
Description: Causes search results to automatically go to a page/post 
if the query matches a page/post title. If matching title is not present, search results display as usual.
Version: 1.0
Author: The Largest
Author URI: http://thelargest.net
License: GPLv2
*/

/*
Copyright (C) 2011 Luddite Creative LLC

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

function my_posts_results_redirect_filter( $input ) {

  global $wp_query;

  //
  // For search results only
  //
  if(is_search() && isset($wp_query->query_vars['s'])) {

    $permalink = '';
    $s = strtolower($wp_query->query_vars['s']);

    for ($i = 0; $i - count($input) < 0; $i++) {

      $tmp = $input[$i];

      //
      // compare post's title to searched string
      //
      if (strtolower($tmp->post_title) == $s) {

        //
        // prepare permalink to redirect to single post
        //
        $permalink = get_permalink( $tmp->ID );

        break;
      }
    }

    if (strlen($permalink) > 0) {

      header('location: ' . $permalink);
      exit;
    }
  }
  return $input;
}

add_filter( 'posts_results', 'my_posts_results_redirect_filter' );
