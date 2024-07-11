<?php
/**
 * Title: Latest Blog
 * Slug: travel-mates/latestBlog
 * Categories: travel-mates
 *
 * @package travel-mates
 * @since 1.0.0
 */

?>

<!-- wp:group {"style":{"spacing":{"padding":{"top":"80px","left":"0","right":"0"},"blockGap":"0"}},"backgroundColor":"bright","layout":{"type":"default"}} -->
<div id="latest-blog" class="wp-block-group has-bright-background-color has-background" style="padding-top:80px;padding-right:0;padding-left:0"><!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:heading {"textAlign":"left","level":3,"align":"wide","style":{"typography":{"fontSize":"40px","lineHeight":"1"}}} -->
<h3 class="wp-block-heading alignwide has-text-align-left" style="font-size:40px;line-height:1"><strong><?php echo esc_html__( 'Latest Blogs', 'travel-mates' ); ?></strong></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, ', 'travel-mates' ); ?><br><?php echo esc_html__( 'sed do eiusmod.', 'travel-mates' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"margin":{"top":"60px"},"blockGap":"0"}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="margin-top:60px"><!-- wp:query {"queryId":21,"query":{"perPage":"4","pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[]},"enhancedPagination":true,"align":"full","layout":{"type":"default"}} -->
<div class="wp-block-query alignfull"><!-- wp:post-template {"style":{"elements":{"link":{"color":{"text":"var:preset|color|bright"}}},"spacing":{"blockGap":"0"}},"textColor":"bright","layout":{"type":"grid","columnCount":4}} -->
<!-- wp:cover {"useFeaturedImage":true,"dimRatio":50,"overlayColor":"contrast","isUserOverlayColor":true,"minHeight":500,"minHeightUnit":"px","contentPosition":"bottom left","isDark":false,"style":{"border":{"radius":"0px"},"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-cover is-light has-custom-content-position is-position-bottom-left" style="border-radius:0px;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50);min-height:500px"><span aria-hidden="true" class="wp-block-cover__background has-contrast-background-color has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-date {"style":{"elements":{"link":{"color":{"text":"var:preset|color|bright"}}}},"textColor":"bright"} /-->

<!-- wp:post-title {"isLink":true,"style":{"typography":{"fontSize":"22px"},"spacing":{"margin":{"top":"0px","bottom":"10px"}},"elements":{"link":{"color":{"text":"var:preset|color|bright"}}}}} /-->

<!-- wp:post-excerpt {"excerptLength":10,"style":{"typography":{"fontSize":"16px"},"elements":{"link":{"color":{"text":"var:preset|color|bright"}}}},"textColor":"bright"} /--></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->