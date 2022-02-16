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
    add_shortcode('workshop-calendar', 'workshop_calendar');
}

function blog_post_products() {
    $post_products = get_field('post_product', $post_object->ID);
    $html = '<div class="post-products-container">';
    foreach ($post_products as $post_product) :
        $product = wc_get_product( $post_product->ID );
        $html .= '<div class="post-product">';
        $html .= wp_get_attachment_image( get_post_thumbnail_id( $post_product->ID ), 'single-post-thumbnail' );
        $html .= '<p>' . $product->get_categories() . '</p>';
        $html .= '<h2>' . $post_product->post_title . '</h2>';
        $html .= '<p class="blog-product-price">$' . $product->get_price() . '</p>';
        $html .= '<a href="' . $post_product->guid . '" class="blog-product-link">View Product</a>';
        $html .= '</div>';
    endforeach;
    $html .= '</div>';
    return $html;
}

function workshop_calendar( $chi_workshops ) {
    $date_now = date('Y-m-d');
    $time_now = strtotime($date_now);

    $chi_workshops = get_posts( array(
        'posts_per_page' => -1,
        'post_type' => 'workshops',
        'meta_key'  => 'start_date_&_time',
        'orderby'   => 'meta_value',
        'order'     => 'ASC',
        'meta_type' => 'DATETIME',
        'meta_query' => array(
            array(
            'key'		=> 'start_date_&_time',
            'compare'	=> '>=',
            'value'       => $date_now,
            'type' => 'DATETIME'
            ),
       ),
    ) );
    $group_workshops = array();
    if ( $chi_workshops ) {
        $html = '<div class="workshops">';
        foreach ( $chi_workshops as $workshop ) :
            $start_date = get_field('start_date_&_time', $workshop->ID, false);
            $start_date = new DateTime($start_date);
            $year = $start_date->format('Y');
            $month = $start_date->format('F');
            $group_workshops[$year][$month][] = [
                'workshop' => $workshop,
                'date' => $start_date
            ];
        endforeach;

        foreach ($group_workshops as $yearKey => $years) :
            $html .= '<div class="workshops-year-block">';
            $html .= '<div class="post-grid workshops">';
            foreach ($years as $monthKey => $months) :
                $html .= '<div class="workshop-month">';
                $html .= '<h2>' . $monthKey . ' ' . $yearKey . '</h2>';
                    foreach ($months as $postKey => $posts) :
                        $workshop = $posts['workshop'];
                        $workshop_date = $posts['date'];
                        $start_date = get_field('start_date_&_time', $workshop->ID, false);
                        $start_date = new DateTime($start_date);
                        $end_date = get_field('end_date_&_time', $workshop->ID, false);
                        $end_date = new DateTime($end_date);
                        $workshop_start_day = $start_date->format('d');
                        $workshop_end_day = $end_date->format('d');
                        $workshop_start_month = $start_date->format('n');
                        $workshop_end_month = $end_date->format('n');
                        $types = get_the_terms( $workshop->ID, 'workshop_type');
                        if ( ! empty( $types ) && ! is_wp_error( $types ) ) {
                            $workshop_types = wp_list_pluck( $types, 'slug' );
                        }
                        $html .= '<div class="workshop-block">';
                                $html .= '<div class="workshop-date">';
                                    $html .= '<span>';
                                    $html .= $workshop_start_month . ' / ' . $workshop_start_day;
                                    if ($workshop_start_month != $workshop_end_month):
                                        $html .= ' -<br/>' . $workshop_end_month . ' / ' . $workshop_end_day;
                                    else:
                                        if ($workshop_start_day != $workshop_end_day):
                                            $html .= ' -<br/>' . $workshop_end_month . ' / ' . $workshop_end_day;
                                        endif;
                                    endif;
                                    $html .= '</span>';
                                $html .= '</div>';
                                if ($workshop_types[0] == 'chirunning-clinic'):
                                    $html .= '<a class="chirunning-clinic" href="' . get_permalink($workshop->ID) . '">' . $workshop->post_title . '</a>';
                                elseif ($workshop_types[0] == 'chirunning-tune-up'):
                                    $html .= '<a class="chirunning-tune-up" href="' . get_permalink($workshop->ID) . '">' . $workshop->post_title . '</a>';
                                elseif ($workshop_types[0] == 'chirunning-workshop'):
                                    $html .= '<a class="chirunning-workshop" href="' . get_permalink($workshop->ID) . '">' . $workshop->post_title . '</a>';
                                elseif ($workshop_types[0] == 'chiwalk-run-workshop'):
                                    $html .= '<a class="chiwalk-run-workshop" href="' . get_permalink($workshop->ID) . '">' . $workshop->post_title . '</a>';
                                elseif ($workshop_types[0] == 'chiwalking-workshop'):
                                    $html .= '<a class="chiwalking-workshop" href="' . get_permalink($workshop->ID) . '">' . $workshop->post_title . '</a>';
                                else :
                                    $html .= '<a href="' . get_permalink($workshop->ID) . '">' . $workshop->post_title . '</a>';
                                endif;
                                $html .= '</div><!--end workshop-block -->';
                    endforeach;
                $html .= '</div><!--end workshop-month -->';
            endforeach;
            $html .= '</div><!-- end post-grid workshops -->';
            $html .= '</div><!--end workshop year block -->';
        endforeach;
    }
    return $html;
}
// POPULATE EDIT YOUR WORKSHOP TAB FIELD WITH GRAVITY FORM
add_filter('acf/format_value/key=field_620c3b824c402', 'my_acf_format_value', 10, 3);
add_filter('acf/format_value/key=field_620c396edc256', 'my_acf_format_value', 10, 3);
function my_acf_format_value( $value, $post_id, $field ) {
    return do_shortcode( $value );
}

//PRE POPULATE INSTRUCTOR GRAVITY FORM FIELD WITH INSTRUCTOR EMAIL
add_filter('gform_field_value_instructor_email', 'instructor_email');
function instructor_email($value){
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    $author_id = get_the_author_meta('ID');
    $author_email = $curauth->user_email;
    return $author_email;
}
//PRE POPULATE INSTRUCTOR WORKSHOP EDIT FORM FIELDS
add_filter('gform_field_value_workshop_instructor_email', 'workshop_instructor_email');
function workshop_instructor_email($value){
    $current_user = wp_get_current_user();
    $workshop_instructor_email = $current_user->user_email;
    return $workshop_instructor_email;
}
add_filter('gform_field_value_workshop_instructor_name', 'workshop_instructor_name');
function workshop_instructor_name($value){
    $current_user = wp_get_current_user();
    $workshop_instructor_name = $current_user->display_name;;
    return $workshop_instructor_name;
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

add_action('wp_body_open','back_to_top_anchor');
function back_to_top_anchor(){
    echo '<span id="top"></span>';
}
add_action ('get_footer', 'back_to_top_image');
function back_to_top_image() { ?>
    <a class="footer-top-arrow" href="#top"><img src="/wp-content/uploads/2022/01/back-to-top-icon.png" alt="back to top"></a>
<?php }


add_filter('acf/load_value/key=field_61d8b086552d9', 'set_testimonial_start_rows', 20, 3);
function set_testimonial_start_rows($value, $post_id, $field) {
    if (!$value) {
      $row = array(
        'field_61d8af3a349db' => NULL,
        'field_61d8af51349dc' => NULL,
        'field_61d8af7a349dd' => NULL
      );
      $number_of_rows = 1;
      $value = array_fill(0, $number_of_rows, $row);
    }
    return $value;
  }

add_filter('acf/load_value/key=field_61d8b0f3552dc', 'set_best_races_start_rows', 20, 3);
function set_best_races_start_rows($value, $post_id, $field) {
    if (!$value) {
        $row = array(
        'field_61d8b0ef552db' => NULL,
        'field_61d8b12d552dd' => NULL,
        'field_61d8b143552de' => NULL,
        'field_61d8b14e552df' => NULL,
        'field_61d8b15f552e0' => NULL
        );
        $number_of_rows = 1;
        $value = array_fill(0, $number_of_rows, $row);
    }
return $value;
}
// global $wp_roles;
// $roles = $wp_roles->roles;

// // print it to the screen
// echo '<pre>' . print_r( $roles, true ) . '</pre>';

// function um_custom_echo_roles() {
//     global $wp_roles;
//     foreach ( $wp_roles->roles as $roleID => &$role_data ) {
//         unset( $role_data['_um_can_access_wpadmin'] );
//         unset( $role_data['_um_can_not_see_adminbar'] );
//         unset( $role_data['_um_can_edit_everyone'] );
//         unset( $role_data['_um_can_delete_everyone'] );
//         unset( $role_data['_um_can_edit_profile'] );
//         unset( $role_data['_um_can_delete_profile'] );
//         unset( $role_data['_um_default_homepage'] );
//         unset( $role_data['_um_after_login'] );
//         unset( $role_data['_um_after_logout'] );
//         unset( $role_data['_um_can_view_all'] );
//         unset( $role_data['_um_can_make_private_profile'] );
//         unset( $role_data['_um_can_access_private_profile'] );
//         unset( $role_data['_um_status'] );
//         unset( $role_data['_um_auto_approve_act'] );
//         if ( ! empty( $role_meta ) ) {
//             $wp_roles->roles[ $roleID ] = array_merge( $role_data, $role_meta );
//         }
//     }
//     update_option( $wp_roles->role_key, $wp_roles->roles );
//     $um_instructors = get_users( array(
//         'role__in' => 'um_instructor',
//        ) );
//     if ( ! empty( $um_instructors ) ) {
//         foreach ( $um_instructors as $instructor ) {
//             $instructor->remove_role( 'um_instructor' );
//         }
//     }
// }
// add_action( 'init', 'um_custom_echo_roles' );

