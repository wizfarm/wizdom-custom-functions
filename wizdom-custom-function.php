<?php 

/**
 * Plugin Name: Wizdom-custom-functions
 * Description: My Custom Functions
 * Plugin URI:  https://wizdom.wiz.farm?ref=wp-admin
 * Version:     0.1.0
 * Author:      WizFarm
 * Author URI:  https://wizdom.wiz.farm?ref=wp-admin
 * Text Domain: wizdom-custom-functions
 *
 * Elementor tested up to: 3.11.0
 * Elementor Pro tested up to: 3.11.0
 */

add_action( 'wizdom/openai/before_load', 'load_my_function_calls', 10, 1 );

function load_my_function_calls( $openai ) {
    $openai->add_function([
        'name' => 'my_func_get_wordpress_users',
        'description' => 'Retrieve a list of wordpress users',
        'parameters' => [
            'type' => "object",
            'properties' => [
                "order_id" => [
                    "type" => "integer",
                    "description" => "Unique Order ID ",
                ]
            ]
        ],
        'category' => 'Wordpress',
        'permission_callback' => 'is_super_admin'
    ]);
}

function my_func_get_wordpress_users(array $args) {
    $users = get_users();
    $toReturn = [];
    $response = '<ul>';
    foreach( $users as $user ){
        $response .= '<li>';
        $response .= $user->user_login;
        $response .= ' - ' . $user->user_email;
        $response .= '</li>';
    }
    $response .= "</ul>";
    return $response;
}