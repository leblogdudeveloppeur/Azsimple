<?php get_header(); ?>
<div id="posts">
	<?php if (have_posts()) : ?>
		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php /* If this is a category archive */ if (is_category()) { ?>
			<div class="search-results"><h2><?php printf(__('Archive for the &#8216;%s&#8217; category:', 'azsimple'), single_cat_title('', false)); ?></h2></div>
		<?php /* If this is a tag archive */ } elseif (is_tag()) { ?>
			<div class="search-results"><h2><?php printf(__('Posts Tagged &#8216;%s&#8217;:', 'azsimple'), single_tag_title('', false)); ?></h2></div>
		<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<div class="search-results"><h2><?php $formatDate = __('F jS, Y', 'azsimple'); ?><?php printf(__('Archive for %s:', 'azsimple'), get_the_time($formatDate)); ?></h2></div>
		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<div class="search-results"><h2><?php $formatDate = __('F, Y', 'azsimple'); ?><?php printf(__('Archive for %s:', 'azsimple'), get_the_time($formatDate)); ?></h2></div>
		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<div class="search-results"><h2><?php $formatDate = __('Y', 'azsimple'); ?><?php printf(__('Archive for %s:', 'azsimple'), get_the_time($formatDate)); ?></h2></div>
		<?php /* If this is an author archive */ } elseif (is_author()) { ?>
			<div class="search-results"><h2><?php _e('Author Archive:', 'azsimple'); ?></h2></div>
		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<div class="search-results"><h2><?php _e('Blog Archives:', 'azsimple'); ?></h2></div>
		<?php } ?>
		<?php while (have_posts()) : the_post(); ?>
			<div class="single-post" id="post-<?php the_ID(); ?>">
				<div class="single-post-image"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php zt_get_thumbnail(); ?></a></div>
				<div class="single-post-text">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s:', 'azsimple'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
					<div class="meta">
						<?php $formatDate = __('M d Y', 'azsimple'); printf(__('Published on: <span>%1$s</span> by <span>%2$s</span> - ', 'azsimple'), get_the_time($formatDate), get_the_author()); ?><?php comments_popup_link(__('Leave a Comment', 'azsimple'), __('1 Comment', 'azsimple'), __('% Comments', 'azsimple')); ?>
					</div><!--meta-->
					<div class="single-post-content"><?php limits2(160, ""); ?></div>
				</div><!-- single-post-text -->
				<div class="clearfix"></div>
			</div><!-- single-post -->
		<?php endwhile; ?>
		<div class="posts-navigation">
			<div class="posts-navigation-next"><?php next_posts_link(__('Older Posts &raquo;', 'azsimple')) ?></div>
			<div class="posts-navigation-prev"><?php previous_posts_link(__('&laquo; Newer Posts', 'azsimple')) ?></div>
			<div class="clearfix"></div>
		</div>
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>