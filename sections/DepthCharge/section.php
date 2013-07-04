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
		wp_enqueue_script('etcDepthCharge', $this->base_url.'/js/etcDepthCharge.js',array('jquery'));
		wp_enqueue_script('skrollr', $this->base_url.'/js/skrollr.js');
	}

	function section_head( $clone_id ){
		$prefix = ($clone_id != '') ? '.clone_'.$clone_id : '';
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
			            			'type'          => 'image_upload',
			            			'imgsize'       => '256',        // The image preview 'max' size
			            			'sizelimit'     => '2048000'     // Image upload max size default 512kb
			        									),
						array(
									'type'		=> 'check',
									'key'			=> 'background'.$i.'_smartsize',
									'label'		=> 'SmartSize'
														),
						array(
									'type'		=> 'check',
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
			$opts = array(
						array(
									'type' 		=> 'select',
									'key'			=> 'sprite'.$i.'_vspeed',
									'label' 	=> 'Scrolling Speed',
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
			            			'key'           => 'sprite'.$i.'_image',
			            			'label'			=> 'Background Image',
			            			'type'          => 'image_upload',
			            			'imgsize'       => '256',        // The image preview 'max' size
			            			'sizelimit'     => '2048000'     // Image upload max size default 512kb
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
														)
						);
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
	  	$i = 0;
	  	$images = false;
	  	$sprites = false;
	  	$sp_v_ratios = false;
	  	while ($i++ < 3):
	  		if( $this->opt('background'.$i.'_image') != '' ):
	  			$images[] = $this->opt('background'.$i.'_image');
	  			$bg_v_ratios[] = $this->opt('background'.$i.'_vspeed');
	  			$resizes[] = $this->opt('background'.$i.'_smartsize');
	  			$bg_centered[] = $this->opt('background'.$i.'_center');
	  		endif;
	  		if( $this->opt('sprite'.$i.'_image') != '' ):
	  			$sprites[]['image'] = $this->opt('sprite'.$i.'_image');
	  			$sp_v_ratios[] = $this->opt('sprite'.$i.'_vspeed');
	  			$sp_v_offset[] = $this->opt('sprite'.$i.'_voffset');
	  		endif;
	  	endwhile;
	  	if( !$images ):
	  		$images[] = 'http://etcio.fwd.wf/wp-content/uploads/2013/06/canmore_rocky_mountains-hd-wallpaper.jpg';
	  		$bg_v_ratios[] = '-1.5';
	  		$resizes[] = '1';
	  		$bg_centered[] = '1';
	  	endif;
	  	// Let's just remove the default sprite for now
	  	//if( !$sprites ):
	  	//	$sprites[] = 'http://new.daaba.org/wp-content/uploads/2013/05/Logo.png';
	  	//	$sp_v_ratios[] = '-1.25';
	  	//endif;

	  	$fullheight = $this->opt('fullheight');
	  	$height = $this->opt('height');
	  	$contained = ($this->opt('contained')) ? 'overflow: hidden;' : '';

	  	if ( $height == '' ):
	  		$height = 400;
	  	endif;

	  	if ( $fullheight == '' ):
	  		$fullheight = 0;
	  	endif;

	  	if ( $images != false ) {
	  		foreach ( $images as $image ){
	  			$imageurls[] = "url('$image')";
	  		}
			$imagesOutput = implode(",", $imageurls);
		}

		if( !$images ){
				echo setup_section_notify($this);
				return;
		}
		$bg_v_ratios = json_encode($bg_v_ratios);
   		if( $sp_v_ratios ):
			$sp_v_ratios = json_encode($sp_v_ratios);
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
   			<?php if( $sp_v_ratios ): ?>
   			c.sp_ratio_v = <?= $sp_v_ratios; ?>;
   			<?php endif; ?>
   			c.bg_centered = <?= $bg_centered; ?>;
   			c.bg_smartsize = <?= $resizes; ?>;
   			c.fullheight = <?= $fullheight ?>;
   			c.pl = <?= $pl ?>;
   		</script>
		<div class="depthChargeBlock" id="<?= $id ?>" style="background-image: <?= $imagesOutput; ?>; height: <?= $height; ?>px; <?= $contained; ?>">
	<?php if( $sprites ): ?>
		<?php foreach( $sprites as $sprite ): ?>
				<div class="depthChargeSprite">
					<img src="<?= $sprite['image'] ?>" />
				</div>
		<?php endforeach; ?>
	<?php endif; ?>
		</div>
		<?php
	}
}