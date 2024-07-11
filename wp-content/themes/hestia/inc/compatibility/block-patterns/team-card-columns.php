<?php
/**
 * Patterns: Team card columns
 *
 * @package hestia
 */

$template_url = get_template_directory_uri();
return array(
	'title'      => __( 'Team card columns', 'hestia' ),
	'categories' => array( 'team' ),
	'content'    => '<!-- wp:cover {"overlayColor":"background_color","isDark":false,"align":"full"} -->
<div class="wp-block-cover alignfull is-light"><span aria-hidden="true" class="wp-block-cover__background has-background-color-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:spacer {"height":"64px"} -->
<div style="height:64px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:group {"style":{"border":{"radius":"5px"},"spacing":{"blockGap":"8px"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group" style="border-radius:5px"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Our Team</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"medium"} -->
<p class="has-text-align-center has-medium-font-size">This is the paragraph where you can write more details about your team.</p>
<!-- /wp:paragraph -->

<!-- wp:spacer {"height":"40px"} -->
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group"><!-- wp:group {"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:media-text {"align":"","mediaId":1,"mediaLink":"' . home_url() . '","mediaType":"image","mediaWidth":40,"verticalAlignment":"center","imageFill":true,"backgroundColor":"white","className":"card-shadow"} -->
<div class="wp-block-media-text is-stacked-on-mobile is-vertically-aligned-center is-image-fill card-shadow has-white-background-color has-background" style="grid-template-columns:40% auto"><figure class="wp-block-media-text__media" style="background-image:url(' . esc_url( $template_url . '/assets/img/1.jpg' ) . ');background-position:50% 50%"><img src="' . esc_url( $template_url . '/assets/img/1.jpg' ) . '" alt="a woman sitting on a train looking out the window" class="wp-image-1 size-full"/></figure><div class="wp-block-media-text__content"><!-- wp:spacer {"height":"24px"} -->
<div style="height:24px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:heading {"level":3,"fontSize":"medium"} -->
<h3 class="wp-block-heading has-medium-font-size">Desmond Purpleson</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"14px"}}} -->
<p style="font-size:14px">Locavore pinterest chambray affogato art party, forage coloring book typewriter. Bitters cold selfies, retro celiac sartorial mustache.</p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"size":"has-small-icon-size","style":{"spacing":{"blockGap":{"top":"8px","left":"8px"}}},"layout":{"type":"flex","justifyContent":"left"}} -->
<ul class="wp-block-social-links has-small-icon-size"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"twitter"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /--></ul>
<!-- /wp:social-links -->

<!-- wp:spacer {"height":"20px"} -->
<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div></div>
<!-- /wp:media-text -->

<!-- wp:spacer {"height":"0px","style":{"layout":{"flexSize":"10px","selfStretch":"fixed"}}} -->
<div style="height:0px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:media-text {"align":"","mediaId":2,"mediaLink":"' . home_url() . '","mediaType":"image","mediaWidth":40,"verticalAlignment":"center","imageFill":true,"backgroundColor":"white"} -->
<div class="wp-block-media-text is-stacked-on-mobile is-vertically-aligned-center is-image-fill has-white-background-color has-background" style="grid-template-columns:40% auto"><figure class="wp-block-media-text__media" style="background-image:url(' . esc_url( $template_url . '/assets/img/2.jpg' ) . ');background-position:50% 50%"><img src="' . esc_url( $template_url . '/assets/img/2.jpg' ) . '" alt="a woman sitting on a train looking out the window" class="wp-image-2 size-full"/></figure><div class="wp-block-media-text__content"><!-- wp:spacer {"height":"24px"} -->
<div style="height:24px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:heading {"level":3,"fontSize":"medium"} -->
<h3 class="wp-block-heading has-medium-font-size">Parsley Pepperspray</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"14px"}}} -->
<p style="font-size:14px">Craft beer salvia celiac mlkshk. Pinterest celiac tumblr, portland salvia skateboard cliche thundercats. Tattooed chia austin hell.</p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"size":"has-small-icon-size","style":{"spacing":{"blockGap":{"top":"8px","left":"8px"}}},"layout":{"type":"flex","justifyContent":"left"}} -->
<ul class="wp-block-social-links has-small-icon-size"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"twitter"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /--></ul>
<!-- /wp:social-links -->

<!-- wp:spacer {"height":"20px"} -->
<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div></div>
<!-- /wp:media-text --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:media-text {"align":"","mediaId":3,"mediaLink":"' . home_url() . '","mediaType":"image","mediaWidth":40,"verticalAlignment":"center","imageFill":true,"backgroundColor":"white"} -->
<div class="wp-block-media-text is-stacked-on-mobile is-vertically-aligned-center is-image-fill has-white-background-color has-background" style="grid-template-columns:40% auto"><figure class="wp-block-media-text__media" style="background-image:url(' . esc_url( $template_url . '/assets/img/3.jpg' ) . ');background-position:50% 50%"><img src="' . esc_url( $template_url . '/assets/img/3.jpg' ) . '" alt="a bush of lilacs in full bloom on a sunny day" class="wp-image-3 size-full"/></figure><div class="wp-block-media-text__content"><!-- wp:spacer {"height":"24px"} -->
<div style="height:24px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:heading {"level":3,"fontSize":"medium"} -->
<h3 class="wp-block-heading has-medium-font-size">Desmond Eagle</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"14px"}}} -->
<p style="font-size:14px">Locavore pinterest chambray affogato art party, forage coloring book typewriter. Bitters cold selfies, retro celiac sartorial mustache.</p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"size":"has-small-icon-size","style":{"spacing":{"blockGap":{"top":"8px","left":"8px"}}},"layout":{"type":"flex","justifyContent":"left"}} -->
<ul class="wp-block-social-links has-small-icon-size"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"twitter"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /--></ul>
<!-- /wp:social-links -->

<!-- wp:spacer {"height":"20px"} -->
<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div></div>
<!-- /wp:media-text -->

<!-- wp:spacer {"height":"0px","style":{"layout":{"flexSize":"10px","selfStretch":"fixed"}}} -->
<div style="height:0px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:media-text {"align":"","mediaId":4,"mediaLink":"' . home_url() . '","mediaType":"image","mediaWidth":40,"verticalAlignment":"center","imageFill":true,"backgroundColor":"white"} -->
<div class="wp-block-media-text is-stacked-on-mobile is-vertically-aligned-center is-image-fill has-white-background-color has-background" style="grid-template-columns:40% auto"><figure class="wp-block-media-text__media" style="background-image:url(' . esc_url( $template_url . '/assets/img/4.jpg' ) . ');background-position:50% 50%"><img src="' . esc_url( $template_url . '/assets/img/4.jpg' ) . '" alt="a bush of lilacs in full bloom on a sunny day" class="wp-image-4 size-full"/></figure><div class="wp-block-media-text__content"><!-- wp:spacer {"height":"24px"} -->
<div style="height:24px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:heading {"level":3,"fontSize":"medium"} -->
<h3 class="wp-block-heading has-medium-font-size">Ruby Von Rails</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"14px"}}} -->
<p style="font-size:14px">Craft beer salvia celiac mlkshk. Pinterest celiac tumblr, portland salvia skateboard cliche thundercats. Tattooed chia austin hell.</p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"size":"has-small-icon-size","style":{"spacing":{"blockGap":{"top":"8px","left":"8px"}}},"layout":{"type":"flex","justifyContent":"left"}} -->
<ul class="wp-block-social-links has-small-icon-size"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"twitter"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /--></ul>
<!-- /wp:social-links -->

<!-- wp:spacer {"height":"20px"} -->
<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div></div>
<!-- /wp:media-text --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:spacer {"height":"64px"} -->
<div style="height:64px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div></div>
<!-- /wp:cover -->',
);
