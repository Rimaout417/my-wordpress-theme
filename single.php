<?php
get_header();
?>
<main>
    <div class="generic-content">
        <!-- 記事のタイトルを最上部に表示 -->
        <h1><?php the_title(); ?></h1>

        <!-- 記事の内容を表示 -->
        <div class="post-content">
            <?php the_content(); ?>
        </div>
    </div>
</main>
<?php
get_footer()
?>