<?php
/**
 * The site's entry point.
 *
 * Loads the relevant template part,
 * the loop is executed (when needed) by the relevant template part.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$author_id = get_the_author_meta('ID');
$author_first_name = $curauth->first_name;
$ins_bio = get_field('bio', 'user_'. $author_id );
$ins_background = get_field('instructor_background_hero_image', 'option');
$ins_youtube_video_url  = get_field('youtube_video_url', 'user_'. $author_id);
$ins_source_photo  = get_field('source_photo', 'user_'. $author_id);
$ins_workshop_text  = get_field('workshop_text', 'user_'. $author_id);
$ins_website  = get_field('website', 'user_'. $author_id);
$ins_facebook  = get_field('facebook', 'user_'. $author_id);
$ins_twitter  = get_field('twitter', 'user_'. $author_id);
$ins_linkedin  = get_field('linkedin', 'user_'. $author_id);
$ins_instagram  = get_field('instagram', 'user_'. $author_id);
$ins_youtube  = get_field('youtube', 'user_'. $author_id);
$ins_phone  = get_field('phone', 'user_'. $author_id);
$ins_show_phone_publicly  = get_field('show_phone_publicly', 'user_'. $author_id);
$ins_email  = get_field('email', 'user_'. $author_id);
$ins_show_email_publicly  = get_field('show_email_publicly', 'user_'. $author_id);
$ins_location  = get_field('location', 'user_'. $author_id);
$ins_testimonial  = get_field('testimonial', 'user_'. $author_id);
$ultra_marathon = get_field('number_of_ultra_marathons', 'user_'. $author_id);
$marathon = get_field('number_of_marathons', 'user_'. $author_id);
$half_marathon = get_field('number_of_half_marathons', 'user_'. $author_id);
$tenk = get_field('number_of_10ks', 'user_'. $author_id);
$fivek = get_field('number_of_5ks', 'user_'. $author_id);
$ins_personal_racing_best  = get_field('personal_racing_best', 'user_'. $author_id);
$ins_certification_level  = get_field('certification_level', 'user_'. $author_id);
$ins_chirunning_certification  = get_field('chirunning_certification', 'user_'. $author_id);
$ins_chiwalking_certification  = get_field('chiwalking_certification', 'user_'. $author_id);
$ins_certification_date  = get_field('certification_date', 'user_'. $author_id, false);
$ins_certification_date = new DateTime($ins_certification_date);
$ins_regional_director  = get_field('regional_director', 'user_'. $author_id);
?>
<div class="author-content">
    <div class="instructor-banner"></div>
    <div class="instructor-header">
        <div class="left">
            <?php if ($ins_source_photo): ?>
                <img class="inst-img" src="<?php echo $ins_source_photo; ?>" alt="<?php echo $curauth->nickname; ?>">
            <?php else : ?>
                <img class="inst-img" src="/wp-content/uploads/2022/02/instructor-bio-placeholder.jpg" alt="<?php echo $curauth->nickname; ?>">
            <?php endif; ?>
            <div class="instructor-sub-header">
                <div class="instructor-icons">
                    <?php if ($ins_chirunning_certification) : ?>
                        <img src="/wp-content/uploads/2022/01/chirunning-certified-instructor.png" alt="">
                    <?php endif; ?>
                    <?php if ($ins_chiwalking_certification) : ?>
                        <img src="/wp-content/uploads/2022/01/chiwalking-certified-instructor.png" alt="">
                    <?php endif; ?>
                </div>
                <div class="instructor-title">
                    <h3><?php echo $ins_certification_level; ?></h3>
                    <h4>Certified since <?php echo $ins_certification_date->format('F Y'); ?></h4>
                </div>
            </div>
        </div>
        <div class="right">
            <h2><?php echo $curauth->nickname; ?></h2>
            <div class="quick-location">
                <img src="/wp-content/uploads/2022/01/instructor-map-marker-icon.png" alt="instructor map marker">
                <?php echo $ins_location['state']; ?>
            </div>
            <h3>Connect with <?php echo $author_first_name; ?></h3>
            <div class="instructor-social">
                <?php if ($ins_facebook) : ?>
                    <a class="elementor-animation-push" target="_blank" href="<?php echo $ins_facebook; ?>"><i class="fab fa-facebook-f"></i></a>
                <?php endif; ?>
                <?php if ($ins_twitter) : ?>
                    <a class="elementor-animation-push" target="_blank" href="<?php echo $ins_twitter; ?>"><i class="fab fa-twitter"></i></a>
                <?php endif; ?>
                <?php if ($ins_linkedin) : ?>
                    <a class="elementor-animation-push" target="_blank" href="<?php echo $ins_linkedin; ?>"><i class="fab fa-linkedin"></i></a>
                <?php endif; ?>
                <?php if ($ins_instagram) : ?>
                    <a class="elementor-animation-push" target="_blank" href="<?php echo $ins_instagram; ?>"><i class="fab fa-instagram"></i></a>
                <?php endif; ?>
                <?php if ($ins_youtube) : ?>
                    <a class="elementor-animation-push" target="_blank" href="<?php echo $ins_youtube; ?>"><i class="fab fa-youtube"></i></a>
                <?php endif; ?>
                <?php if ($ins_website) : ?>
                    <a class="elementor-animation-push" target="_blank" href="<?php echo $ins_website; ?>"><i class="fas fa-globe"></i></a>
                <?php endif; ?>
                <?php if ($ins_phone && $ins_show_phone_publicly == 'yes') : ?>
                    <a class="elementor-animation-push" target="_blank" href="tel:<?php echo $ins_phone; ?>"><i class="fas fa-phone"></i></a>
                <?php endif; ?>
                <?php if ($ins_email && $ins_show_email_publicly == 'yes') : ?>
                    <a class="elementor-animation-push" target="_blank" href="mailto:<?php echo $ins_email; ?>"><i class="fas fa-envelope"></i></a>
                <?php endif; ?>
            </div> <!-- end instructor social -->
        </div>
        </div><!-- End instructor header -->
        <div class="tab">
            <?php if ($ins_youtube_video_url) : ?>
                <button class="tablinks active" onclick="openDetails(event, 'video')" id="defaultOpen">Instructor Video</button>
            <?php endif; ?>
            <?php if ($ins_bio) : ?>
                <button class="tablinks" onclick="openDetails(event, 'about')">About</button>
            <?php endif; ?>
            <?php if ($ins_testimonial) : ?>
                <button class="tablinks" onclick="openDetails(event, 'testimonials')">Testimonials</button>
            <?php endif; ?>
            <button class="tablinks" onclick="openDetails(event, 'contact')">Contact</button>
        </div>
        <!-- Tab content -->
        <?php if ($ins_youtube_video_url) : ?>
            <div id="video" class="tabcontent" style="display: block;">
                <iframe width="560" height="315" src="<?php echo $ins_youtube_video_url; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        <?php endif; ?>

        <?php if ($ins_bio && empty($ins_youtube_video_url)) : ?>
            <div id="about" class="tabcontent" style="display: block;">
                <p><?php echo $ins_bio; ?></p>
            </div>
        <?php elseif ($ins_bio && !empty($ins_youtube_video_url)) : ?>
            <div id="about" class="tabcontent">
                <p><?php echo $ins_bio; ?></p>
            </div>
        <?php endif; ?>

        <?php if ($ins_testimonial) : ?>
            <div id="testimonials" class="tabcontent">
                <?php
                if( have_rows('testimonial', 'user_'. $author_id) ):
                    while( have_rows('testimonial', 'user_'. $author_id) ) : the_row();
                        $testimonial_image = get_sub_field('testimonial_image');
                        $testimonial_text = get_sub_field('testimonial_text');
                        $testimonial_author = get_sub_field('testimonial_author'); ?>
                        <div class="testimonial">
                                <img src="<?php echo $testimonial_image; ?>" alt="<?php echo $testimonial_author; ?>">
                                <p><?php echo $testimonial_text; ?></p>
                                <p><?php echo $testimonial_author; ?></p>
                        </div>
                    <?php endwhile;
                    else :
                endif; ?>
            </div>
        <?php endif; ?>

        <div id="contact" class="tabcontent">
            <?php gravity_form( 4, false, false, false, '', false ); ?>
        </div>
        <?php $today = date("Y-m-d H:i:s");
        $workshops = get_posts (array(
            'post_type' => 'workshops',
            'posts_per_page' => -1,
            'product_status' => 'publish',
            'meta_query' => array( 'main_query' => array(
                'key' => 'instructor',
                'value' => $author_id
            ), 'orderby_query' => array(
                'key' => 'start_date_&_time',
                'value' => $today,
                'compare' => '>='
            )
        ),
        'orderby' => array(
            'orderby_query' => 'ASC',
        ),

        ));
        if ($workshops) : ?>
            <div class="instructor-workshops-section">
                <h2 class="site-main">Workshops & Private Sessions</h2>
                <div class="workshop-row">
                <?php foreach ($workshops as $workshop) :
                    $instructor = get_field('instructor', $workshop->ID);
                    $workshop_name = get_field('name', $workshop->ID);
                    $workshop_cost = get_field('cost', $workshop->ID);
                    $workshop_start_date = get_field('start_date_&_time', $workshop->ID, false);
                    $workshop_start_date = new DateTime($workshop_start_date);
                    $workshop_city = get_field('city', $workshop->ID);
                    $workshop_state = get_field('state', $workshop->ID);
                    $workshop_country = get_field('country', $workshop->ID);
                    $workshop_register = get_field('link_to_purchase_workshop', $workshop->ID); ?>
                    <div class="workshop">
                        <?php
                        echo '<p>' . $workshop_start_date->format('m\/d\/Y') . '</p>';
                        echo '<a href="' . get_the_permalink($workshop->ID) . '">' . $workshop_name . '</a>';
                        echo '<p class="workshop-location">' . $workshop_city . ' ' . $workshop_state . ' ' . $workshop_country . '</p>';
                        echo '<a class="workshop-register" href="' . $workshop_register . '" target="_blank">REGISTER</a>';
                        ?>
                    </div><!-- endworkshop -->
                        <?php endforeach; ?>
                </div><!-- end workshop row -->
            </div><!-- end instructor workshop section -->
        <?php endif; ?>
            <div class="instructor-races">
                <h2>Race Resume</h2>
                <div class="race-row">
                    <div class="race">
                        <p>Ultra Marathons</p>
                        <?php if ($ultra_marathon):
                            echo '<p class="race-number" id="value" data-value="' . $ultra_marathon . '">' . $ultra_marathon . '</p>';
                        else :
                            echo '<p class="race-number" id="value">0</p>';
                        endif; ?>
                    </div>
                    <div class="race">
                        <p>Marathons</p>
                        <?php if ($marathon):
                            echo '<p class="race-number" id="value" data-value="' . $marathon . '">' . $marathon . '</p>';
                        else :
                            echo '<p class="race-number" id="value">0</p>';
                        endif; ?>
					</div>
                    <div class="race">
                        <p>Half Marathons</p>
                        <?php if ($half_marathon):
                            echo '<p class="race-number" id="value" data-value="' . $half_marathon . '">' . $half_marathon . '</p>';
                        else :
                            echo '<p class="race-number" id="value">0</p>';
                        endif; ?>
					</div>
                    <div class="race">
                        <p>10Ks</p>
                        <?php if ($tenk):
                            echo '<p class="race-number" id="value" data-value="' . $tenk . '">' . $tenk . '</p>';
                        else :
                            echo '<p class="race-number" id="value">0</p>';
                        endif; ?>
					</div>
                    <div class="race">
                        <p>5Ks</p>
                        <?php if ($fivek):
                            echo '<p class="race-number" id="value" data-value="' . $fivek . '">' . $fivek . '</p>';
                        else :
                            echo '<p class="race-number" id="value">0</p>';
                        endif; ?>
					</div>
                </div><!-- end race row -->
            </div><!-- end instructor races -->
    </div><!-- end author-content -->
<?php
get_footer();