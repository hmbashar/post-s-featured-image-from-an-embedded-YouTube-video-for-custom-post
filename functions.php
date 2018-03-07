<?php
// for custom post type

// post's featured image from an embedded YouTube video
function set_youtube_as_featured_image($post_id) {  
	$screen = get_current_screen(); // get post type lists
    // only want to do this if the post has no thumbnail
    if(!has_post_thumbnail($post_id) && $screen->post_type =='videos') { // condation if not sat thumnail and if videos post type

        // find the youtube url
        $post_array = get_post($post_id, ARRAY_A);
        $content = $post_array['post_content'];
        $youtube_id = get_youtube_id($content);

        // build the thumbnail string
        $youtube_thumb_url = 'http://img.youtube.com/vi/' . $youtube_id . '/0.jpg';

        // next, download the URL of the youtube image
        media_sideload_image($youtube_thumb_url, $post_id, 'Sample youtube image.');

        // find the most recent attachment for the given post
        $attachments = get_posts(
            array(
                'post_type' => 'attachment',
                'numberposts' => 1,
                'order' => 'ASC',
                'post_parent' => $post_id
            )
        );
        $attachment = $attachments[0];

        // and set it as the post thumbnail
        set_post_thumbnail( $post_id, $attachment->ID );

    } // end if

} // set_youtube_as_featured_image
add_action('save_post', 'set_youtube_as_featured_image');

function get_youtube_id($content) {

    // find the youtube-based URL in the post
    $urls = array();
    preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $content, $urls);
    $youtube_url = $urls[0][0];

    // next, locate the youtube video id
    $youtube_id = '';
    if(strlen(trim($youtube_url)) > 0) {
        parse_str( parse_url( $youtube_url, PHP_URL_QUERY ) );
        $youtube_id = $v;
    } // end if

    return $youtube_id; 

} // end get_youtube_id


// for all post type

// post's featured image from an embedded YouTube video


function set_youtube_as_featured_image($post_id) {  

    // only want to do this if the post has no thumbnail
    if(!has_post_thumbnail($post_id)) { 

        // find the youtube url
        $post_array = get_post($post_id, ARRAY_A);
        $content = $post_array['post_content'];
        $youtube_id = get_youtube_id($content);

        // build the thumbnail string
        $youtube_thumb_url = 'http://img.youtube.com/vi/' . $youtube_id . '/0.jpg';

        // next, download the URL of the youtube image
        media_sideload_image($youtube_thumb_url, $post_id, 'Sample youtube image.');

        // find the most recent attachment for the given post
        $attachments = get_posts(
            array(
                'post_type' => 'attachment',
                'numberposts' => 1,
                'order' => 'ASC',
                'post_parent' => $post_id
            )
        );
        $attachment = $attachments[0];

        // and set it as the post thumbnail
        set_post_thumbnail( $post_id, $attachment->ID );

    } // end if

} // set_youtube_as_featured_image
add_action('save_post', 'set_youtube_as_featured_image');

function get_youtube_id($content) {

    // find the youtube-based URL in the post
    $urls = array();
    preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $content, $urls);
    $youtube_url = $urls[0][0];

    // next, locate the youtube video id
    $youtube_id = '';
    if(strlen(trim($youtube_url)) > 0) {
        parse_str( parse_url( $youtube_url, PHP_URL_QUERY ) );
        $youtube_id = $v;
    } // end if

    return $youtube_id; 

} // end get_youtube_id
