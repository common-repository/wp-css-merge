<?php

/**
 * Provides the markup for a select field
 *
 * @link       https://digitalapps.co
 * @since      1.0.0
 *
 * @package    Adblock Detect
 * @subpackage AdUnblocker/admin/partials
 */
?>
<div class="toggle">
    <div class="toggle--wrapper">

        <input aria-role="checkbox"
            <?php checked(1, $atts['value'], true); ?>
                class="toggle--input" 
                id="<?php echo esc_attr( $atts['name'] ); ?>-<?php echo $atts['value']; ?>" 
                name="<?php echo esc_attr( $atts['name'] ); ?>"
                type="checkbox"
                value="<?php echo esc_attr( $atts[ 'value' ] ); ?>"/>

        <label 
            for="<?php echo esc_attr( $atts['name'] ); ?>-<?php echo $atts['value']; ?>" 
            class="toggle--label" 
            data-position="<?php echo esc_attr( $atts['value'] ); ?>">
        </label>
        
    </div>
</div>