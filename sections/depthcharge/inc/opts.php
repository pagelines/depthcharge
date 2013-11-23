<?php

/*
	Section Opts
 */

$instructions_template = <<<EOD
<div>
	<p>Welcome to DepthCharge - the smartest and most advanced parallax engine available, and available exclusively for Pagelines DMS.</p>
	<p>To get an idea of what you can accomplish easily with this plugin, visit the <a href="http://depthcharge.etc.io" class="btn btn-primary btn-mini">DEMO</a> page.</p>
	<p>For support inquiries or assistance, visit the <a href="http://help.etc.io" class="btn btn-primary btn-mini">HELP</a> page.</p>
	<p style="text-transform: uppercase;"><strong>Explanation of Features</strong></p>
	<p><u>Panel</u> : Turns your DepthCharge "block" into a full-height panel. <em>Pro Tip: Combine multiple panels together to create a windowed website that showcases important items.</em></p>
	<p><u>Contain</u> : Contains the elements so they don't overflow outside of the bounds of the DepthCharge block.</p>
	<p><u>Slingshot</u> : Sprite path will be drawn so it meets the middle of the DepthCharge block when in the middle of the screen. <em>Pro Tip: Combine this with panel mode.</em></p>
	<p><u>SmartSize</u> : The size of image will automatically be calculated based on the distance the scroll speed requires. This is most important for high scrolling speeds.</p>
	<p><u>Centered</u> : The background will be centered horizontally in the block.</p>
	<p><u>Offsets</u> : By default, sprites are anchored in the center of your block. Offets (px) can be added to move the anchor.</p>
</div>
EOD;

$options = array();
$options[] = array(
	'title'	=> 'Block Options',
	'type'	=> 'multi',
	'opts'	=> array(
		array(
			'key'		=> 'height',
			'type'		=> 'text',
			'default'	=> '400',
			'label'		=> 'Block Height',
		),
		array(
			'key'		=> 'fullheight',
			'type'		=> 'check',
			'default'	=> '0',
			'label'		=> 'Panel',
		),
		array(
			'key'		=> 'contained',
			'type'		=> 'check',
			'default'	=> '0',
			'label'		=> 'Contained',
		),
		array(
			'key'		=> 'mobile',
			'type'		=> 'check',
			'default'	=> '0',
			'label'		=> 'Mobile Support'
		)
	)
);
$options[] = array(
	'key'      => 'instructions',
	'type'     => 'template',
	'title'    => 'Instructions',
	'template' => $instructions_template
);

$options[] = array(
	'key'       => 'backdrop_array',
	'type'      => 'accordion',
	'col'       => 2,
	'title'     => 'Backdrop Setup',
	'post_type' => 'Backdrop',
	'opts'      => array(
		array(
			'key'     => "v_ratio",
			'type'    => 'select',
			'label'   => 'Scrolling Speed',
			'default' => '.5',
			'opts'    => array(
				'5'			=> array('name' => 'Lightning Reverse'),
				'2'			=> array('name' => 'Speedy Reverse'),
				'1.5'		=> array('name' => 'Fast Reverse'),
				'1.25'		=> array('name' => 'Heightened Reverse'),
				'1'			=> array('name' => 'Reverse'),
				'.5'		=> array('name' => 'Half Reverse'),
				'.25'		=> array('name' => 'Slow Reverse'),
				'.1'		=> array('name' => 'Turtle Reverse'),
				'-1.5'		=> array('name' => 'Forward'),
				'-1.75'		=> array('name' => 'Heightened Forward'),
				'-2'		=> array('name' => 'Fast Forward'),
				'-2.5'		=> array('name' => 'Speedy Forward'),
				'-5.5'		=> array('name' => 'Lightning')
			)
		),
		array(
			'key'       => "image",
			'label'     => 'Backdrop Image',
			'default'   => 'http://f.cl.ly/items/1W2B0K2E0S3g3P0z2u1G/scuba_diving_gb.jpg',
			'type'      => 'image_upload',
			'imgsize'   => '256',        // The image preview 'max' size
			'sizelimit' => '2048000'     // Image upload max size default 512kb
		),
		array(
			'key'     => "smartsize",
			'type'    => 'check',
			'default' => '0',
			'label'   => 'SmartSize'
		),
		array(
			'key'     => "center",
			'type'    => 'check',
			'default' => '0',
			'label'   => 'Centered'
		),
	)
);

$options[] = array(
	'key'       => 'sprite_array',
	'type'      => 'accordion',
	'col'       => 2,
	'title'     => 'Sprite Setup',
	'post_type' => 'Sprite',
	'opts'      => array(
		array(
			'key'     => 'v_ratio',
			'type'    => 'select',
			'label'   => 'Scrolling Speed',
			'default' => '.5',
			'opts'    => array(
				'5'     => array('name' => 'Lightning Reverse'),
				'2'     => array('name' => 'Speedy Reverse'),
				'1.5'   => array('name' => 'Fast Reverse'),
				'1.25'  => array('name' => 'Heightened Reverse'),
				'1'     => array('name' => 'Reverse'),
				'.5'    => array('name' => 'Half Reverse'),
				'.25'   => array('name' => 'Slow Reverse'),
				'.1'    => array('name' => 'Turtle Reverse'),
				'-.1'   => array('name' => 'Turtle Forward'),
				'-.25'  => array('name' => 'Slow Forward'),
				'-.5'   => array('name' => 'Half Forward'),
				'-1'    => array('name' => 'Forward'),
				'-1.25' => array('name' => 'Heightened Forward'),
				'-1.5'  => array('name' => 'Fast Forward'),
				'-2'    => array('name' => 'Speedy Forward'),
				'-5'    => array('name' => 'Lightning')
			)
		),
		array(
			'key'     => 'slingshot',
			'type'    => 'check',
			'default' => '0',
			'label'   => 'Slingshot'
		),
		array(
			'key'   => 'class',
			'type'  => 'text',
			'label' => 'Custom Class'
		),
		array(
			'key'   => 'v_offset',
			'type'  => 'text',
			'label' => 'Vertical Offset'
		),
		array(
			'key'   => 'h_offset',
			'type'  => 'text',
			'label' => 'Horizontal Offset'
		),
		array(
			'key'     => 'type',
			'type'    => 'select',
			'default' => 'slab',
			'label'   => 'Type of Sprite',
			'opts'    => array(
				'slab' => array('name' => 'SlabText'),
				'img'  => array('name' => 'Image'),
			)
		),
		array(
			'key'           => 'image',
			'label'			=> 'Sprite Image',
			'type'          => 'image_upload',
			'imgsize'       => '256',        // The image preview 'max' size
			'sizelimit'     => '2048000'     // Image upload max size default 512kb
		),
		array(
			'key'           => 'heading',
			'label'			=> 'Heading',
			'type'          => 'text',
			'default'		=> 'DepthCharge'
		),
		array(
			'key'           => 'font',
			'label'			=> 'Font',
			'default'		=> 'josefin_sans',
			'type'          => 'type'
		),
		array(
			'key'     => 'textwidth',
			'type'    => 'select',
			'label'   => 'SlabText Width',
			'default' => '80%',
			'opts'    => array(
				'100%' => array('name' => '100%'),
				'90%'  => array('name' => '90%'),
				'80%'  => array('name' => '80%'),
				'70%'  => array('name' => '70%'),
				'60%'  => array('name' => '60%'),
				'50%'  => array('name' => '50%'),
				'40%'  => array('name' => '40%'),
				'30%'  => array('name' => '30%'),
				'20%'  => array('name' => '20%'),
				'10%'  => array('name' => '10%'),
				)
		),
		array(
			'key'     => 'color',
			'label'   => 'Text Color',
			'type'    => 'color',
			'default' => 'FFFFFF'
		),

	)
);

return $options;