<?php
/*
Section: DepthCharge
Author: etc.io
Author URI: http://www.etc.io
Version: 1.2
Description: DepthCharge
Workswith: templates, main, header, morefoot, content
Cloning: true
Class Name: etcDepthCharge
Filter: full-width
V3: true
PageLines: true
*/

class etcDepthCharge extends PageLinesSection
{

	var $config;
	var $armed;
	var $default_backdrops = 1;
	var $default_sprites = 1;
	var $sprite_format_upgrade_mapping = array(
		'image'     => 'sprite_%s_image',
		'class'     => 'sprite_%s_class',
		'type'      => 'sprite_%s_type',
		'heading'   => 'sprite_%s_slab_heading',
		'color'     => 'sprite_%s_slab_color',
		'font'		=> 'sprite_%s_slab_font',
		'textwidth' => 'sprite_%s_slab_textwidth',
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

  	function section_persistent()
  	{
  		add_action( 'wp_enqueue_scripts', array(&$this, 'armed'), 20 );
  	}

	function section_styles()
	{
		$this->armed = true;
		// Let's enqueue the skrollr and DC js libraries
		wp_enqueue_script('skrollr',		"{$this->base_url}/js/skrollr.min.js", array(), '0.6.17', true);
		wp_enqueue_script('etcDepthCharge', "{$this->base_url}/js/etcDepthCharge.min.js", array('jquery'), $this->settings['p_ver'], true);
	}

	function armed()
	{
		if ( !$this->armed )
			return;

		// array upgrade only needs to happen once per page

  		// Pull and process the sprite array
  		$sprite_array = $this->opt('sprite_array');
		// count is determined by accordion now
		$sprite_count = ( is_array( $sprite_array ) && count( $sprite_array ) ) ? count( $sprite_array ) : $this->default_sprites;
  		$sprite_array = $this->upgrade_to_array_format( 'sprite_array', $sprite_array, $this->sprite_format_upgrade_mapping, $sprite_count );


		$backdrop_array = $this->opt('backdrop_array');

		// count is determined by accordion now
		$backdrop_count = ( is_array( $backdrop_array ) && count( $backdrop_array ) ) ? count( $backdrop_array ) : $this->default_backdrops;
  		$backdrop_array = $this->upgrade_to_array_format( 'backdrop_array', $backdrop_array, $this->backdrop_format_upgrade_mapping, $backdrop_count );

		if ( !$sprite_array || !is_array( $sprite_array ) )
			return;

		// If any of the sprites are slabtext items, let's enqueue the slabtext js
		foreach ( $sprite_array as $sprite )
		{
			if ( 'slab' == pl_array_get('type', $sprite) )
			{
				wp_enqueue_script('slabtext', "{$this->base_url}/js/jquery.slabtext.min.js",array(),'2.3',true);
				break;
			}
		}
	}

	function section_head( $clone_id = null )
	{
		if ( !$sprite_array = $this->opt('sprite_array') )
			return;

  		// Let's output the proper font for each slab sprite
  		$i = 1;
		$prefix = !$clone_id ? "#depthcharge{$clone_id}" : '';

		foreach ( $sprite_array as $sprite )
		{
			if ( 'slab' == pl_array_get('type', $sprite) )
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

  		// this looks weird but without it, it was coming up with 38 when the field was blank
  		// may have to do with scope cascade and getting into a global value
		$height = $this->opt('height', array('scope' => 'local') );
		$height = $height ? $height : $this->opt('height', array('scope' => 'type') );
		$height = $height ? $height : '400';

		// Load all of the other options
		$fullheight   = $this->opt('fullheight', array('default' => '0') );
		$contained    = $this->opt('contained', array('default' => '0') );
		$mobile		  = $this->opt('mobile', array('default' => '0') );
		$sprites 	  = $this->opt('sprites', array('default' => '0') );
		$bd_v_ratios  = array();
		$sp_v_ratios  = array();
		$smartsizes   = array();
		$bd_centered  = array();
		$sp_v_offsets = array();
		$sp_h_offsets = array();
		$sp_slingshot = array();
		$images       = array();
		$imageurls    = array();

	  	// Process the backdrop array - this should eventually change
	  	if ( is_array( $backdrop_array ) )
	  	{
	  		foreach ( $backdrop_array as $backdrop )
	  		{
	  			$images[] 		= pl_array_get('image', $backdrop, 'http://f.cl.ly/items/1W2B0K2E0S3g3P0z2u1G/scuba_diving_gb.jpg');
	  			$bd_v_ratios[]	= pl_array_get('v_ratio', $backdrop, '-1.5');
	  			$smartsizes[] 	= pl_array_get('smartsize', $backdrop, '0');
	  			$bd_centered[] 	= pl_array_get('center', $backdrop, '0');
	  		}
	  	}

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

			if ( $mobile )
			{
				add_action('wp_print_footer_scripts', array(&$this, 'dc_mobile') );	
			}
		}

	  	foreach ( $images as $image )
	  		$imageurls[] = "url('$image')";

		$imagesOutput = implode(",", $imageurls);

		$id = $this->get_the_id();
   		?>
		<div class="depthChargeBlock" id="<?php echo $id ?>" style="<?php echo "background-image: $imagesOutput; height: {$height}px; $contained" ?>">
		<?php

		if ( is_array( $sprite_array ) && $sprites )
		{
	  		foreach ( $sprite_array as $sprite )
	  		{
				$sp_v_ratios[]  = pl_array_get( 'v_ratio', $sprite, '-1' );
				$sp_v_offsets[] = pl_array_get( 'v_offset', $sprite, '0' );
				$sp_h_offsets[] = pl_array_get( 'h_offset', $sprite, '0' );
				$sp_slingshot[] = pl_array_get( 'slingshot', $sprite, 0 );

				$text_width = pl_array_get( 'textwidth', $sprite, '80%' );
				$width      = ( 'slab' == pl_array_get( 'type', $sprite, 'img' ) ) ? "width: $text_width" : '';
				$color      = pl_array_get( 'color', $sprite, 'FFF' );
				$class      = !empty( $sprite['class'] ) ? " {$sprite['class']}" : '';

		  		?>
	  			<div class="depthChargeSprite<?php echo $class ?>"
	  				style="<?php echo $width ?>;">
					<?php if ( 'img' == pl_array_get( 'type', $sprite, 'img' ) ): ?>
						<img src="<?php echo pl_array_get( 'image', $sprite, 'http://f.cl.ly/items/1V3Y0p0W3G2i2z1L0c1R/PageLines-Logo.png') ?>" />
					<?php elseif ( 'slab' == pl_array_get( 'type', $sprite, 'img' ) ): ?>
						<h1 style="color: <?php echo "#$color" ?>;">
							<span class="slabtext"><?php echo pl_array_get( 'heading', $sprite, 'DepthCharge' ) ?></span>
						</h1>
					<?php elseif ( 'code' == pl_array_get( 'type', $sprite, 'img' ) ): ?>
						<div>
							<?php echo pl_array_get( 'type', $sprite, '<div></div>') ?>
						</div>
					<?php endif; ?>
				</div>
				<?php
	  		}
		}


		$this->config[ $id ] = array(
			'pl'           => pl_draft_mode(),
			'bg_ratio_v'   => $bd_v_ratios,
			'sp_ratio_v'   => $sp_v_ratios,
			'sp_offset_v'  => $sp_v_offsets,
			'sp_offset_h'  => $sp_h_offsets,
			'sp_slingshot' => (bool) $sp_slingshot,
			'bg_centered'  => $bd_centered,
			'bg_smartsize' => $smartsizes,
			'fullheight'   => $fullheight,
			'contained'    => (bool) $contained,
			'mobile'	   => (bool) $mobile,
			'sprites'	   => (bool) $sprites,
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
			<?php printf('var etc_dc_config = %s;', json_encode( (object) $this->config ) ); ?>
		</script>
		<?php
	}

	/**
	 * Enable mobile support
	 */
	function dc_mobile()
	{
		if ( empty( $this->config ) )
			return;

		?>
		<!-- Mobile Support -->
		<script>
			jQuery(document).ready( function( $ ) {
				$('body').wrapInner('<div id="skrollr-body"></div>');
			}( jQuery ) );
		</script>
		<?php
	}

} // etcDepthCharge