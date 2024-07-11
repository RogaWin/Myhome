<?php
/**
 * Title: Main Banner
 * Slug: travel-mates/mainBanner
 * Categories: travel-mates
 *
 * @package travel-mates
 * @since 1.0.0
 */

?>
<!-- wp:group {"style":{"color":{"background":"#f7f7f7"}},"layout":{"type":"default"}} -->
<div id="main-banner" class="wp-block-group has-background" style="background-color:#f7f7f7"><!-- wp:cover {"url":"<?php echo esc_url(get_theme_file_uri(  ));?>/assets/images/six.jpg","id":21,"dimRatio":20,"overlayColor":"contrast","isUserOverlayColor":true,"minHeight":700,"minHeightUnit":"px","contentPosition":"center center","metadata":{"name":""},"style":{"border":{"bottom":{"width":"0px","style":"none"}},"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"140px"}}},"className":"homepage-banner","layout":{"type":"constrained"}} -->
<div class="wp-block-cover homepage-banner" style="border-bottom-style:none;border-bottom-width:0px;padding-top:var(--wp--preset--spacing--80);padding-bottom:140px;min-height:700px"><span aria-hidden="true" class="wp-block-cover__background has-contrast-background-color has-background-dim-20 has-background-dim"></span><img class="wp-block-cover__image-background wp-image-21" alt="" src="<?php echo esc_url(get_theme_file_uri(  ));?>/assets/images/six.jpg" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"65px","lineHeight":"1"},"elements":{"link":{"color":{"text":"var:preset|color|bright"}}}},"textColor":"bright"} -->
<h2 class="wp-block-heading has-text-align-center has-bright-color has-text-color has-link-color" style="font-size:65px;line-height:1"><?php echo esc_html__( 'Lets travel the world', 'travel-mates' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"20px"}}} -->
<p class="has-text-align-center" style="font-size:20px"><?php echo esc_html__( 'Discover amzaing places at exclusive deals', 'travel-mates' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"align":"wide","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}},"color":{"background":"#ffffffb5"},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|60","right":"var:preset|spacing|60"},"margin":{"top":"50px","bottom":"50px"}},"border":{"radius":"10px"}},"textColor":"contrast","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide has-contrast-color has-text-color has-background has-link-color" style="border-radius:10px;background-color:#ffffffb5;margin-top:50px;margin-bottom:50px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--60)"><!-- wp:wptravel/trip-search {"searchBorderRadius":10,"align":"wide"} /--></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->