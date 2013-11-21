<?php
/*
Section: DepthCharge
Author: etc.io
Author URI: http://www.etc.io
Version: 1.12
Description: DepthCharge
Workswith: templates, main, header, morefoot, content
Cloning: true
Class Name: etcDepthCharge
Filter: full-width
V3: true
*/

class etcDepthCharge extends PageLinesSection
{

	var $config;
	var $default_backdrops = 1;
	var $default_sprites = 0;
	var $sprite_format_upgrade_mapping = array(
		'image'     => 'sprite_%s_image',
		'class'     => 'sprite_%s_class',
		'type'      => 'sprite_%s_type',
		'heading'   => 'sprite_%s_heading',
		'color'     => 'sprite_%s_color',
		'textwidth' => 'sprite_%s_textwidth',
		'v_ratio'   => 'sprite_%s_v_ratio',
		'v_offset'  => 'sprite_%s_v_offset',
		'h_offset'  => 'sprite_%s_h_offset',
		'slingshot' => 'sprite_%s_slingshot'
  	);
  	var $backdrop_format_upgrade_mapping = array(
		'image'     => 'backdrop_%s_image',
		'v_ratio'   => 'backdrop_%s_v',
		'smartsize' => 'backdrop_%s_smartsize',
		'center'    => 'background_%s_center'
  	);

	function section_styles()
	{
		// Let's enqueue the skrollr and DC js libraries
		wp_enqueue_script('skrollr',		"{$this->base_url}/js/skrollr.min.js", array(), '0.6.17', true);
		wp_enqueue_script('etcDepthCharge', "{$this->base_url}/js/etcDepthCharge.min.js", array('jquery'), $this->settings['p_ver'], true);

		// array upgrade only needs to happen once per page

  		// Pull and process the sprite array
  		$sprite_array = $this->opt('sprite_array');
		$sprite_count = $this->opt('sprite_count', array('default' => $this->default_sprites) );
  		$sprite_array = $this->upgrade_to_array_format( 'sprite_array', $sprite_array, $this->sprite_format_upgrade_mapping, $sprite_count );

		// If any of the sprites are slabtext items, let's enqueue the slabtext js
		if ( !$sprite_array || $sprite_array == 'false' || !is_array( $sprite_array ) )
			$sprite_array = array( array(), array(), array() );

		$backdrop_array = $this->opt('backdrop_array');
		$backdrop_count = $this->opt('backdrop_count', array('default' => $this->default_backdrops) );
  		$backdrop_array = $this->upgrade_to_array_format( 'backdrop_array', $backdrop_array, $this->backdrop_format_upgrade_mapping, $backdrop_count );

		foreach ( $sprite_array as $sprite )
		{
			if ( 'slab' == pl_array_get('type', $sprite, 'img') )
			{
				wp_enqueue_script('slabtext', $this->base_url.'/js/jquery.slabtext.min.js',array(),'2.3',true);
				break;
			}
		}
	}

	function section_head( $clone_id = null )
	{
		$prefix       = !$clone_id ? "#depthcharge{$clone_id}" : '';
		$sprite_array = $this->opt('sprite_array');

  		// Let's output the proper font for each slab sprite

  		$i = 1;

		foreach ( $sprite_array as $sprite )
		{
			if ( 'slab' == pl_array_get('type', $sprite, 'image') )
			{
				$sprite_font = pl_array_get('font', $sprite, 'josefin_sans');
				echo load_custom_font( $sprite_font, "$prefix .depthChargeSprite:nth-child($i) h1" );
			}

			$i++;
		}
	}

	function section_opts() {
		return require 'inc/opts.php';
	}

	/**
	* Section template.
	*/
  	function section_template()
  	{
  		// Let's load up the backdrop and sprite arrays
  		$backdrop_array = $this->opt('backdrop_array');
  		$sprite_array = $this->opt('sprite_array');

		// Load all of the other options
		$height         = ($this->opt('height')) 			? $this->opt('height') 			: '400';
		$fullheight     = ($this->opt('fullheight')) 		? $this->opt('fullheight')		: '0';
		$contained      = ($this->opt('contained')) 		? 'overflow: hidden;'			: '0';
		$bd_v_ratios    = array();
		$sp_v_ratios    = array();
		$smartsizes     = array();
		$bd_centered    = array();
		$sp_v_offsets   = array();
		$sp_h_offsets   = array();
		$sp_slingshot   = array();

	  	// Process the backdrop array - this should eventually change
	  	if ( is_array( $backdrop_array ) )
	  	{
	  		foreach ( $backdrop_array as $backdrop )
	  		{
	  			$images[] 		= pl_array_get('image', $backdrop, 'http://f.cl.ly/items/1W2B0K2E0S3g3P0z2u1G/scuba_diving_gb.jpg');
	  			$bd_v_ratios[]	= pl_array_get('v_ratio', $backdrop, '-1.5');
	  			$smartsize[] 	= pl_array_get('smartsize', $backdrop, '0');
	  			$bd_centered[] 	= pl_array_get('center', $backdrop, '0');
	  		}
	  	}

	  	foreach ( $images as $image )
	  		$imageurls[] = "url('$image')";

		$imagesOutput = implode(",", $imageurls);

		if ( !$images )
		{
			echo setup_section_notify( $this );
			return;
		}
		else
		{
			if ( empty( $this->footer_action ) )
			{
				$this->footer_action = true;
				add_action('wp_print_footer_scripts', array(&$this, 'print_json') );
			}
		}

   		?>
		<div class="depthChargeBlock" id="<?php echo $id ?>" style="background-image: <?php echo $imagesOutput; ?>; height: <?php echo $height; ?>px; <?php echo $contained; ?>">
		<?php
		if( is_array($sprite_array) ){
	  		$sprites = count( $sprite_array );

	  		foreach( $sprite_array as $sprite ):
	  			$sp_v_ratios[] = pl_array_get( 'v_ratio', $sprite, '-1' );
	  			$sp_v_offsets[] = pl_array_get( 'v_offset', $sprite, '0' );
	  			$sp_h_offsets[] = pl_array_get( 'h_offset', $sprite, '0' );
	  			$sp_slingshot[] = pl_array_get( 'slingshot', $sprite, 0 );
	  		?>
	  			<div class="depthChargeSprite <?php echo $sprite['class']?>" style="<?php echo (pl_array_get( 'type', $sprite, 'img' ) == 'slab') ? 'width: '.pl_array_get( 'type', $sprite, 'textwidth' ) : '' ?>;">
					<?php if ( 'img' == pl_array_get( 'type', $sprite, 'img' )): ?>
						<img src="<?php echo pl_array_get( 'image', $sprite, 'http://f.cl.ly/items/1V3Y0p0W3G2i2z1L0c1R/PageLines-Logo.png') ?>" />
					<?php elseif ( pl_array_get( 'type', $sprite, 'img' ) == 'slab' ):  ?>
						<h1 style="color: <?php echo '#'.pl_array_get( 'color', $sprite, 'FFF' ) ?>;"><span class="slabtext"><?php pl_array_get( 'heading', $sprite, 'DepthCharge' ) ?></span></h1>
					<?php endif; ?>
				</div>
			<?php endforeach;
		}

		$id = $this->get_the_id();

		$this->config[ $id ] = array(
			'pl'           => pl_draft_mode(),
			'bg_ratio_v'   => $bd_v_ratios,
			'sp_ratio_v'   => $sp_v_ratios,
			'sp_offset_v'  => $sp_v_offsets,
			'sp_offset_h'  => $sp_h_offsets,
			'sp_slingshot' => $sp_slingshot,
			'bg_centered'  => $bd_centered,
			'bg_smartsize' => $smartsizes,
			'fullheight'   => $fullheight,
			'contained'    => (bool) $contained,
		);
	}

	/**
	 * Outputs JS config once in footer scripts
	 */
	function print_json()
	{
		if ( empty( $this->config ) )
			return;

		?>
		<!-- DepthCharge Config -->
		<script>
			jQuery(document).ready( function( $ ) {
				$('body').wrapInner('<div id="skrollr-body"/>');
			}( jQuery ) );
			<?php printf('var etc_dc_config = %s;', json_encode( (object) $this->config ) ); ?>
		</script>
		<?php
	}

} // etcDepthCharge