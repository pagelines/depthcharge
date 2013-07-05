<?php
/*
Section: DepthCharge
Author: etc.io
Author URI: http://www.etc.io
Version: 1.0
Description: DepthCharge
Workswith: templates, main, header, morefoot, content
Cloning: true
Class Name: etcDepthCharge
Filter: full-width
V3: true
*/

class etcDepthCharge extends PageLinesSection {

	function section_styles(){
		wp_enqueue_script('skrollr', $this->base_url.'/js/skrollr.js',array(),'0.6.8',true);
		wp_enqueue_script('etcDepthCharge', $this->base_url.'/js/etcDepthCharge.min.js',array('jquery'),'1.0b',true);
		$sprites = ($this->opt('sprite_count')) ? $this->opt('sprite_count') : $this->default_sprites;
		for($i = 1; $i <= $sprites; $i++){
			if( $this->opt('sprite'.$i.'_type') == 'text' ):
				wp_enqueue_script('slabtext', $this->base_url.'/js/jquery.slabtext.min.js',array(),'2.3',true);
				break;
			endif;
		}
	}

	function section_head( $clone_id ){
		$prefix = ($clone_id != '') ? '#DepthCharge'.$clone_id : '';
		$sprites = ($this->opt('sprite_count')) ? $this->opt('sprite_count') : $this->default_sprites;

		for($i = 1; $i <= $sprites; $i++){
			if( $this->opt('sprite'.$i.'_type') == 'text' ):
				$sprite_font = ($this->opt('sprite'.$i.'_font')) ? $this->opt('sprite'.$i.'_font') : 'josefin_sans';
				echo load_custom_font( $sprite_font, $prefix.' .depthChargeSprite:nth-child('.$i.') h1' );
			endif;
		}
	}

	var $default_backdrops = 1;
	var $default_sprites = 1;

	function section_opts() {
		$options = array();
		$options[] = array(
				'title'	=> 'Block Options',
				'type'	=> 'multi',
				'opts'	=> array(
						array(
								'type'		=> 'text',
								'key'		=> 'height',
								'default'	=>	'400',
								'label'		=> 'Block Height',
						),
						array(
								'type'		=> 'count_select',
								'key'		=> 'backdrop_count',
								'count_start'	=> '1',
								'count_number'	=> '12',
								'default'	=> '1',
								'label'		=> 'Number of Backdrops'
						),
						array(
								'type'		=> 'count_select',
								'key'		=> 'sprite_count',
								'count_start'	=> '1',
								'count_number'	=> '12',
								'default'	=> '1',
								'label'		=> 'Number of Sprites'
						),
						array(
								'type'		=> 'check',
								'key'		=> 'fullheight',
								'default'	=> '0',
								'label'		=> 'Full Height? (overrides height)',
						),
						array(
								'type'		=> 'check',
								'default'	=> '0',
								'key'		=> 'contained',
								'label'		=> 'Contain elements? (Overflow: Hidden)',
						)
					)
				);

		$sprites = ($this->opt('sprite_count')) ? $this->opt('sprite_count') : $this->default_sprites;
		$backdrops = ($this->opt('backdrop_count')) ? $this->opt('backdrop_count') : $this->default_backdrops;

		for($i = 1; $i <= $backdrops; $i++ ){
			$opts = array(
						array(
									'type' 		=> 'select',
									'key'			=> 'background'.$i.'_vspeed',
									'label' 	=> 'Scrolling Speed',
									'default'	=> '.5',
									'opts'		=> array(
										'5'			=> array('name' => 'Lightning Reverse'),
										'2'			=> array('name' => 'Speedy Reverse'),
										'1.5'		=> array('name' => 'Fast Reverse'),
										'1.25'		=> array('name' => 'Heightened Reverse'),
										'1'			=> array('name' => 'Reverse'),
										'.5'		=> array('name' => 'Half Reverse'),
										'.25'		=> array('name' => 'Slow Reverse'),
										'.1'		=> array('name' => 'Turtle Reverse'),
										'-.6'		=> array('name' => 'Turtle Forward'),
										'-.75'		=> array('name' => 'Slow Forward'),
										'-1'		=> array('name' => 'Half Forward'),
										'-1.5'		=> array('name' => 'Forward'),
										'-1.75'		=> array('name' => 'Heightened Forward'),
										'-2'		=> array('name' => 'Fast Forward'),
										'-2.5'		=> array('name' => 'Speedy Forward'),
										'-5.5'		=> array('name' => 'Lightning')
															)
														),
						array(
			            			'key'           => 'background'.$i.'_image',
			            			'label'			=> 'Background Image',
			            			'default'		=> 'http://f.cl.ly/items/1W2B0K2E0S3g3P0z2u1G/scuba_diving_gb.jpg',
			            			'type'          => 'image_upload',
			            			'imgsize'       => '256',        // The image preview 'max' size
			            			'sizelimit'     => '2048000'     // Image upload max size default 512kb
			        									),
						array(
									'type'		=> 'check',
									'default'	=> '0',
									'key'			=> 'background'.$i.'_smartsize',
									'label'		=> 'SmartSize'
														),
						array(
									'type'		=> 'check',
									'default'	=> '0',
									'key'			=> 'background'.$i.'_center',
									'label'		=> 'Center'
														),
						);
			$options[] = array(
							'title'		=> 'Background ' . $i,
							'type'		=> 'multi',
							'opts'		=> $opts,
						);
		}

		for($i = 1; $i <= $sprites; $i++ ){
			$sprite_type = ($this->opt('sprite'.$i.'_type')) ? $this->opt('sprite'.$i.'_type') : 'img';
			$opts = array(
						array(
								'type' 		=> 'select',
								'key'			=> 'sprite'.$i.'_vspeed',
								'label' 	=> 'Scrolling Speed',
								'default'	=> '.5',
								'opts'		=> array(
										'5'      => array('name' => 'Lightning Reverse'),
										'2'      => array('name' => 'Speedy Reverse'),
										'1.5'    => array('name' => 'Fast Reverse'),
										'1.25'    => array('name' => 'Heightened Reverse'),
										'1'      => array('name' => 'Reverse'),
										'.5'    => array('name' => 'Half Reverse'),
										'.25'    => array('name' => 'Slow Reverse'),
										'.1'    => array('name' => 'Turtle Reverse'),
										'-.1'    => array('name' => 'Turtle Forward'),
										'-.25'    => array('name' => 'Slow Forward'),
										'-.5'    => array('name' => 'Half Forward'),
										'-1'    => array('name' => 'Forward'),
										'-1.25'    => array('name' => 'Heightened Forward'),
										'-1.5'    => array('name' => 'Fast Forward'),
										'-2'    => array('name' => 'Speedy Forward'),
										'-5'    => array('name' => 'Lightning')
															)
														),
						array(
									'type'		=> 'check',
									'default'	=> '0',
									'key'			=> 'sprite'.$i.'_slingshot',
									'label'		=> 'Slingshot Mode'
														),
						array(
									'type'		=> 'text',
									'key'			=> 'sprite'.$i.'_class',
									'label'		=> 'Custom Class'
														),
						array(
									'type'		=> 'text',
									'key'			=> 'sprite'.$i.'_voffset',
									'label'		=> 'Sprite Vertical Offset'
														),
						array(
									'type'		=> 'text',
									'key'			=> 'sprite'.$i.'_hoffset',
									'label'		=> 'Sprite Horizontal Offset'
														),
						array(
									'type' 		=> 'select',
									'key'		=> 'sprite'.$i.'_type',
									'default'	=> 'text',
									'label' 	=> 'Type of Sprite',
									'opts'		=> array(
										'img'		=> array('name' => 'Image'),
										'text'	=> array('name' => 'SlabText'),
															)
														),
												);
			if ( $sprite_type == 'img' ):
				$opts[] = array(
			            	'key'           => 'sprite'.$i.'_image',
			            	'label'			=> 'Sprite Image',
			            	'type'          => 'image_upload',
			            	'imgsize'       => '256',        // The image preview 'max' size
			           		'sizelimit'     => '2048000'     // Image upload max size default 512kb
			        		);
			elseif ( $sprite_type == 'text' ):
				$opts[] = array(
			            	'key'           => 'sprite'.$i.'_text',
			            	'label'			=> 'Text',
			            	'type'          => 'text',
			            	'default'		=> 'DepthCharge'
			        		);
				$opts[] = array(
			            	'key'           => 'sprite'.$i.'_font',
			            	'label'			=> 'Font',
			            	'default'		=> 'josefin_sans',
			            	'type'          => 'type'
			        		);
				$opts[] = array(
							'type' 		=> 'select',
							'key'			=> 'sprite'.$i.'_textwidth',
							'label' 	=> 'SlabText Width',
							'default'	=> '80%',
							'opts'		=> array(
								'100%'		=> array('name' => '100%'),
								'90%'		=> array('name' => '90%'),
								'80%'		=> array('name' => '80%'),
								'70%'		=> array('name' => '70%'),
								'60%'		=> array('name' => '60%'),
								'50%'		=> array('name' => '50%'),
								'40%'		=> array('name' => '40%'),
								'30%'		=> array('name' => '30%'),
								'20%'		=> array('name' => '20%'),
								'10%'		=> array('name' => '10%'),
											)
							);
				$opts[] = array(
			            	'key'           => 'sprite'.$i.'_color',
			            	'label'			=> 'Text Color',
			            	'type'          => 'color',
			            	'default'		=> 'FFFFFF'
			        		);
			endif;

			$options[] = array(
							'title'		=> 'Sprite ' . $i,
							'type'		=> 'multi',
							'opts'		=> $opts,
						);
		}

		return $options;
	}

	/**
	* Section template.
	*/
  	function section_template() {
	  	$sprite_count = ($this->opt('sprite_count')) ? $this->opt('sprite_count') : 0;
	  	$backdrop_count = ($this->opt('backdrop_count')) ? $this->opt('backdrop_count') : 1;
	  	$sp_v_ratios = false;

	  	$i = 0;
	  	while ($i++ < $backdrop_count ):
	  		$images[] = ($this->opt('background'.$i.'_image')) ? $this->opt('background'.$i.'_image') : 'http://f.cl.ly/items/1W2B0K2E0S3g3P0z2u1G/scuba_diving_gb.jpg';
	  		$bg_v_ratios[] = ($this->opt('background'.$i.'_vspeed')) ? $this->opt('background'.$i.'_vspeed') : '-1.5';
	  		$resizes[] = ($this->opt('background'.$i.'_smartsize')) ? $this->opt('background'.$i.'_smartsize') : '1';
	  		$bg_centered[] = ($this->opt('background'.$i.'_center')) ? $this->opt('background'.$i.'_center') : '1';
	  	endwhile;

	  	$i = 0;
	  	while( $i++ < $sprite_count ):
	  		$s_image = ($this->opt('sprite'.$i.'_image')) ? $this->opt('sprite'.$i.'_image') : 'http://f.cl.ly/items/1V3Y0p0W3G2i2z1L0c1R/PageLines-Logo.png';
	  		if( $this->opt('sprite'.$i.'_type') == 'img' ):
		  		$sprites[] = array( 
		  			'image' => $this->opt('sprite'.$i.'_image'),
		  			'class' => $this->opt('sprite'.$i.'_class'),
		  			'type' => $this->opt('sprite'.$i.'_type'));
		  	elseif( $this->opt('sprite'.$i.'_type') == 'text'):
		  		$sprites[] = array( 
		  			'class' => $this->opt('sprite'.$i.'_class'),
		  			'type' => $this->opt('sprite'.$i.'_type'),
		  			'text' => $this->opt('sprite'.$i.'_text'),
		  			'color' => $this->opt('sprite'.$i.'_color'),
		  			'textwidth' => $this->opt('sprite'.$i.'_textwidth'));
		  	endif;
	  		$sp_v_ratios[] = ($this->opt('sprite'.$i.'_vspeed')) ? $this->opt('sprite'.$i.'_vspeed') : '-1';
	  		$sp_v_offsets[] = ($this->opt('sprite'.$i.'_voffset')) ? $this->opt('sprite'.$i.'_voffset') : '0';
	  		$sp_h_offsets[] = ($this->opt('sprite'.$i.'_hoffset')) ? $this->opt('sprite'.$i.'_hoffset') : '0';
	  		$sp_slingshot[] = ($this->opt('sprite'.$i.'_slingshot')) ? $this->opt('sprite'.$i.'_slingshot') : 0;
	  	endwhile;

	  	$height = ($this->opt('height')) ? $this->opt('height') : '400';
	  	$fullheight = ($this->opt('fullheight')) ? $this->opt('fullheight') : '0';
	  	$contained = ($this->opt('contained')) ? 'overflow: hidden;' : '0';

	  	foreach ( $images as $image ){
	  		$imageurls[] = "url('$image')";
	  	}
		$imagesOutput = implode(",", $imageurls);

		if( !$images ){
			echo setup_section_notify($this);
			return;
		}

		$bg_v_ratios = json_encode($bg_v_ratios);
   		if( isset($sp_v_ratios) ):
			$sp_v_ratios = json_encode($sp_v_ratios);
		endif;
   		if( isset($sp_v_offsets) ):
			$sp_v_offsets = json_encode($sp_v_offsets);
		endif;
   		if( isset($sp_slingshot) ):
			$sp_slingshot = json_encode($sp_slingshot);
		endif;
   		if( isset($sp_h_offsets) ):
			$sp_h_offsets = json_encode($sp_h_offsets);
		endif;
		$bg_centered = json_encode($bg_centered);
		$resizes = json_encode($resizes);
		$id = $this->oset['clone_id'];

		if( pl_draft_mode() ){
    		$pl = 1;
		} else {
			$pl = 0;
		};

   	?>
   		<script>
   			var etc_dc_config = etc_dc_config || [];
   			etc_dc_config['<?= $id ?>'] = [];
   			var c = etc_dc_config['<?= $id ?>'];
   			c.bg_ratio_v = <?= $bg_v_ratios; ?>;
   			<?php if( isset($sp_v_ratios) ): ?>
   			c.sp_ratio_v = <?= $sp_v_ratios; ?>;
   			<?php endif; ?>
   			<?php if( isset($sp_v_offsets) ): ?>
   			c.sp_offset_v = <?= $sp_v_offsets; ?>;
   			<?php endif; ?>
   			<?php if( isset($sp_h_offsets) ): ?>
   			c.sp_offset_h = <?= $sp_h_offsets; ?>;
   			<?php endif; ?>
   			<?php if( isset($sp_slingshot) ): ?>
   			c.sp_slingshot = <?= $sp_slingshot; ?>;
   			<?php endif; ?>
   			c.bg_centered = <?= $bg_centered; ?>;
   			c.bg_smartsize = <?= $resizes; ?>;
   			c.fullheight = <?= $fullheight ?>;
   			c.pl = <?= $pl ?>;
   		</script>
		<div class="depthChargeBlock" id="<?= $id ?>" style="background-image: <?= $imagesOutput; ?>; height: <?= $height; ?>px; <?= $contained; ?>">
	<?php if( isset($sprites) ): ?>
		<?php foreach( $sprites as $sprite ): ?>
				<div class="depthChargeSprite <?= $sprite['class']?>" style="<?php echo ($sprite['type'] == 'text') ? 'width: '.$sprite['textwidth'] : '' ?>;">
					<?php if ( $sprite['type'] == 'img' ): ?>
					<img src="<?= $sprite['image'] ?>" />
					<?php elseif ( $sprite['type'] == 'text' ):  ?>
					<h1 style="color: <?= '#'.$sprite['color'] ?>;"><span class="slabtext"><?= $sprite['text'] ?></span></h1>
					<?php endif; ?>
				</div>
		<?php endforeach; ?>
	<?php endif; ?>
		</div>
		<?php
	}
}