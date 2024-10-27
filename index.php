<?php
get_header();
?>
<main>
    <section class="about">
        <div class="wrapper">
            <h2>ABOUT</h2>
            <p>はじめまして</p>
            <p>Rimauto417と言います</p>
            <p>Webデザイナー、コーダーとセールスライターを行っています。</p>
            <p>
                機能的でスタイリッシュなデザインやウェブサイトを丁寧に迅速に、お手頃価格で作成していきます。
            </p>
        </div>
    </section>

    <section class="blog">
        <h2>Blog</h2>
        <div class="card">
            <article class="card-body">
                <?php
                // 最新の6件の投稿のみ表示
                $args = array(
                    'posts_per_page' => 6,  // 1ページに表示する投稿数
                    'paged' => 1,           // 最初のページ（ページネーションは使用しないので1固定）
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


                            <h4><?php the_title(); ?></h4>

                            <!-- 記事の要約を40文字以内で表示 -->
                            <p class="description">
                                <?php echo wp_trim_words(get_the_excerpt(), 40, '...'); ?>
                            </p>
                        </a>
                <?php endwhile;
                else :
                    echo '<p>投稿がありません。</p>';
                endif;

                // クエリをリセット
                wp_reset_postdata();
                ?>
            </article>
            <div class="blog-link"><a href="<?php echo site_url('/blog'); ?>">Show More</a></div>
        </div>


    </section>
    <!-- <section class="portfolio">
        <h2>Portfolio</h2>
        <h3>Portfolio Card 予定場所</h3>
    </section> -->
</main>
<?php
get_footer()
?>