<?php

    use Carbon_Fields\Container;
    use Carbon_Fields\Field;

    function url_redirections() {
        Container::make('post_meta', 'Configurações')
            ->where('post_type', 'IN', ['url_redirection'])
            ->add_fields([
                Field::make('text', 'url_origin', 'Url de origem')
                    ->set_classes('url_origin'),
                Field::make('text', 'url_destiny', 'Url de destino')
                    ->set_classes('url_destiny'),

                Field::make('html', 'doc-url-redirect')
                    ->set_html('
                        Regras para evitar loop infinito no servidor:
                        <ul>
                            <li class="equal-fields">- <b>"Url de origem"</b> e <b>"Url de destino"</b> não podem ser iguais</li>
                            <li>- Redirecionamentos em cadeia não são permitidos, exemplo: Redirecionar de <b>"A"</b> para <b>"B"</b> e de <b>"B"</b> para <b>"C"</b></li>
                        </ul>
                    '),
            ]);
    }
