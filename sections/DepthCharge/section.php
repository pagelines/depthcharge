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
		wp_enqueue_script('skrollr', $this->base_url.'/js/skrollr.min.js');
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
						'type'		=> 'text',
						'key'			=> 'background1_image',
						'label'		=> 'Background Image'
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
						'type'		=> 'text',
						'key'			=> 'background2_image',
						'label'		=> 'Background Image'
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
						'type'		=> 'text',
						'key'			=> 'background3_image',
						'label'		=> 'Background Image'
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
						'type'		=> 'text',
						'key'			=> 'sprite1_image',
						'label'		=> 'Sprite Image'
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
						'type'		=> 'text',
						'key'			=> 'sprite2_image',
						'label'		=> 'Sprite Image'
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
						'type'		=> 'text',
						'key'			=> 'sprite3_image',
						'label'		=> 'Sprite Image'
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
	  	while ($i++ <= 3):
	  		if( $this->opt('background'.$i.'_image') != '' ):
	  			$images[] = $this->opt('background'.$i.'_image');
	  			$bg_v_ratios[] = $this->opt('background'.$i.'_vspeed');
	  			$resizes[] = $this->opt('background'.$i.'_smartsize');
	  		endif;
	  		if( $this->opt('sprite'.$i.'_image') != '' ):
	  			$sprites[] = $this->opt('sprite'.$i.'_image');
	  			$sp_v_ratios[] = $this->opt('sprite'.$i.'_vspeed');
	  			$sp_v_offset[] = $this->opt('sprite'.$i.'_voffset');
	  		endif;
	  	endwhile;

	  	$height = $this->opt('height');

		function urlify($u){
			return "url('$u')";
		}

	  	if ( $images != false ) {
	  		foreach ( $images as $image ){
	  			$imageurls[] = urlify($image);
	  		}
			$imagesOutput = implode(",", $imageurls);
		}

		if( !$images ){
				echo setup_section_notify($this);
				return;
		}
		$bg_v_ratios = json_encode($bg_v_ratios);
		$sp_v_ratios = json_encode($sp_v_ratios);
		$resizes = json_encode($resizes);
   	?>
   		<script>
   			var etc_config_id = [];
   			etc_config_id.ploffset = 37;
   			etc_config_id.bg_ratio_v = <?= $bg_v_ratios; ?>;
   			etc_config_id.sp_ratio_v = <?= $sp_v_ratios; ?>;
   			etc_config_id.bg_smartsize = <?= $resizes; ?>;
   		</script>
   		<div>
			<div class="depthChargeBlock" style="background-image: <?= $imagesOutput; ?>; height: <?= $height; ?>px;">
	<?php foreach( $sprites as $sprite ): ?>
				<div class="depthChargeSprite">
					<img src="<?= $sprite ?>" />
				</div>
	<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}