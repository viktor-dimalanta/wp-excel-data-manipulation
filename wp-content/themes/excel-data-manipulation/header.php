<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
</head>
<body <?php body_class(); ?>>
    <header>
        <div class="container">
            <h1><?php bloginfo('name'); ?></h1>
            <p><?php bloginfo('description'); ?></p>
            <nav>
                <!-- Your navigation menu goes here -->
                <?php
                // wp_nav_menu(array(
                //     'theme_location' => 'primary',
                //     'container' => false,
                //     'menu_class' => 'menu',
                // ));
                ?>
            </nav>
        </div>
    </header>
