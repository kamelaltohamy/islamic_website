<?php
/**
 * The sidebar containing the homepage / main widgets.
 *
 * @package almukaddem
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<aside class="w-full lg:w-1/4 flex flex-col gap-6">

    <!-- Quick Navigation Menu -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-2">
        <ul class="space-y-1">
            <li><a href="<?php echo esc_url( get_post_type_archive_link( 'audio' ) ); ?>" class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 text-slate-700 hover:text-primary-900 transition-all duration-300 font-medium group"><div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-primary-700 group-hover:bg-accent-100 group-hover:text-accent-700 transition-all"><i class="fa-solid fa-microphone-lines"></i></div> <?php esc_html_e( 'جديد الصوتيات', 'almukaddem' ); ?></a></li>
            <li><a href="<?php echo esc_url( get_post_type_archive_link( 'video' ) ); ?>" class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 text-slate-700 hover:text-primary-900 transition-all duration-300 font-medium group"><div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-primary-700 group-hover:bg-accent-100 group-hover:text-accent-700 transition-all"><i class="fa-solid fa-video"></i></div> <?php esc_html_e( 'المرئيات', 'almukaddem' ); ?></a></li>
            <li><a href="<?php echo esc_url( get_post_type_archive_link( 'book' ) ); ?>" class="flex items-center gap-3 p-3 rounded-xl bg-primary-50 text-primary-900 font-bold border border-primary-100/30"><div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-accent-700"><i class="fa-solid fa-file-text"></i></div> <?php esc_html_e( 'التفريغات', 'almukaddem' ); ?></a></li>
            <li><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="flex items-center gap-3 p-3 rounded-xl hover:bg-primary-50 text-slate-700 hover:text-primary-900 transition-all duration-300 font-medium group"><div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-primary-700 group-hover:bg-accent-100 group-hover:text-accent-700 transition-all"><i class="fa-solid fa-newspaper"></i></div> <?php esc_html_e( 'المقالات', 'almukaddem' ); ?></a></li>
        </ul>
    </div>

    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    <?php endif; ?>

    <!-- "Chosen for you" Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-primary-900 text-white px-5 py-4 flex items-center gap-2 border-b border-accent-700">
            <i class="fa-solid fa-star text-accent-500"></i>
            <h3 class="font-bold text-base tracking-wide"><?php esc_html_e( 'اخترنا لك', 'almukaddem' ); ?></h3>
        </div>
        <div class="p-4 space-y-4">
            <?php
            $featured = new WP_Query( array(
                'post_type'      => array( 'post', 'audio', 'video', 'book' ),
                'posts_per_page' => 3,
                'orderby'        => 'rand',
            ) );
            while ( $featured->have_posts() ) : $featured->the_post();
            ?>
                <a href="<?php the_permalink(); ?>" class="group flex gap-3 items-start border-b border-slate-50 pb-4 last:border-0 last:pb-0">
                    <div class="w-14 h-14 rounded-xl bg-slate-50 flex-shrink-0 flex items-center justify-center text-slate-400 group-hover:bg-primary-50 group-hover:text-primary-700 transition">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'almukaddem-thumb', array( 'class' => 'w-full h-full object-cover rounded-xl' ) ); ?>
                        <?php else : ?>
                            <i class="fa-solid fa-play text-lg"></i>
                        <?php endif; ?>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-800 text-xs group-hover:text-accent-700 transition leading-relaxed line-clamp-2"><?php the_title(); ?></h4>
                        <?php
                        $terms = get_the_terms( get_the_ID(), 'audio_series' );
                        if ( $terms && ! is_wp_error( $terms ) ) :
                            echo '<span class="text-[10px] text-slate-400 mt-1 block font-serif"><i class="fa-regular fa-folder ml-1 text-accent-700"></i> ' . esc_html( $terms[0]->name ) . '</span>';
                        endif;
                        ?>
                    </div>
                </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>

    <!-- Newsletter / Subscribe -->
    <?php get_template_part( 'template-parts/newsletter' ); ?>

</aside>
