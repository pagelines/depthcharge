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
Loading: active
*/

class etcDepthCharge extends PageLinesSection {

	function section_styles(){
		wp_enqueue_script('etcDepthCharge', $this->base_url.'/js/etcDepthCharge.js',array('jquery'));
		wp_enqueue_script('skrollr', $this->base_url.'/js/skrollr.js');
	}

	function section_head( $clone_id ){
		$prefix = ($clone_id != '') ? '.clone_'.$clone_id : '';
	}

	function section_opts() {
		$opts = array(
array(
				'title'			=> 'Block Options',
				'type'			=> 'multi',
				'opts'			=> array(
			array(
						'type'		=> 'text',
						'key'			=> 'height',
						'label'		=> 'Block Height'
											),
			array(
						'type'		=> 'check',
						'key'			=> 'fullheight',
						'label'		=> 'Full Height? (overrides height)'
											)
										)
									),
			array(
				'title'			=> 'Background #1',
				'type'			=> 'multi',
				'opts'			=> array(
			array(
						'type' 		=> 'select',
						'key'			=> 'background1_vspeed',
						'label' 	=> 'Scrolling Speed',
						'opts'		=> array(
							'5'			=> array('name' => '-5'),
							'2'			=> array('name' => '-2'),
							'1.5'		=> array('name' => '-1.5'),
							'1.25'	=> array('name' => '-1.25'),
							'1'			=> array('name' => '-1'),
							'.9'		=> array('name' => '-0.9'),
							'.8'		=> array('name' => '-0.8'),
							'.7'		=> array('name' => '-0.7'),
							'.6'		=> array('name' => '-0.6'),
							'.5'		=> array('name' => '-0.5'),
							'.4'		=> array('name' => '-0.4'),
							'.3'		=> array('name' => '-0.3'),
							'.2'		=> array('name' => '-0.2'),
							'.1'		=> array('name' => '-0.1'),
							'-.1'		=> array('name' => '0.1'),
							'-.2'		=> array('name' => '0.2'),
							'-.3'		=> array('name' => '0.3'),
							'-.4'		=> array('name' => '0.4'),
							'-.5'		=> array('name' => '0.5'),
							'-.6'		=> array('name' => '0.6'),
							'-.7'		=> array('name' => '0.7'),
							'-.8'		=> array('name' => '0.8'),
							'-.9'		=> array('name' => '0.9'),
							'-1'		=> array('name' => '1'),
							'-1.25'	=> array('name' => '1.25'),
							'-1.5'	=> array('name' => '1.5'),
							'-2'		=> array('name' => '2'),
							'-5'		=> array('name' => '5')
												)
											),
			array(
            			'key'           => 'background1_image',
            			'label'			=> 'Background Image',
            			'type'          => 'image_upload',
            			'imgsize'       => '256',        // The image preview 'max' size
            			'sizelimit'     => '2048000'     // Image upload max size default 512kb
        									),
			array(
						'type'		=> 'check',
						'key'			=> 'background1_smartsize',
						'label'		=> 'SmartSize'
											),
			array(
						'type'		=> 'check',
						'key'			=> 'background1_center',
						'label'		=> 'Center'
											)
										)
									),
array(
				'title'			=> 'Background #2',
				'type'			=> 'multi',
				'opts'			=> array(
			array(
						'type' 		=> 'select',
						'key'			=> 'background2_vspeed',
						'label' 	=> 'Scrolling Speed',
						'opts'		=> array(
							'5'			=> array('name' => '-5'),
							'2'			=> array('name' => '-2'),
							'1.5'			=> array('name' => '-1.5'),
							'1.25'			=> array('name' => '-1.25'),
							'1'			=> array('name' => '-1'),
							'.9'		=> array('name' => '-0.9'),
							'.8'		=> array('name' => '-0.8'),
							'.7'		=> array('name' => '-0.7'),
							'.6'		=> array('name' => '-0.6'),
							'.5'		=> array('name' => '-0.5'),
							'.4'		=> array('name' => '-0.4'),
							'.3'		=> array('name' => '-0.3'),
							'.2'		=> array('name' => '-0.2'),
							'.1'		=> array('name' => '-0.1'),
							'-.1'		=> array('name' => '0.1'),
							'-.2'		=> array('name' => '0.2'),
							'-.3'		=> array('name' => '0.3'),
							'-.4'		=> array('name' => '0.4'),
							'-.5'		=> array('name' => '0.5'),
							'-.6'		=> array('name' => '0.6'),
							'-.7'		=> array('name' => '0.7'),
							'-.8'		=> array('name' => '0.8'),
							'-.9'		=> array('name' => '0.9'),
							'-1'		=> array('name' => '1'),
							'-1.25'		=> array('name' => '1.25'),
							'-1.5'		=> array('name' => '1.5'),
							'-2'		=> array('name' => '2'),
							'-5'		=> array('name' => '5')
												)
											),
			array(
            			'key'           => 'background2_image',
            			'label'			=> 'Background Image',
            			'type'          => 'image_upload',
            			'imgsize'       => '256',        // The image preview 'max' size
            			'sizelimit'     => '2048000'     // Image upload max size default 512kb
        									),
			array(
						'type'		=> 'check',
						'key'			=> 'background2_smartsize',
						'label'		=> 'SmartSize'
											),
			array(
						'type'		=> 'check',
						'key'			=> 'background2_center',
						'label'		=> 'Center'
											)
										),
									),
array(
				'title'			=> 'Background #3',
				'type'			=> 'multi',
				'opts'			=> array(
			array(
						'type' 			=> 'select',
						'key'			=> 'background3_vspeed',
						'label' 		=> 'Scrolling Speed',
						'opts'			=> array(
							'5'			=> array('name' => '-5'),
							'2'			=> array('name' => '-2'),
							'1.5'			=> array('name' => '-1.5'),
							'1.25'			=> array('name' => '-1.25'),
							'1'			=> array('name' => '-1'),
							'.9'		=> array('name' => '-0.9'),
							'.8'		=> array('name' => '-0.8'),
							'.7'		=> array('name' => '-0.7'),
							'.6'		=> array('name' => '-0.6'),
							'.5'		=> array('name' => '-0.5'),
							'.4'		=> array('name' => '-0.4'),
							'.3'		=> array('name' => '-0.3'),
							'.2'		=> array('name' => '-0.2'),
							'.1'		=> array('name' => '-0.1'),
							'-.1'		=> array('name' => '0.1'),
							'-.2'		=> array('name' => '0.2'),
							'-.3'		=> array('name' => '0.3'),
							'-.4'		=> array('name' => '0.4'),
							'-.5'		=> array('name' => '0.5'),
							'-.6'		=> array('name' => '0.6'),
							'-.7'		=> array('name' => '0.7'),
							'-.8'		=> array('name' => '0.8'),
							'-.9'		=> array('name' => '0.9'),
							'-1'		=> array('name' => '1'),
							'-1.25'		=> array('name' => '1.25'),
							'-1.5'		=> array('name' => '1.5'),
							'-2'		=> array('name' => '2'),
							'-5'		=> array('name' => '5')
												)
											),
			array(
            			'key'           => 'background3_image',
            			'label'			=> 'Background Image',
            			'type'          => 'image_upload',
            			'imgsize'       => '256',        // The image preview 'max' size
            			'sizelimit'     => '2048000'     // Image upload max size default 512kb
        									),
			array(
						'type'		=> 'check',
						'key'			=> 'background3_smartsize',
						'label'		=> 'SmartSize'
											),
			array(
						'type'		=> 'check',
						'key'			=> 'background3_center',
						'label'		=> 'Center'
											)
										)
									),
array(
				'title'			=> 'Sprite #1',
				'type'			=> 'multi',
				'opts'			=> array(
			array(
						'type' 		=> 'select',
						'key'			=> 'sprite1_vspeed',
						'label' 	=> 'Scrolling Speed',
						'opts'		=> array(
							'5'			=> array('name' => '-5'),
							'2'			=> array('name' => '-2'),
							'1.5'		=> array('name' => '-1.5'),
							'1.25'	=> array('name' => '-1.25'),
							'1'			=> array('name' => '-1'),
							'.9'		=> array('name' => '-0.9'),
							'.8'		=> array('name' => '-0.8'),
							'.7'		=> array('name' => '-0.7'),
							'.6'		=> array('name' => '-0.6'),
							'.5'		=> array('name' => '-0.5'),
							'.4'		=> array('name' => '-0.4'),
							'.3'		=> array('name' => '-0.3'),
							'.2'		=> array('name' => '-0.2'),
							'.1'		=> array('name' => '-0.1'),
							'-.1'		=> array('name' => '0.1'),
							'-.2'		=> array('name' => '0.2'),
							'-.3'		=> array('name' => '0.3'),
							'-.4'		=> array('name' => '0.4'),
							'-.5'		=> array('name' => '0.5'),
							'-.6'		=> array('name' => '0.6'),
							'-.7'		=> array('name' => '0.7'),
							'-.8'		=> array('name' => '0.8'),
							'-.9'		=> array('name' => '0.9'),
							'-1'		=> array('name' => '1'),
							'-1.25'	=> array('name' => '1.25'),
							'-1.5'	=> array('name' => '1.5'),
							'-2'		=> array('name' => '2'),
							'-5'		=> array('name' => '5')
												)
											),
			array(
            			'key'           => 'sprite1_image',
            			'label'			=> 'Sprite Image',
            			'type'          => 'image_upload',
            			'imgsize'       => '256',        // The image preview 'max' size
            			'sizelimit'     => '2048000'     // Image upload max size default 512kb
        									),
			array(
						'type'		=> 'text',
						'key'			=> 'sprite1_class',
						'label'		=> 'Custom Class'
											),
			array(
						'type'		=> 'text',
						'key'			=> 'sprite1_voffset',
						'label'		=> 'Sprite Vertical Offset'
											),
			array(
						'type'		=> 'text',
						'key'			=> 'sprite1_hoffset',
						'label'		=> 'Sprite Horizontal Offset'
											),
										)
									),
array(
				'title'			=> 'Sprite #2',
				'type'			=> 'multi',
				'opts'			=> array(
			array(
						'type' 		=> 'select',
						'key'			=> 'sprite2_vspeed',
						'label' 	=> 'Scrolling Speed',
						'opts'		=> array(
							'5'			=> array('name' => '-5'),
							'2'			=> array('name' => '-2'),
							'1.5'		=> array('name' => '-1.5'),
							'1.25'	=> array('name' => '-1.25'),
							'1'			=> array('name' => '-1'),
							'.9'		=> array('name' => '-0.9'),
							'.8'		=> array('name' => '-0.8'),
							'.7'		=> array('name' => '-0.7'),
							'.6'		=> array('name' => '-0.6'),
							'.5'		=> array('name' => '-0.5'),
							'.4'		=> array('name' => '-0.4'),
							'.3'		=> array('name' => '-0.3'),
							'.2'		=> array('name' => '-0.2'),
							'.1'		=> array('name' => '-0.1'),
							'-.1'		=> array('name' => '0.1'),
							'-.2'		=> array('name' => '0.2'),
							'-.3'		=> array('name' => '0.3'),
							'-.4'		=> array('name' => '0.4'),
							'-.5'		=> array('name' => '0.5'),
							'-.6'		=> array('name' => '0.6'),
							'-.7'		=> array('name' => '0.7'),
							'-.8'		=> array('name' => '0.8'),
							'-.9'		=> array('name' => '0.9'),
							'-1'		=> array('name' => '1'),
							'-1.25'	=> array('name' => '1.25'),
							'-1.5'	=> array('name' => '1.5'),
							'-2'		=> array('name' => '2'),
							'-5'		=> array('name' => '5')
												)
											),
			array(
            			'key'           => 'sprite2_image',
            			'label'			=> 'Sprite Image',
            			'type'          => 'image_upload',
            			'imgsize'       => '256',        // The image preview 'max' size
            			'sizelimit'     => '2048000'     // Image upload max size default 512kb
        									),
			array(
						'type'		=> 'text',
						'key'			=> 'sprite2_class',
						'label'		=> 'Custom Class'
											),
			array(
						'type'		=> 'text',
						'key'			=> 'sprite2_voffset',
						'label'		=> 'Sprite Vertical Offset'
											),
			array(
						'type'		=> 'text',
						'key'			=> 'sprite2_hoffset',
						'label'		=> 'Sprite Horizontal Offset'
											),
										)
									),
array(
				'title'			=> 'Sprite #3',
				'type'			=> 'multi',
				'opts'			=> array(
			array(
						'type' 		=> 'select',
						'key'			=> 'sprite3_vspeed',
						'label' 	=> 'Scrolling Speed',
						'opts'		=> array(
							'5'			=> array('name' => '-5'),
							'2'			=> array('name' => '-2'),
							'1.5'		=> array('name' => '-1.5'),
							'1.25'	=> array('name' => '-1.25'),
							'1'			=> array('name' => '-1'),
							'.9'		=> array('name' => '-0.9'),
							'.8'		=> array('name' => '-0.8'),
							'.7'		=> array('name' => '-0.7'),
							'.6'		=> array('name' => '-0.6'),
							'.5'		=> array('name' => '-0.5'),
							'.4'		=> array('name' => '-0.4'),
							'.3'		=> array('name' => '-0.3'),
							'.2'		=> array('name' => '-0.2'),
							'.1'		=> array('name' => '-0.1'),
							'-.1'		=> array('name' => '0.1'),
							'-.2'		=> array('name' => '0.2'),
							'-.3'		=> array('name' => '0.3'),
							'-.4'		=> array('name' => '0.4'),
							'-.5'		=> array('name' => '0.5'),
							'-.6'		=> array('name' => '0.6'),
							'-.7'		=> array('name' => '0.7'),
							'-.8'		=> array('name' => '0.8'),
							'-.9'		=> array('name' => '0.9'),
							'-1'		=> array('name' => '1'),
							'-1.25'	=> array('name' => '1.25'),
							'-1.5'	=> array('name' => '1.5'),
							'-2'		=> array('name' => '2'),
							'-5'		=> array('name' => '5')
												)
											),
			array(
            			'key'           => 'sprite3_image',
            			'label'			=> 'Sprite Image',
            			'type'          => 'image_upload',
            			'imgsize'       => '256',        // The image preview 'max' size
            			'sizelimit'     => '2048000'     // Image upload max size default 512kb
        									),
			array(
						'type'		=> 'text',
						'key'			=> 'sprite3_class',
						'label'		=> 'Custom Class'
											),
			array(
						'type'		=> 'text',
						'key'			=> 'sprite3_voffset',
						'label'		=> 'Sprite Vertical Offset'
											),
			array(
						'type'		=> 'text',
						'key'			=> 'sprite3_hoffset',
						'label'		=> 'Sprite Horizontal Offset'
											),
										)
									),
								);
		return $opts;
	}

	/**
	* Section template.
	*/
  	function section_template() {
	  	$i = 0;
	  	$images = false;
	  	$sprites = false;
	  	$height = false;
	  	$fullheight = false;
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

	  	if ( !$fullheight ):
	  		$fullheight = 0;
	  	else:
	  		$fullheight = $this->opt('fullheight');
	  	endif;

	  	if ( !$height ):
	  		$height = 400;
	  	else:
	  		$height = $this->opt('height');
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
   	?>
   		<script>
   			var etc_dc_config = etc_dc_config || [];
   			etc_dc_config['<?= $id ?>'] = [];
   			var c = etc_dc_config['<?= $id ?>'];
   			c.ploffset = 37;
   			c.bg_ratio_v = <?= $bg_v_ratios; ?>;
   			<?php if( $sp_v_ratios ): ?>
   			c.sp_ratio_v = <?= $sp_v_ratios; ?>;
   			<?php endif; ?>
   			c.bg_centered = <?= $bg_centered; ?>;
   			c.bg_smartsize = <?= $resizes; ?>;
   			c.fullheight = <?= $fullheight ?>;
   		</script>
		<div class="depthChargeBlock" id="<?= $id ?>" style="background-image: <?= $imagesOutput; ?>; height: <?= $height; ?>px;">
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