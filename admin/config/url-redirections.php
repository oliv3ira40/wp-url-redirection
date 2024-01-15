<?php

    /**
     * Registra o custom post type Urls
     * @return void
     */
    function register_url_redirections_pt() {
        register_post_type('url_redirection', array(
            'description' => 'url_redirection-post-type',
            'exclude_from_search' => false,
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => 'tools.php',
            'hierarchical' => false,
            'has_archive' => 'redirect',
            'rewrite' => ['slug' => 'redirect', 'with_front' => true],
            'show_in_rest' => true,
            'rest_base' => 'redirect',
            'supports' => ['title', 'revisions'],
            'menu_icon' => 'dashicons-admin-page',
            'labels' => [
                'name' => 'Lista de urls redirecionadas',
                'singular_name' => 'Url',
                'search_items' => 'Pesquisar em Urls',
                'all_items' => 'Redirecionar urls',
                'edit_item' => 'Editar',
                'upload_item' => 'Atualizar',
                'add_new' => 'Adicionar nova',
                'add_new_item' => 'Novo redirecionamento',
            ],
        ));  
    }
    add_action('init', 'register_url_redirections_pt');

    // Adicionar colunas personalizadas à listagem de posts do post type "url_redirection"
    function custom_url_redirection_columns($columns) {
        $offset = array_search('date', array_keys($columns));
        return array_merge(
            array_slice($columns, 0, $offset),
            ['url_origin' => 'Url de origem'],
            ['url_destiny' => 'Url de destino'],
            array_slice($columns, $offset, null)
        );
    }
    add_filter('manage_url_redirection_posts_columns', 'custom_url_redirection_columns');

    // Exibir o conteúdo das colunas personalizadas na listagem de posts do post type "url_redirection"
    function custom_url_redirection_column_content($column, $post_id) {
        switch ($column) {
            case 'url_origin':
                $url_origin = carbon_get_post_meta($post_id, 'url_origin');
                
                if (!empty($url_origin)) {
                    echo $url_origin;
                } else echo '---';
                break;

            case 'url_destiny':
                $url_destiny = carbon_get_post_meta($post_id, 'url_destiny');
                
                if (isset($url_destiny)) {
                    echo $url_destiny;
                } else echo '---';

                break;
        }
    }
    add_action('manage_url_redirection_posts_custom_column', 'custom_url_redirection_column_content', 10, 2);

    add_action('carbon_fields_fields_registered', 'handle_source_and_destination_inputs', 10, 2);
    function handle_source_and_destination_inputs() {
        if (
            !empty($_POST['post_type']) AND $_POST['post_type'] === 'url_redirection'
            AND isset($_POST['carbon_fields_compact_input']['_url_origin']
        )) {
            $url_origin = $_POST['carbon_fields_compact_input']['_url_origin'];
            $url_destiny = $_POST['carbon_fields_compact_input']['_url_destiny'];
            $raw_url_destiny = $url_destiny;
            if ($url_origin) $url_origin = get_raw_url($url_origin);
            if ($url_destiny) $raw_url_destiny = get_raw_url($url_destiny);

            if ($url_origin == $raw_url_destiny) $url_destiny = '';

            $_POST['carbon_fields_compact_input']['_url_origin'] = trim($url_origin);
            $_POST['carbon_fields_compact_input']['_url_destiny'] = trim($url_destiny);
            return;
        }
    }
