<?php

load_theme_textdomain('azsimple', TEMPLATEPATH . '/languages');

/* Add support of featured image */
add_theme_support('post-thumbnails');
add_image_size('featured-post-image', 214, 160); // new resize type


/* ------- Adding a custom menu ------- */
add_theme_support('menus');

add_action('init', 'register_my_menus');

function register_my_menus() {
	register_nav_menus(
		array(
			'menu-1' => __('Menu 1', 'azsimple')
		)
	);
}

/* ------- Register sidebar ------- */
if (function_exists('register_sidebars')) {
	register_sidebars(1);
}

function limits($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '', $showMoreLink = true) {
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	$content = strip_tags($content, '');

   if (strlen($_GET['p']) > 0) {
	  echo $content;
   } elseif ((strlen($content) > $max_char) && ($espacio = strpos($content, " ", $max_char))) {
		$content = substr($content, 0, $espacio);
		printf(__('%s...', 'azsimple'), $content);
		
		if ($showMoreLink) {
			echo "<div class=";
			echo "\"continue-reading\">";
			echo "<a href=\"";
			the_permalink();
			echo "\">".$more_link_text."</a></div>";
		}
   } else {
	  echo $content;
   }
}

function limits2($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
	limits($max_char, $more_link_text, $stripteaser, $more_file, false);
}

/**
 * Displays img tag describing a post.
 * The image used is the featured post image.
 * If it doesn't exists, it takes the first image found in the post if it is also in the attachement.
 * If nothing is found before, a default image is putted.
 * 
 * @param integer $postid
 * @param string $size
 * @param string $attributes
 */
function zt_get_thumbnail($postid = null, $size = 'thumbnail', $attributes = '') {
	$postid = (null === $postid) ? get_the_ID() : $postid;
	$html = "<img src=\"" . get_bloginfo('template_directory', 'display');
	$html .= "/images/noimage.png\" alt=\"" . get_the_title() . "\" />";
	if (has_post_thumbnail($postid)) {
		$html = get_the_post_thumbnail($postid, $size, $attributes);
	} else {
		$htmlFirstImg = get_first_valid_local_post_image($postid, $size, $attributes);
		if (null != $htmlFirstImg) {
			$html = $htmlFirstImg;
		}
	}
	echo $html;
}

/**
 * Returns img tag corresponding of the first image from attachement used in the post.
 * 
 * @param integer $postid
 * @param integer $size
 * @param string $attributes
 * @return img tag.
 */
function get_first_valid_local_post_image($postid = null, $size = 'thumbnail', $attributes = '') {
	$postid = (null === $postid) ? get_the_ID() : $postid;
	$htmlImg = null;
	$srcListInPostContent = get_all_images_in_post_content($postid);
	foreach ($srcListInPostContent as $srcFromPostContent) {
		if (url_is_valid($srcFromPostContent)) {
			$imageListFromAttachement = get_all_images_in_attachement($postid);
			if ($imageListFromAttachement) {
				foreach($imageListFromAttachement as $imageFromAttachement) {
					if (src_is_on_attachement($imageFromAttachement->ID, $srcFromPostContent)) {
						$htmlImg = wp_get_attachment_image($imageFromAttachement->ID, $size, false, $attributes);
						break 2;
					}
				}
			}
		}
	}
	return $htmlImg;
}

/**
 * Tests if an URL is valid.
 * 
 * @param string $url
 * @return boolean true if the url is valid. false else.
 */
function url_is_valid($url = null) {
	$isValid = false;
	if (null !== $url) {
		if (!ini_get('allow_url_fopen')) {
	        $file_data = curl_get_file_contents($url);
	    } else {
	        $file_data = @file_get_contents($url);
	    }
	    $isValid = !($file_data === false);
	}
    return $isValid;
}

/**
 * Returns images attached to a post.
 * 
 * @param integer $postid
 * @return array Array of images.
 */
function get_all_images_in_attachement($postid = null) {
	$postid = (null === $postid) ? get_the_ID() : $postid;
	$images = get_children(
		array(
			'post_parent' => $postid,
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'orderby' => 'menu_order')
		);
	return $images;
}

/**
 * Returns images found in a post.
 * 
 * @param integer $postid
 * @return array Array of src images.
 */
function get_all_images_in_post_content($postid = null) {
	$postid = (null === $postid) ? get_the_ID() : $postid;
	$post = get_post($postid);
	preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	return $matches[1];
}

/**
 * Searches if the image URI found in the post correspond to an URI (one per size) of the image id.
 * 
 * @param integer $imageId
 * @param string $srcFromPostContent
 * @return boolean true if a same URI has been found.
 */
function src_is_on_attachement($imageId = null, $srcFromPostContent = '') {
	$retVal = false;
	if (null !== $imageId && '' !== $srcFromPostContent) {
		$sizeList = get_intermediate_image_sizes();
		foreach ($sizeList as $size) {
			$srcFromAttachement = wp_get_attachment_image_src($imageId, $size);
			if ($srcFromAttachement[0] == $srcFromPostContent) {
				$retVal = true;
				break;
			}
		}
	}
	return $retVal;
}

$themename = "Azsimple";
$shortname = "azs";
$options = array(
	array(
		"name" => __('Azsimple Theme Options', 'azsimple'),
		"type" => "title"),
	array(
		"type" => "open"),
	array(
		"name" => __('Logo URL', 'azsimple'),
		"desc" => __('Enter the logo URL. Maximum logo width = 400px. Maximum logo height = 50px.', 'azsimple'),
		"id" => $shortname."_logourl",
		"std" => "http://azmind.com/wp-themes-demo2/wp-content/themes/azsimple/images/logo.jpg",
		"type" => "text"),
	array(
		"name" => __('Favicon URL', 'azsimple'),
		"desc" => __('Enter the favicon URL', 'azsimple'),
		"id" => $shortname."_favicon",
		"std" => "http://azmind.com/wp-themes-demo2/wp-content/themes/azsimple/images/favicon.ico",
		"type" => "text"),
	array(
		"name" => __('Featured Posts Category', 'azsimple'),
		"desc" => __('Enter the name of the category that contains the featured posts', 'azsimple'),
		"id" => $shortname."_featuredcat",
		"std" => "Uncategorized",
		"type" => "text"),
	array(
		"name" => __('Number of Featured Posts', 'azsimple'),
		"desc" => __('Enter the number of featured posts you want to show', 'azsimple'),
		"id" => $shortname."_featurednr",
		"std" => 4,
		"type" => "text"),
	array(
		"name" => __('Facebook URL', 'azsimple'),
		"desc" => __('Enter your Facebook URL: http://....', 'azsimple'),
		"id" => $shortname."_facebook",
		"std" => "http://www.facebook.com/pages/Azmindcom/196582707093191",
		"type" => "text"),
	array(
		"name" => __('Twitter ID', 'azsimple'),
		"desc" => __('Enter your Twitter ID', 'azsimple'),
		"id" => $shortname."_twitter",
		"std" => "anli_zaimi",
		"type" => "text"),
	array(
		"name" => __('Number of Tweets', 'azsimple'),
		"desc" => __('Enter the number of tweets you want to show in the footer', 'azsimple'),
		"id" => $shortname."_tweetsnr",
		"std" => 4,
		"type" => "text"),
	array(
		"name" => __('Feedburner ID', 'azsimple'),
		"desc" => __('Enter your Feedburner ID', 'azsimple'),
		"id" => $shortname."_feedburner",
		"std" => "Azmind",
		"type" => "text"),
	array(
		"name" => __('About Us', 'azsimple'),
		"desc" => __('Enter a short presentation text', 'azsimple'),
		"id" => $shortname."_aboutus",
		"std" => "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Quisque sed felis. Aliquam sit amet felis. Mauris semper, velit semper laoreet dictum, <a href='http://azmind.com'>quam diam</a> dictum urna, nec placerat elit nisl in quam.
		<br />Etiam augue pede, molestie eget, rhoncus at, convallis ut, eros. Aliquam pharetra. Nulla in tellus eget odio sagittis blandit. Maecenas at nisl.",
		"type" => "textarea"),
	array(
		"name" => __('Header Advertising 468x60', 'azsimple'),
		"desc" => __('Enter advertising code', 'azsimple'),
		"id" => $shortname."_ads468x60",
		"std" => "<img src='http://azmind.com/wp-themes-demo2/wp-content/themes/azsimple/images/header-advertising.png' alt='advertising' />",
		"type" => "textarea"),
	array(
		"name" => __('Sidebar Advertising', 'azsimple'),
		"desc" => __('Enter advertising code', 'azsimple'),
		"id" => $shortname."_ads125x125",
		"std" => "<img src='http://azmind.com/wp-themes-demo2/wp-content/themes/azsimple/images/sidebar-advertising.png' alt='advertising' /> <img src='http://azmind.com/wp-themes-demo2/wp-content/themes/azsimple/images/sidebar-advertising.png' alt='advertising' />",
		"type" => "textarea"),
	array(
		"type" => "close")
	);

/* ------- Add a Theme Options Page ------- */
function mytheme_add_admin() {
	global $themename, $shortname, $options;
	if ($_GET['page'] == basename(__FILE__)) {
		if ('save' == $_REQUEST['action']) {
			foreach ($options as $value) {
				update_option($value['id'], $_REQUEST[$value['id']]);
			}
			header("Location: themes.php?page=functions.php&saved=true");
			die;
		} else if ('reset' == $_REQUEST['action']) {
			foreach ($options as $value) {
				delete_option($value['id']);
			}
			header("Location: themes.php?page=functions.php&reset=true");
			die;
		}
	}
	add_theme_page(sprintf(__('%s Options', 'azsimple'), $themename), sprintf(__('%s Options', 'azsimple'), $themename), 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {
	global $themename, $shortname, $options;
	if ($_REQUEST['saved']) echo '<div id="message" class="updated fade"><p><strong>' . sprintf(__('%s settings saved.', 'azsimple'), $themename) . '</strong></p></div>';
	if ($_REQUEST['reset']) echo '<div id="message" class="updated fade"><p><strong>' . sprintf(__('%s settings reset.', 'azsimple'), $themename) . '</strong></p></div>';

	echo "<div class=\"wrap\" style=\"margin:0 auto; padding:20px 0px 0px;\">";
	echo "<form method=\"post\">";
	foreach ($options as $value) {
		switch ($value['type']) {
			case "open":
				echo "<div style=\"width:808px; background:#eee; border:1px solid #ddd; padding:20px; overflow:hidden; display: block; margin: 0px 0px 30px;\">";
				break;
			case "close":
				echo "</div>";
				break;
			case "misc":
				echo "<div style=\"width:808px; background:#fffde2; border:1px solid #ddd; padding:20px; overflow:hidden; display: block; margin: 0px 0px 30px;\">";
				echo $value['name'];
				echo "</div>";
				break;
			case "title":
				echo "<div style=\"width:810px; height:22px; background:#555; padding:9px 20px; overflow:hidden; margin:0px; font-family:Verdana, sans-serif; font-size:18px; font-weight:normal; color:#EEE;\">";
				echo $value['name'];
				echo "</div>";
				break;
			case "text":
				echo "<div style=\"width:808px; padding:0px 0px 10px; margin:0px 0px 10px; border-bottom:1px solid #ddd; overflow:hidden;\">";
				echo "<span style=\"font-family:Arial, sans-serif; font-size:16px; font-weight:bold; color:#444; display:block; padding:5px 0px;\">";
				echo $value['name'];
				echo "</span>";
				if ($value['image'] != "") {
					echo "<div style=\"width:808px; padding:10px 0px; overflow:hidden;\">";
					echo "<img style=\"padding:5px; background:#FFF; border:1px solid #ddd;\" src=\"";
					echo bloginfo('template_url');
					echo "/images/" . $value['image'] . "\" alt=\"image\" />";
					echo "</div>";
				}
				echo "<input style=\"width:200px;\" name=\"";
				echo $value['id'];
				echo "\" id=\"";
				echo $value['id'];
				echo "\" type=\"";
				echo $value['type'];
				echo "\" value=\"";
				echo stripslashes(get_settings($value['id']));
				echo "\" />";
				echo "<br/>";
				echo "<span style=\"font-family:Arial, sans-serif; font-size:11px; font-weight:bold; color:#444; display:block; padding:5px 0px;\">";
				echo $value['desc'];
				echo "</span>";
				echo "</div>";
				break;
			case "textarea":
				echo "<div style=\"width:808px; padding:0px 0px 10px; margin:0px 0px 10px; border-bottom:1px solid #ddd; overflow:hidden;\">";
				echo "<span style=\"font-family:Arial, sans-serif; font-size:16px; font-weight:bold; color:#444; display:block; padding:5px 0px;\">";
				echo $value['name'];
				echo "</span>";
				if ($value['image'] != "") {
					echo "<div style=\"width:808px; padding:10px 0px; overflow:hidden;\">";
					echo "<img style=\"padding:5px; background:#FFF; border:1px solid #ddd;\" src=\"";
					bloginfo('template_url');
					echo "/images/";
					echo $value['image'];
					echo "\" alt=\"image\" />";
					echo "</div>";
				}
				echo "<textarea name=\"";
				echo $value['id'];
				echo "\" style=\"width:400px; height:200px;\" type=\"";
				echo $value['type'];
				echo "\" cols=\"\" rows=\"\">";
				echo stripslashes(get_settings($value['id']));
				echo "</textarea>";
				echo "<br/>";
				echo "<span style=\"font-family:Arial, sans-serif; font-size:11px; font-weight:bold; color:#444; display:block; padding:5px 0px;\">";
				echo $value['desc'];
				echo "</span>";
				echo "</div>";
				break;
			case "select":
				echo "<div style=\"width:808px; padding:0px 0px 10px; margin:0px 0px 10px; border-bottom:1px solid #ddd; overflow:hidden;\">";
				echo "<span style=\"font-family:Arial, sans-serif; font-size:16px; font-weight:bold; color:#444; display:block; padding:5px 0px;\">";
				echo $value['name'];
				echo "</span>";
				if ($value['image'] != "") {
					echo "<div style=\"width:808px; padding:10px 0px; overflow:hidden;\">";
					echo "<img style=\"padding:5px; background:#FFF; border:1px solid #ddd;\" src=\"";
					bloginfo('template_url');
					echo "/images/";
					echo $value['image'];
					echo "\" alt=\"image\" />";
					echo "</div>";
				}
				echo "<select style=\"width:240px;\" name=\"";
				echo $value['id'];
				echo "\" id=\"";
				echo $value['id'];
				echo "\">";
				foreach ($value['options'] as $option_value => $option_text) { 
					$checked = ' ';
					if (get_settings($value['id']) == $option_text) {
						$selected = ' selected="selected" ';
					} elseif (get_settings($value['id']) === FALSE && $value['std'] == $option_text){
						$selected = ' selected="selected" ';
					} else {
						$selected = ' ';
					}
					echo "<option value=\"";
					echo $option_text;
					echo "\"";
					echo $selected;
					echo ">";
					echo $option_text;
					echo "</option>";
				}
				echo "</select>";
				echo "<br/>";
				echo "<span style=\"font-family:Arial, sans-serif; font-size:11px; font-weight:bold; color:#444; display:block; padding:5px 0px;\">";
				echo $value['desc'];
				echo "</span>";
				echo "</div>";
				break;
			case "checkbox":
				echo "<div style=\"width:808px; padding:0px 0px 10px; margin:0px 0px 10px; border-bottom:1px solid #ddd; overflow:hidden;\">";
				echo "<span style=\"font-family:Arial, sans-serif; font-size:16px; font-weight:bold; color:#444; display:block; padding:5px 0px;\">";
				echo $value['name'];
				echo "</span>";
				if ($value['image'] != "") {
					echo "<div style=\"width:808px; padding:10px 0px; overflow:hidden;\">";
					echo "<img style=\"padding:5px; background:#FFF; border:1px solid #ddd;\" src=\"";
					bloginfo('template_url');
					echo "/images/";
					echo $value['image'];
					echo "\" alt=\"image\" />";
					echo "</div>";
				}
				if (get_option($value['id'])) {
					$checked = "checked=\"checked\"";
				} else {
					$checked = "";
				}
				echo "<input type=\"checkbox\" name=\"";
				echo $value['id'];
				echo "\" id=\"";
				echo $value['id'];
				echo "\" value=\"true\" ";
				echo $checked;
				echo "/>";
				echo "<br/>";
				echo "<span style=\"font-family:Arial, sans-serif; font-size:11px; font-weight:bold; color:#444; display:block; padding:5px 0px;\">";
				echo $value['desc'];
				echo "</span>";
				echo "</div>";
				break;
			case "submit":
				echo "<p class=\"submit\">";
				echo "<input name=\"save\" type=\"submit\" value=\"";
				_e('Save changes', 'azsimple');
				echo "\" />";
				echo "<input type=\"hidden\" name=\"action\" value=\"save\" />";
				echo "</p>";
				break;
		}
	}
	echo "<p class=\"submit\">";
	echo "<input name=\"save\" type=\"submit\" value=\"";
	_e('Save changes', 'azsimple');
	echo "\" />";
	echo "<input type=\"hidden\" name=\"action\" value=\"save\" />";
	echo "</p>";
	echo "</form>";
	echo "<form method=\"post\">";
	echo "<p class=\"submit\">";
	echo "<input name=\"reset\" type=\"submit\" value=\"";
	_e('Reset', 'azsimple');
	echo "\" />";
	echo "<input type=\"hidden\" name=\"action\" value=\"reset\" />";
	echo "</p>";
	echo "</form>";
}

function mytheme_wp_head() {}

add_action('wp_head', 'mytheme_wp_head');
add_action('admin_menu', 'mytheme_add_admin');
?>