<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
add_action('wp_enqueue_scripts', 'madcow_enqueue_styles', 20);
function madcow_enqueue_styles()
{
    //wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    $css_file = get_stylesheet_directory() . '/chi-styles.css';
    $js_file = get_stylesheet_directory() . '/chi-js.js';
    wp_enqueue_style( 'chi-style', get_stylesheet_directory_uri() . '/chi-styles.css', array('hello-elementor-theme-style'), filemtime($css_file) );
    wp_enqueue_script( 'chi_js', get_stylesheet_directory_uri() . '/chi-js.js', array('jquery'), filemtime($js_file), false );
}


// REMOVE PAGE TITLES
add_filter( 'hello_elementor_page_title', 'madcow_disable_page_title' );
function madcow_disable_page_title( $return ) {
  return false;
}

// REGISTER ALL CUSTOM SHORTCODES
add_action( 'init', 'madcowweb_shortcodes');
function madcowweb_shortcodes(){
    add_shortcode('blog-post-products', 'blog_post_products');
}

function blog_post_products() {
    $post_products = get_field('post_product', $post_object->ID);
    $html = '<div class="post-products-container">';
    foreach ($post_products as $post_product) :
        $product = wc_get_product( $post_product->ID );
        $html .= '<div class="post-product">';
        $html .= wp_get_attachment_image( get_post_thumbnail_id( $post_product->ID ), 'single-post-thumbnail' );
        $html .= '<p>' . $product->get_categories() . '</p>';
        $html .= '<p>' . $post_product->post_title . '</p>';
        $html .= '<p class="blog-product-price">' . $product->get_price() . '</p>';
        $html .= '<a href="' . $post_product->guid . '" class="blog-product-link">View Product</a>';
        $html .= '</div>';
    endforeach;
    $html .= '</div>';
    return $html;
}

//PRE POPULATE INSTRUCTOR GRAVITY FORM FIELD WITH INSTRUCTOR EMAIL
add_filter('gform_field_value_instructor_email', 'instructor_email');
function instructor_email($value){
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    $author_id = get_the_author_meta('ID');
    $author_email = $curauth->user_email;
    return $author_email;
}


/* ADD GTM TO HEAD AND BELOW OPENING BODY */
//add_action('wp_head', 'madcowweb_header_snippet', 999);
function madcowweb_header_snippet() { ?>
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1665318150424342');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1665318150424342&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<!-- GA Google Analytics @ https://m0n.co/ga -->
<script type="text/plain" data-cli-class="cli-blocker-script" data-cli-label="Google Analytics"  data-cli-script-type="non-necessary" data-cli-block="true" data-cli-block-if-ccpa-optout="false" data-cli-element-position="head">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-18513126-1', 'auto');
    ga('send', 'pageview');
</script>
  <!-- THIS ADDS SUPPORT FOR FONT AWESOME -->
<link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
<?php }
