<?php
$form_id = "ddzap-setting-form-$current_page";
$form_action = admin_url( 'themes.php?page=ddzap-custom-html-tags-admin-menu&tag=radio' );
$fields = [
	'enable' => [
		'label' => __('Enable/Disable', DDZAP_TEXT_DOMAIN),
		'type'  => 'checkbox'
	],
	'delimiter-0' => [
		'label' => __('Enable Plugins Support', DDZAP_TEXT_DOMAIN),
		'type'  => 'delimiter'
	],
	'woocommerce-support' => [
		'label' => __('WooCommerce', DDZAP_TEXT_DOMAIN),
		'type'  => 'checkbox'
	],
	'contact-form-7-support' => [
		'label' => __('Contact Form 7', DDZAP_TEXT_DOMAIN),
		'type'  => 'checkbox'
	],
	'delimiter-1' => [
		'label' => __('Radio Button Border', DDZAP_TEXT_DOMAIN),
		'type'  => 'delimiter'
	],
	'text-offset' => [
		'label' => __('Text Offset', DDZAP_TEXT_DOMAIN),
		'type'  => 'number'
	],
	'width' => [
		'label' => __('Width', DDZAP_TEXT_DOMAIN),
		'type'  => 'number'
	],
	'height' => [
		'label' => __('Height', DDZAP_TEXT_DOMAIN),
		'type'  => 'number'
	],
	'offset-top' => [
		'label' => __('Offset Top', DDZAP_TEXT_DOMAIN),
		'type'  => 'number'
	],
	'offset-left' => [
		'label' => __('Offset Left', DDZAP_TEXT_DOMAIN),
		'type'  => 'number'
	],
	'border-width' => [
		'label' => __('Border Width', DDZAP_TEXT_DOMAIN),
		'type'  => 'number'
	],
	'border-radius' => [
		'label' => __('Border Radius', DDZAP_TEXT_DOMAIN),
		'type'  => 'number'
	],
	'border-color' => [
		'label' => __('Border Color', DDZAP_TEXT_DOMAIN),
		'type'  => 'color'
	],
	'delimiter-2' => [
		'label' => __('Radio Button Flag', DDZAP_TEXT_DOMAIN),
		'type'  => 'delimiter'
	],
	'flag-width' => [
		'label' => __('Width', DDZAP_TEXT_DOMAIN),
		'type'  => 'number'
	],
	'flag-height' => [
		'label' => __('Height', DDZAP_TEXT_DOMAIN),
		'type'  => 'number'
	],
	'flag-border-radius' => [
		'label' => __('Border Radius', DDZAP_TEXT_DOMAIN),
		'type'  => 'number'
	],
	'flag-color' => [
		'label' => __('Border Color', DDZAP_TEXT_DOMAIN),
		'type'  => 'color'
	],
  'delimiter-3' => [
    'label' => __('Exclude Classes', DDZAP_TEXT_DOMAIN),
    'type'  => 'delimiter'
  ],
  'exclude-classes' => [
    'label' => __('CSS Classes', DDZAP_TEXT_DOMAIN),
    'placeholder' => __('wcpf-input, fdsf-input', DDZAP_TEXT_DOMAIN),
    'type'  => 'text'
  ],
	'css' => [
		'type'  => 'hidden'
	],
	'js' => [
		'type'  => 'hidden'
	],
];
?>
<form action="<?php echo $form_action; ?>" method="post" id="<?php echo $form_id; ?>"
      data-tag="<?php echo $current_page; ?>" class="ddzap-setting-form">
	<table class="form-table" role="presentation">
		<tbody>
		<?php foreach ( $fields as $field_name => $field_options ) { ?>
			<?php $field_id = $form_id . '-' . $field_name; ?>
			<tr>
				<?php if ( $field_options['type'] === 'delimiter' ) { ?>

					<th scope="row"><h3><?php echo $field_options['label']; ?></h3></th>

				<?php } else if ( $field_options['type'] === 'hidden' ) { ?>

					<th scope="row"><input type="hidden" id="<?php echo $field_id; ?>" name="<?php echo $field_id; ?>"/></th>

				<?php } else { ?>

					<th scope="row"><label for="<?php echo $field_id; ?>"><?php echo $field_options['label']; ?></label></th>
					<td>
						<?php
						switch ($field_options['type']) {
							case 'number': { ?>
								<input name="<?php echo $field_id; ?>" type="number" min="0" id="<?php echo $field_id; ?>"
								       value="<?php echo $settings[$field_id]; ?>" class="small-text"> px
								<?php break;
							}
							case 'checkbox': { ?>
								<input name="<?php echo $field_id; ?>" type="checkbox" id="<?php echo $field_id; ?>"
									<?php checked($settings[$field_id], 'on'); ?>>
								<?php break;
							}
							case 'color': { ?>
								<input name="<?php echo $field_id; ?>" type="text" id="<?php echo $field_id; ?>"
								       value="<?php echo $settings[$field_id]; ?>">
								<?php break;
							}
              case 'text': { ?>
                <input name="<?php echo $field_id; ?>" type="text" id="<?php echo $field_id; ?>"
                       placeholder="<?php echo isset($field_options['placeholder']) ? $field_options['placeholder'] : ''; ?>"
                       value="<?php echo $settings[$field_id]; ?>">
                <?php break;
              }
						}
						?>
					</td>
				<?php } ?>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</form>
<!-- /.ddzap-setting-form -->
