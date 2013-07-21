<?php
/*
Section: DepthCharge
Author: etc.io
Author URI: http://www.etc.io
Version: 1.0c
Description: DepthCharge
Workswith: templates, main, header, morefoot, content
Cloning: true
Class Name: etcDepthCharge
Filter: full-width
V3: true
*/

class etcDepthCharge extends PageLinesSection {

	var $default_backdrops = 1;
	var $default_sprites = 0;

	function section_styles() {

		wp_enqueue_script('skrollr',		$this->base_url.'/js/skrollr.min.js', array(), '0.6.8', true);
		wp_enqueue_script('etcDepthCharge', $this->base_url.'/js/etcDepthCharge.min.js', array('jquery'), $this->settings['p_ver'], true);

		$sprites = $this->opt('sprite_count', array('default' => $this->default_sprites));

		for ( $i = 1; $i <= (int) $sprites; $i++ ) {
			if ( $this->opt('sprite'.$i.'_type') == 'text' ) {
				wp_enqueue_script('slabtext', $this->base_url.'/js/jquery.slabtext.min.js',array(),'2.3',true);
				break;
			}
		}
	}

	function section_head( $clone_id ){
		$prefix = ($clone_id != '') ? '#DepthCharge'.$clone_id : '';
		$sprites = ($this->opt('sprite_count')) ? $this->opt('sprite_count') : $this->default_sprites;

		for ( $i = 1; $i <= $sprites; $i++ ) {
			if ( $this->opt('sprite'.$i.'_type') == 'text' ):
				$sprite_font = ($this->opt('sprite'.$i.'_font')) ? $this->opt('sprite'.$i.'_font') : 'josefin_sans';
				echo load_custom_font( $sprite_font, $prefix.' .depthChargeSprite:nth-child('.$i.') h1' );
			endif;
		}
	}

	function skrollr_open() {
		echo '<div id="skrollr-body" class="etcDepthCharge-body">';
	}

	function skrollr_close() {
		echo '</div>';
	}


	function section_opts() {
		return require 'inc/opts.php';
	}

	/**
	* Section template.
	*/
  	function section_template() {
		
		$sprite_count   = ($this->opt('sprite_count')) 		? $this->opt('sprite_count')	: 0;
		$backdrop_count = ($this->opt('backdrop_count')) 	? $this->opt('backdrop_count') 	: 1;
		$height         = ($this->opt('height')) 			? $this->opt('height') 			: '400';
		$fullheight     = ($this->opt('fullheight')) 		? $this->opt('fullheight')		: '0';
		$contained      = ($this->opt('contained')) 		? 'overflow: hidden;'			: '0';
		$bg_v_ratios    = array();
		$sp_v_ratios    = array();
		$resizes        = array();
		$bg_centered    = array();
		$sprites        = array();
		$sp_v_offsets   = array();
		$sp_h_offsets   = array();
		$sp_slingshot   = array();

	  	$i = 0;
	  	while ( $i++ < $backdrop_count ):
			$images[]      = ($this->opt('background'.$i.'_image')) 	? $this->opt('background'.$i.'_image') 		: 'http://f.cl.ly/items/1W2B0K2E0S3g3P0z2u1G/scuba_diving_gb.jpg';
			$bg_v_ratios[] = ($this->opt('background'.$i.'_vspeed')) 	? $this->opt('background'.$i.'_vspeed') 	: '-1.5';
			$resizes[]     = ($this->opt('background'.$i.'_smartsize')) ? $this->opt('background'.$i.'_smartsize') 	: '0';
			$bg_centered[] = ($this->opt('background'.$i.'_center')) 	? $this->opt('background'.$i.'_center') 	: '0';
	  	endwhile;

	  	$i = 0;
	  	while ( $i++ < $sprite_count ):
	  		$s_image = ($this->opt('sprite'.$i.'_image')) ? $this->opt('sprite'.$i.'_image') : 'http://f.cl.ly/items/1V3Y0p0W3G2i2z1L0c1R/PageLines-Logo.png';
	  	
	  		if ( $this->opt('sprite'.$i.'_type') == 'img' ):
		  		$sprites[] = array( 
					'image' => $this->opt('sprite'.$i.'_image'),
					'class' => $this->opt('sprite'.$i.'_class'),
					'type'  => $this->opt('sprite'.$i.'_type')
				);
		  	elseif ( $this->opt('sprite'.$i.'_type') == 'text'):
		  		$sprites[] = array( 
					'class'     => $this->opt('sprite'.$i.'_class'),
					'type'      => $this->opt('sprite'.$i.'_type'),
					'text'      => $this->opt('sprite'.$i.'_text'),
					'color'     => $this->opt('sprite'.$i.'_color'),
					'textwidth' => $this->opt('sprite'.$i.'_textwidth')
				);
		  	endif;

			$sp_v_ratios[]  = ($this->opt('sprite'.$i.'_vspeed'))		? $this->opt('sprite'.$i.'_vspeed')		: '-1';
			$sp_v_offsets[] = ($this->opt('sprite'.$i.'_voffset'))		? $this->opt('sprite'.$i.'_voffset')	: '0';
			$sp_h_offsets[] = ($this->opt('sprite'.$i.'_hoffset'))		? $this->opt('sprite'.$i.'_hoffset')	: '0';
			$sp_slingshot[] = ($this->opt('sprite'.$i.'_slingshot'))	? $this->opt('sprite'.$i.'_slingshot')	: 0;
	  	endwhile;


	  	foreach ( $images as $image )
	  		$imageurls[] = "url('$image')";
	  	
		$imagesOutput = implode(",", $imageurls);

		if ( !$images ) {
			echo setup_section_notify( $this );
			return;
		}
		else {
			if ( empty( $this->footer_action ) ) {
				$this->footer_action = true;
				add_action('wp_print_footer_scripts', array(&$this, 'print_json') );
			}
		}

		$id = $this->get_the_id();

		$this->config[ $id ] = array(
			'pl'           => pl_draft_mode(),
			'bg_ratio_v'   => $bg_v_ratios,
			'sp_ratio_v'   => $sp_v_ratios,
			'sp_offset_v'  => $sp_v_offsets,
			'sp_offset_h'  => $sp_h_offsets,
			'sp_slingshot' => $sp_slingshot,
			'bg_centered'  => $bg_centered,
			'bg_smartsize' => $resizes,
			'fullheight'   => $fullheight,
			'contained'    => (bool) $contained,
		);

		add_action( 'pagelines_before_site', array(&$this, 'skrollr_open'), 9 );
		add_action( 'wp_footer', array(&$this, 'skrollr_close' ));

   		?>
		<div class="depthChargeBlock" id="<?php echo $id ?>" style="background-image: <?php echo $imagesOutput; ?>; height: <?php echo $height; ?>px; <?php echo $contained; ?>">
		<?php
		foreach( $sprites as $sprite ):
			?>
			<div class="depthChargeSprite <?php echo $sprite['class']?>" style="<?php echo ($sprite['type'] == 'text') ? 'width: '.$sprite['textwidth'] : '' ?>;">
				<?php if ( 'img' == $sprite['type'] ): ?>
				<img src="<?php echo $sprite['image'] ?>" />
				<?php elseif ( $sprite['type'] == 'text' ):  ?>
				<h1 style="color: <?php echo '#'.$sprite['color'] ?>;"><span class="slabtext"><?php echo $sprite['text'] ?></span></h1>
				<?php endif; ?>
			</div>
			<?php
		endforeach;
		?>
		</div>
		<?php
	}

	/**
	 * Outputs JS config once in footer scripts
	 */
	function print_json() {

		if ( empty( $this->config ) )
			return;

		?>
		<!-- DepthCharge Config -->
		<script>
		<?php printf('var etc_dc_config = %s;', json_encode( (object) $this->config ) ); ?>
		</script>
		<?php
	}
}