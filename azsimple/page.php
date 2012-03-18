<?php get_header(); ?>
<div id="posts">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<div class="full-post" id="post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'azsimple'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
				<div class="meta">
					<?php $timeFormat = __('M d Y', 'azsimple'); ?><?php printf(__('Published on: <span>%1$s</span> by <span>%2$s</span>', 'azsimple'), get_the_time($formatTime), get_the_author()); ?>
				</div><!--meta-->
				<div class="full-post-content"><?php the_content(); ?></div>
				<div class="full-post-pages"><?php wp_link_pages(); ?></div>
				<div class="meta"></div>
				<div class="clearfix"></div>
				<?php comments_template(); ?>
			</div><!-- full-post -->
		<?php endwhile; ?>
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>