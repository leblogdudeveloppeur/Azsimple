<?php get_header(); ?>
<div id="posts">
	<?php if (have_posts()) : ?>
		<div class="search-results"><h2><?php printf(__('Search results for "%s":', 'azsimple'), get_search_query()); ?></h2></div>
		<?php while (have_posts()) : the_post(); ?>
			<div class="single-post" id="post-<?php the_ID(); ?>">
				<div class="single-post-image"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php zt_get_thumbnail(); ?></a></div>
				<div class="single-post-text">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'azsimple'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
					<div class="meta">
						<?php $formatTime = __('M d Y', 'azsimple'); ?><?php printf(__('Published on: <span>%1$s</span> by <span>%2$s</span> - ', 'azsimple'), get_the_time($formatTime), get_the_author()); ?><?php comments_popup_link(__('Leave a Comment', 'azsimple'), __('1 Comment', 'azsimple'), __('% Comments', 'azsimple')); ?>
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
	<?php else: ?>
		<div class="search-results"><h2><?php printf(__('Nothing found for "%s"!', 'azsimple'), get_search_query()); ?></h2></div>
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>