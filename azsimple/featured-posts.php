<?php
	global $options;
	foreach ($options as $value) {
		if (get_settings($value['id']) === false) {
			$$value['id'] = $value['std'];
		} else {
			$$value['id'] = get_settings($value['id']);
		}
	}
?>
<div id="featured-posts">
	<ul>
		<?php $my_query = new WP_Query('showposts='.$azs_featurednr.'&category_name='.$azs_featuredcat); ?>
		<?php while ($my_query->have_posts()) : $my_query->the_post(); ?> 
			<li>
				<div class="featured-post-image">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php zt_get_thumbnail(null, 'featured-post-image'); ?></a>
				</div>
				<div class="featured-post-text">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<div><?php limits(120, __('Continue Reading', 'azsimple')); ?></div>
				</div>
				<div class="clearfix"></div>
			</li>
		<?php endwhile; ?>
	</ul>
	<div id="featured-posts-nav">
		<div></div>
	</div>
</div><!-- featured-posts -->