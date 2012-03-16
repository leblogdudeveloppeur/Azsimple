<?php get_header(); ?>

	<div id="content">

		<div id="posts">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div class="full-post" id="post-<?php the_ID(); ?>"> 

					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<div class="meta">
						Published on: <span><?php the_time('M d Y'); ?></span> by <span><?php the_author() ?></span>
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
