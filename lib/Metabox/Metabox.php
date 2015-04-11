<?php namespace Ajul\Metabox;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

/**
 * Used for creating custom metaboxes.
 */
abstract class Metabox {

    /**
     * @var bool $side
     */
    private $side;

    /**
     * @var string $slug The slug of the post type that the metabox will be attached to.
     */
    private $slug;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $nonce
     */
    private $nonce;

    /**
     * @var string $action
     */
    private $action;

    /**
     * Register action hooks.
     *
     * @param string  $slug
     * @param string  $name    Name of the metabox.
     * @param string  $nonce
     * @param string  $action
     * @param bool    $side    Display on right column.
     */
    public function __construct($slug, $name, $nonce, $action, $side = false) {
        $this->slug   = $slug;
        $this->name   = $name;
        $this->side   = $side;
        $this->nonce  = $nonce;
        $this->action = $action;

        add_action('add_meta_boxes_' . $this->get_slug(), array($this, 'add_metabox'));
        
        // Load JS and CSS files.
        add_action('admin_enqueue_scripts', array($this, 'scripts'));

        // Handle saved posts.
        add_action('save_post', array($this, 'save'), 10, 2);
    }

    /**
     * Get the post type slug
     *
     * @return string
     */
    public function get_slug() {
        return $this->slug;
    }

    /**
     * Get the metabox name
     *
     * @return string
     */
    public function get_name() {
        return $this->name;
    }

    /**
     * Get the nonce field name
     *
     * @return string
     */
    public function get_nonce() {
        return $this->nonce;
    }

    /**
     * Get the nonce action string. Also used as form field name.
     *
     * @return string
     */
    public function get_action() {
        return $this->action;
    }

    /**
     * Add the custom metabox.
     */
    public function add_metabox() {
        if ($this->side)
            add_meta_box($this->get_action(), $this->get_name(), array($this, 'render'), $this->get_slug(), 'side');
        else
            add_meta_box($this->get_action(), $this->get_name(), array($this, 'render'), $this->get_slug());
    }

    /**
     * Save custom meta data.
     *
     * @param int $post_id
     */
    public abstract function save($post_id);

    /**
     * Render the custom metabox.
     *
     * @param WP_Post $post
     */
    public abstract function render($post);

    /**
     * Load the necessary javascripts and stylesheets.
     */
    public abstract function scripts();

}