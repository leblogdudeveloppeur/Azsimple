<?php get_header(); ?>

	<div id="content">

		<div id="posts">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div class="full-post" id="post-<?php the_ID(); ?>"> 

					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
					<div class="meta">
						<?php $timeFormat = __('M d Y'); printf(__('Published on: <span>%1$s</span> by <span>%2$s</span>'), get_the_time($timeFormat), get_the_author()); ?>
					</div><!--meta-->
 
					<div class="full-post-content"><?php the_content(); ?></div>

					<div class="full-post-pages"><?php wp_link_pages(); ?></div>

					<div class="meta">
						<?php _e('Filed under: '); the_category(__(', ')); ?> <?php the_tags(__('Tags: '), __(', '), __('')); ?> <?php edit_post_link(__('Edit'), __(' &#124; '), __('')); ?>
					</div>

					<div class="clearfix"></div>

					<?php comments_template(); ?>

				</div><!-- full-post -->

				<?php endwhile; ?>

			<?php endif; ?>

		</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
