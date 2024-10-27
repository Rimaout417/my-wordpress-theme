<?php
get_header();
?>
<main>
    <div class="card">
        <article class="card-body">
            <?php
            // 画面がモバイルかどうかを判定
            $posts_per_page = (isset($_GET['view']) && $_GET['view'] === 'mobile') || check_if_mobile() ? 6 : 9;


            // 1ページに表示する投稿数を設定
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // 現在のページ番号を取得
            $args = array(
                'posts_per_page' => $posts_per_page,   // モバイルなら6件、デスクトップなら9件表示
                'paged' => $paged,       // 現在のページ番号を指定
            );
            $custom_query = new WP_Query($args);

            if ($custom_query->have_posts()) : while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="link">
                        <!-- アイキャッチ画像を表示 -->
                        <?php if (has_post_thumbnail()) : ?>
                            <picture>
                                <?php
                                // WebP画像のURLを取得
                                $webp_url = esc_url(str_replace('.jpg', '.webp', get_the_post_thumbnail_url(null, 'custom-thumbnail')));
                                $webp_url = str_replace('.png', '.webp', $webp_url); // PNG形式にも対応

                                // ファイルが存在するか確認
                                $upload_dir = wp_upload_dir();
                                $file_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $webp_url);

                                // WebP画像が存在する場合のみWebPの<source>タグを出力
                                if (file_exists($file_path)) : ?>
                                    <source srcset="<?php echo $webp_url; ?>" type="image/webp">
                                <?php endif; ?>

                                <!-- フォールバック画像 -->
                                <img src="<?php the_post_thumbnail_url('custom-thumbnail'); ?>" alt="<?php the_title(); ?>" class="frame" width="400" height="300" loading="lazy">
                            </picture>
                        <?php else : ?>
                            <!-- 事前に指定した画像を表示 -->
                            <picture>
                                <!-- WebP形式の事前指定画像 -->
                                <source srcset="<?php echo esc_url(get_template_directory_uri() . '/images/default-image.webp'); ?>" type="image/webp">
                                <!-- フォールバック画像 -->
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/default-image.jpg'); ?>" alt="default image" class="frame" width="400" height="300" loading="lazy">
                            </picture>
                        <?php endif; ?>

                        <h3><?php the_title(); ?></h3>

                        <!-- 記事の要約を40文字以内で表示 -->
                        <p class="description">
                            <?php echo wp_trim_words(get_the_excerpt(), 40, '...'); ?>
                        </p>
                    </a>
            <?php endwhile;
            else :
                echo '<p>投稿がありません。</p>';
            endif;


            ?>
        </article>
        <div class="page-nation">
            <?php
            // ページネーションを表示
            $big = 999999999; // unique value for pagination
            echo paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $custom_query->max_num_pages
            ));

            // クエリをリセット
            wp_reset_postdata();
            ?>
        </div>
    </div>



</main>
<?php
get_footer()
?>