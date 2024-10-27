<?php

function myBlog_files()
{
  wp_enqueue_script('myBlog-js', get_theme_file_uri('/dist/index.js'), array('jquery'), '1.0', true); // 'true'でフッターに配置
  wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), null, 'all'); // as 'all' for async

  // 本番ではdistファイルから持ってくるようにする
  wp_enqueue_style('myBlog_main_styles', get_theme_file_uri('/src/style.css'), array('font-awesome'));
}


add_action('wp_enqueue_scripts', 'myBlog_files');

function myBlog_features()
{

  // アイキャッチ画像をサポート
  add_theme_support('post-thumbnails');

  // 投稿の要約（excerpt）をサポート
  add_post_type_support('post', 'excerpt');
}

add_action('after_setup_theme', 'myBlog_features');

// サムネイルサイズの追加
function myBlog_custom_image_sizes()
{
  add_image_size('custom-thumbnail', 300, 200, true); // 横300px、縦200pxで切り抜き
  add_image_size('blog-banner', 1024, 576, true); // 横1024px、縦576pxで切り抜き
}
add_action('after_setup_theme', 'myBlog_custom_image_sizes');

// WebP形式の生成
function generate_webp_image($file_path)
{
  $image = wp_get_image_editor($file_path);
  if (!is_wp_error($image)) {
    $webp_path = str_replace(['.jpg', '.jpeg', '.png'], '.webp', $file_path);
    $image->set_quality(85);
    $result = $image->save($webp_path, 'image/webp');
    return $result ? $webp_path : false;
  }
  return false;
}

// WebP形式の生成とメタデータの更新
function generate_webp_and_update_metadata($metadata)
{
  $upload_dir = wp_upload_dir();
  $file_path = $upload_dir['basedir'] . '/' . $metadata['file'];

  // メイン画像のWebP生成
  $webp_path = generate_webp_image($file_path);
  if ($webp_path) {
    // メタデータにWebPファイルを追加
    $metadata['webp'] = str_replace($upload_dir['basedir'], $upload_dir['baseurl'], $webp_path);
  }

  // サイズごとのWebP生成
  foreach ($metadata['sizes'] as $size => $size_info) {
    $size_file_path = $upload_dir['basedir'] . '/' . dirname($metadata['file']) . '/' . $size_info['file'];
    $size_webp_path = generate_webp_image($size_file_path);
    if ($size_webp_path) {
      // メタデータにWebPファイルを追加
      $metadata['sizes'][$size]['webp'] = str_replace($upload_dir['basedir'], $upload_dir['baseurl'], $size_webp_path);

      // 不要なPNGファイルを削除
      if (strpos($size_file_path, '.png') !== false) {
        unlink($size_file_path);
      }
    }
  }

  // オリジナル画像の削除
  if (file_exists($file_path)) {
    unlink($file_path);
  }

  return $metadata;
}
add_filter('wp_generate_attachment_metadata', 'generate_webp_and_update_metadata');

// メディアライブラリにWebP画像を表示
function display_webp_in_media_library($response, $attachment, $meta)
{
  $upload_dir = wp_upload_dir();

  // WebPファイルが存在する場合、URLを上書き
  if (!empty($meta['webp'])) {
    $response['url'] = $meta['webp'];
  }
  return $response;
}
add_filter('wp_prepare_attachment_for_js', 'display_webp_in_media_library', 10, 3);



// 画面変更に関するリダイレクト設定
function check_if_mobile()
{
  if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Mobile|Android|iPhone|iPad/', $_SERVER['HTTP_USER_AGENT'])) {
    if (!isset($_GET['view']) || $_GET['view'] !== 'mobile') {
      header("Location: " . add_query_arg('view', 'mobile'));
      exit;
    }
  }
  return false;
}

// メニューを管理画面でカスタムする設定

function register_my_menu()
{
  register_nav_menu('primary-menu', __('Primary Menu'));
}
add_action('init', 'register_my_menu');
