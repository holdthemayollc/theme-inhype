<?php
/**
 * Post template part: Post review block
 */

// Get post review settings
$post_review_image = get_post_meta( get_the_ID(), '_inhype_post_review_image', true );
$post_review_color = get_post_meta( get_the_ID(), '_inhype_post_review_color', true );
$post_review_title = get_post_meta( get_the_ID(), '_inhype_post_review_title', true );
$post_review_summary = get_post_meta( get_the_ID(), '_inhype_post_review_summary', true );
$post_review_positives = get_post_meta( get_the_ID(), '_inhype_post_review_positives', true );
$post_review_positives = explode("\n", str_replace("\r", "", $post_review_positives));
$post_review_negatives = get_post_meta( get_the_ID(), '_inhype_post_review_negatives', true );
$post_review_negatives = explode("\n", str_replace("\r", "", $post_review_negatives));
$post_review_button_url = get_post_meta( get_the_ID(), '_inhype_post_review_button_url', true );
$post_review_button_title = get_post_meta( get_the_ID(), '_inhype_post_review_button_title', true );
$post_review_criteria_group = get_post_meta( get_the_ID(), '_inhype_review_criteria_group', true );

if(isset($post_review_image) && ($post_review_image !== '')) {
  $post_review_image_style = 'background-image: url('.$post_review_image.');';
  $post_review_class = ' with-bg';
} else {
  $post_review_image_style = '';
  $post_review_class = '';
}

$criterias = array();

$criteria_value_total = 0;

foreach ( (array) $post_review_criteria_group as $key => $value ) {

    $criteria_title = $criteria_value = '';

    if ( !empty( $value['criteria_value'] ) ) {
        $criteria_value = $value['criteria_value'];
         $criteria_value_total += $criteria_value;
    }

    if ( !empty( $value['criteria_title'] ) ) {
        $criteria_title = $value['criteria_title'];
        $criterias[$criteria_title] = $criteria_value;
    }

}

$post_review_rating = 0;

if(count($criterias) > 0) {
    $post_review_rating = $criteria_value_total / count($criterias) / 10;
} else {
    $post_review_rating = 0;
}

?>
<div class="post-review-block<?php echo esc_attr($post_review_class); ?>">

    <?php if(!empty($post_review_image_style)): ?>
    <div class="post-review-image inhype-parallax" data-style="<?php echo esc_attr($post_review_image_style); ?>" data-speed="0.1">
    </div>
    <?php endif; ?>

    <div class="post-review-header"><h3><?php echo esc_html($post_review_title); ?></h3></div>
    <?php if(!empty($post_review_summary)): ?>
    <div class="post-review-summary clearfix">
            <?php if($post_review_rating > 0): ?>
            <div class="post-review-rating-total headers-font" data-style="background-color: <?php echo esc_attr($post_review_color); ?>;"><?php echo esc_html(number_format($post_review_rating, 1)); ?></div>
            <?php endif; ?>
            <?php echo wp_kses_post($post_review_summary); ?>
    </div>
    <?php endif; ?>
    <?php if(count($criterias) > 0): ?>
    <div class="post-review-criteria-group">
        <?php foreach ($criterias as $key => $value): ?>
        <div class="post-review-criteria">
            <div class="post-review-criteria-rating headers-font"><?php echo wp_kses_post(sprintf("%0.1f",number_format($value / 10, 1))); ?></div>
            <div class="post-review-criteria-title"><h4><?php echo wp_kses_post($key); ?></h4></div>

            <div class="post-review-criteria-progress"><div class="post-review-criteria-value" data-style="background-color: <?php echo esc_attr($post_review_color); ?>; width: <?php echo wp_kses_post($value); ?>%;"></div></div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div class="post-review-details">
        <div class="post-review-details-column post-review-positives">
            <?php if(count($post_review_positives) > 0): ?>
            <h4><i class="fa fa-smile-o" aria-hidden="true"></i><?php esc_html_e('Pros', 'inhype'); ?></h4>
            <ul>
                <?php
                foreach ($post_review_positives as $value) {
                    echo '<li><span>+</span>'.wp_kses_post($value).'</li>';
                }
                ?>
            </ul>
            <?php endif; ?>
        </div>
        <div class="post-review-details-column post-review-negatives">
            <?php if(count($post_review_negatives) > 0): ?>
            <h4><i class="fa fa-frown-o" aria-hidden="true"></i><?php esc_html_e('Cons', 'inhype'); ?></h4>
            <ul>
                <?php
                foreach ($post_review_negatives as $value) {
                    echo '<li><span>-</span>'.wp_kses_post($value).'</li>';
                }
                ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
    <?php if(!empty($post_review_button_url)): ?>
    <div class="post-review-button-wrapper">
        <a class="btn" href="<?php echo esc_url($post_review_button_url); ?>" target="_blank"><i class="fa fa-shopping-cart"></i><?php echo esc_html($post_review_button_title); ?></a>
    </div>
    <?php endif; ?>
</div>
