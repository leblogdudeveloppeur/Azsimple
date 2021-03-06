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
			<div id="footer">
				<div class="about-us">
					<h2><?php _e('About Us', 'azsimple'); ?></h2>
					<p><?php echo stripslashes($azs_aboutus); ?></p>
				</div><!-- about-us -->
				<div class="latest-tweets">
					<?php if ($azs_twitter !== '') { ?>
						<h2><?php _e('Latest Tweets', 'azsimple'); ?></h2>
						<ul id="twitter_update_list">
							<li><?php _e('Loading Tweets...', 'azsimple'); ?></li>
						</ul>
						<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
						<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $azs_twitter; ?>.json?callback=twitterCallback2&amp;count=<?php echo $azs_tweetsnr; ?>"></script>
					<?php } ?>
				</div><!-- latest-tweets -->
				<div class="subscribe">
					<h2><?php _e('Subscribe to our Newsletter', 'azsimple'); ?></h2>
					<p><?php _e('Enter your e-mail to get the latest posts and updates:', 'azsimple'); ?></p>
					<form action="http://feedburner.google.com/fb/a/mailverify" class="feedburner" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $azs_feedburner; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
						<input type="text" name="email" class="enteremail" value="<?php _e('Enter your e-mail', 'azsimple'); ?>" onfocus="if (this.value == '<?php _e('Enter your e-mail', 'azsimple'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Enter your e-mail', 'azsimple'); ?>';}" /><input type="hidden" value="<?php echo $azs_feedburner; ?>" name="uri"/><input type="hidden" name="loc" value="<?php _e('en_US', 'azsimple'); ?>"/>
						<input type="submit" value="<?php _e('Subscribe', 'azsimple'); ?>" class="formsubmit" />
					</form>
				</div><!-- subscribe -->
				<div id="footer-credits">
					<div class="footer-credits-left">
						<?php printf(__('&#169; Copyright %1$d - %2$s', 'azsimple'), date('Y'), get_bloginfo('name')); ?>
					</div>
					<div class="footer-credits-right">
						<?php _e('Powered by <a href="http://www.wordpress.org">Wordpress</a> - Azsimple Theme by <a href="http://azmind.com" title="Free Wordpress Themes and Web Design Resources">Azmind.com</a>', 'azsimple'); ?>
					</div>
				</div>
			</div><!-- footer -->
		</div><!-- content -->
		<?php wp_footer(); ?>
	</body>
</html>