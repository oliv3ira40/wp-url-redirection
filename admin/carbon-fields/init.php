<?php
    use Carbon_Fields\Container;
    use Carbon_Fields\Field;
    
    Class FieldsUrlRedirection {
        public function __construct() {
            add_action('after_setup_theme', array($this, 'load_carbon_fields'));
            add_action('carbon_fields_loaded', array($this, 'load_fields'));
        }

        public function load_carbon_fields() {
            require_once plugin_dir_path(dirname(__FILE__)) . '../vendor/autoload.php';
            \Carbon_Fields\Carbon_Fields::boot();
        }

        public function load_fields() {
            include 'fields/url-redirections.php';
            url_redirections();
        }
    }

    new FieldsUrlRedirection();
