<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="<?php echo is_front_page() ? home_url() : get_permalink(); ?>" />

    <title>
        <?php
        if (is_front_page() || is_home()) {
            echo get_bloginfo('name') . ' | ' . get_bloginfo('description');
        } elseif (is_single() || is_page()) {
            wp_title('');
        } else {
            echo get_bloginfo('name');
        }
        ?>
    </title>

    <meta name="description" content="<?php
                                        if (is_single() || is_page()) {
                                            echo strip_tags(get_the_excerpt());
                                        } else {
                                            echo get_bloginfo('description');
                                        }
                                        ?>">

    <meta name="keywords" content="<?php
                                    if (is_single()) {
                                        $post_tags = get_the_tags();
                                        if ($post_tags) {
                                            $tags = [];
                                            foreach ($post_tags as $tag) {
                                                $tags[] = $tag->name;
                                            }
                                            echo implode(', ', $tags);
                                        }
                                    }
                                    ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header>
        <nav>
            <h1 class="school-logo-text float-left">
                <a href="<?php echo site_url() ?>">Blog</a>
            </h1>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary-menu', // テーマの functions.php に「primary-menu」を登録
                'menu_class' => 'primary-menu', // メニューに適用するクラス名
                'container' => false, // <div>ラッパーを排除する
                'items_wrap' => '<ul id="%1$s" class="%2$s" role="list">%3$s</ul>', // role属性を追加
                'link_before' => '<span>',
                'link_after' => '</span>',
            ));
            ?>
            <div class="hamburger">
                <!-- メニューアイコン -->
                <i class="fas fa-bars menu-icon menu"></i>
                <i class="fas fa-times menu-icon close"></i>
            </div>
        </nav>
    </header>