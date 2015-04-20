<?php
// Prevent direct access.
if (!defined('ABSPATH'))
    exit;
?>
<a class="ajul-tour-start" data-ajul-tour="<?php echo $post->ID; ?>" href="javascript:;">
    <?php _e($attributes['text'], AJUL_I18N); ?>
</a>