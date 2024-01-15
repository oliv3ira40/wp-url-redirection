<?php

    /**
     * Verifica a página atual e retorna "true" caso ela seja uma página
     * relacionada ao plugin "Forms", e que esteja DENTRO do admin do WP
     * @return boolean
     */
    function is_admin_url_direction() {
        $plugin_pages = [
        ];
        $post_types = [
            'url_redirection',
        ];
        $current_page = explode('&', $_SERVER['REQUEST_URI'])[0];
        
        $post_type = false;
        if (!empty($_GET['post'])) {
            $post_type = get_post_type($_GET['post']);
        } elseif (!empty($_GET['post_type'])) {
            $post_type = $_GET['post_type'];
        } else {}

        if (
            is_admin()
            AND (in_array($current_page, $plugin_pages)
            OR isset($post_type) AND in_array($post_type, $post_types))
        ) return true;
        return false;
    }

    /**
     * Verifica a página atual e retorna "true" caso ela seja uma página
     * relacionada ao plugin "Forms", e que esteja FORA do admin do WP
     * @return boolean
     */
    function is_public_url_direction() {
        $plugin_pages = [];
        $post_types = [
            'url_redirection',
        ];
        $current_page = explode('&', $_SERVER['REQUEST_URI'])[0];
        $post_type = get_post_type();

        if (
            (in_array($current_page, $plugin_pages)
            OR isset($post_type) AND in_array($post_type, $post_types))
        ) return true;
        return false;
    }

    function redirect_user() {
        $current_url = home_url().$_SERVER['REQUEST_URI'];
        
        if (!str_contains($current_url, 'rd=1')) {
            $current_url = get_url_redundancies(home_url().$_SERVER['REQUEST_URI']);
            $origin = get_origin_ur($current_url);
    
            if (!empty($origin)) {
                $origin = $origin[0];
                $destiny = get_destiny_ur($origin);
    
                if (!empty($destiny) AND $origin->meta_value != $destiny[0]->meta_value) {
                    $url = $destiny[0]->meta_value;
                    if (str_contains($url, '?')) {
                        $url = $url.'&rd=1';
                    } else $url = $url.'?rd=1';
    
                    wp_redirect($url, 301);
                    exit;
                }
            }
        }
        return;
    }
    add_action('template_redirect', 'redirect_user');

    function get_origin_ur($current_url) {
        global $wpdb;
        $current_url = "'".implode("','", array_values($current_url))."'";

        $qr_origin = "
            SELECT post_id, meta_key, meta_value FROM wp_postmeta pm
                RIGHT JOIN wp_posts p ON (p.ID = pm.post_id AND p.post_status = 'publish')
            WHERE pm.meta_key = '_url_origin'
                AND pm.meta_value IN ($current_url)
            ORDER BY p.post_date DESC
            LIMIT 1
        ";
        $origin = $wpdb->get_results($qr_origin);
        
        if (!empty($origin)) return $origin;
        return false;
    }

    function get_destiny_ur($origin) {
        global $wpdb;
        $qr_destiny = "
            SELECT post_id, meta_key, meta_value FROM wp_postmeta pm
            WHERE pm.meta_key = '_url_destiny'
                AND pm.post_id = {$origin->post_id}
                AND pm.meta_value != '{$origin->meta_value}'
            LIMIT 1
        ";
        $destiny = $wpdb->get_results($qr_destiny);
        
        if (!empty($destiny)) return $destiny;
        return false;
    }

    function get_raw_url($url) {
        $url = 'http://'.str_replace(['http://', 'https://'], '', $url);
        $url = explode('?', $url)[0];
        if (substr($url, -1) === '/') {
            $url = rtrim($url, '/');
        }

        return $url;
    }

    function get_url_redundancies($current_url) {
        $current_url = 'http://'.str_replace(['http://', 'https://'], '', $current_url);
        
        if (str_contains($current_url, '?s=')) {
            $url_no_params = $current_url;
        } else $url_no_params = explode('?', $current_url)[0];
    
        $url_no_last_bar = $current_url;
        if (substr($url_no_params, -1) === '/') {
            $url_no_last_bar = rtrim($url_no_params, '/');
        }

        $current_url = [$current_url, $url_no_params, $url_no_last_bar];
        $current_url = array_unique($current_url);
        return $current_url;
    }
    