<?php
/**
 * Single Fatwa template.
 *
 * @package almukaddem
 */

get_header();

while ( have_posts() ) : the_post();
    $cats     = get_the_terms( get_the_ID(), 'fatwa_category' );
    $cat_name = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : '';
    $cat_link = ( $cats && ! is_wp_error( $cats ) ) ? get_term_link( $cats[0] ) : '';
    $fatwa_no = almukaddem_get_field( 'fatwa_number' );
    $answer   = almukaddem_get_field( 'fatwa_answer' );
?>

    <main class="container mx-auto px-4 py-8 max-w-4xl">

        <!-- Breadcrumbs -->
        <div class="text-xs text-slate-400 font-medium mb-6 flex items-center gap-2">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary-700 transition-colors"><i class="fa-solid fa-home"></i> <?php esc_html_e( 'الرئيسية', 'almukaddem' ); ?></a>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'fatwa' ) ); ?>" class="hover:text-primary-700 transition-colors"><?php esc_html_e( 'الفتاوى الشرعية', 'almukaddem' ); ?></a>
            <?php if ( $cat_link ) : ?>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <a href="<?php echo esc_url( $cat_link ); ?>" class="hover:text-primary-700 transition-colors"><?php echo esc_html( $cat_name ); ?></a>
            <?php endif; ?>
        </div>

        <!-- Question -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-10 mb-6">
            <div class="flex items-center gap-3 mb-4">
                <?php if ( $cat_name ) : ?><span class="bg-primary-50 text-primary-700 text-xs font-bold px-4 py-1.5 rounded-full border border-primary-100"><?php echo esc_html( $cat_name ); ?></span><?php endif; ?>
                <?php if ( $fatwa_no ) : ?><span class="text-xs text-slate-400 font-serif"><?php echo esc_html( sprintf( __( 'رقم الفتوى: %s', 'almukaddem' ), $fatwa_no ) ); ?></span><?php endif; ?>
            </div>
            <div class="flex gap-4 items-start">
                <div class="w-12 h-12 flex-shrink-0 rounded-full bg-primary-50 text-primary-700 flex items-center justify-center font-bold text-lg border border-primary-100"><i class="fa-solid fa-question"></i></div>
                <h1 class="text-2xl md:text-3xl font-bold text-primary-900 leading-snug pt-1"><?php the_title(); ?></h1>
            </div>
            <div class="flex items-center gap-4 mt-6 text-xs text-slate-400 font-serif border-t border-slate-100 pt-4">
                <span><i class="fa-regular fa-calendar ml-1 text-primary-400"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?></span>
                <span><i class="fa-regular fa-eye ml-1 text-primary-400"></i> <?php echo esc_html( number_format_i18n( almukaddem_get_views() ) ); ?></span>
            </div>
        </div>

        <!-- Answer -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-10">
            <div class="flex items-center gap-2 mb-6 pb-4 border-b border-slate-100">
                <i class="fa-solid fa-check-circle text-accent-600 text-lg"></i>
                <h2 class="font-bold text-primary-900 text-lg"><?php esc_html_e( 'الإجابة', 'almukaddem' ); ?></h2>
            </div>
            <div class="fatwa-content article-content font-serif text-slate-700 leading-loose">
                <?php if ( $answer ) : echo wp_kses_post( wpautop( $answer ) ); else : the_content(); endif; ?>
            </div>

            <!-- Share -->
            <div class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-500 ml-2"><?php esc_html_e( 'مشاركة:', 'almukaddem' ); ?></span>
                    <a href="https://api.whatsapp.com/send?text=<?php echo rawurlencode( get_the_title() . ' ' . get_the_permalink() ); ?>" target="_blank" class="w-10 h-10 rounded-xl bg-slate-50 text-[#25D366] hover:bg-[#25D366] hover:text-white flex items-center justify-center border border-slate-200 transition-all"><i class="fa-brands fa-whatsapp text-lg"></i></a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( get_the_permalink() ); ?>&text=<?php echo rawurlencode( get_the_title() ); ?>" target="_blank" class="w-10 h-10 rounded-xl bg-slate-50 text-[#1DA1F2] hover:bg-[#1DA1F2] hover:text-white flex items-center justify-center border border-slate-200 transition-all"><i class="fa-brands fa-twitter text-lg"></i></a>
                    <a href="https://t.me/share/url?url=<?php echo rawurlencode( get_the_permalink() ); ?>" target="_blank" class="w-10 h-10 rounded-xl bg-slate-50 text-[#0088cc] hover:bg-[#0088cc] hover:text-white flex items-center justify-center border border-slate-200 transition-all"><i class="fa-brands fa-telegram text-lg"></i></a>
                </div>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'fatwa' ) ); ?>" class="text-accent-700 hover:text-primary-800 text-xs font-bold transition-colors flex items-center gap-1"><i class="fa-solid fa-arrow-right text-[10px]"></i> <?php esc_html_e( 'كل الفتاوى', 'almukaddem' ); ?></a>
            </div>
        </div>

        <!-- Related Fatawa -->
        <?php
        if ( $cats && ! is_wp_error( $cats ) ) :
            $related = new WP_Query( array(
                'post_type'      => 'fatwa',
                'posts_per_page' => 4,
                'tax_query'      => array( array( 'taxonomy' => 'fatwa_category', 'field' => 'term_id', 'terms' => $cats[0]->term_id ) ),
                'post__not_in'   => array( get_the_ID() ),
            ) );
            if ( $related->have_posts() ) : ?>
                <div class="mt-8">
                    <h3 class="font-bold text-primary-900 text-lg mb-4 flex items-center gap-2"><i class="fa-solid fa-layer-group text-accent-500"></i> <?php esc_html_e( 'فتاوى ذات صلة', 'almukaddem' ); ?></h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php while ( $related->have_posts() ) : $related->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="bg-white rounded-2xl border border-slate-100 p-4 hover:border-primary-300 hover:shadow-sm transition-all group flex items-start gap-3">
                                <div class="w-9 h-9 flex-shrink-0 rounded-full bg-primary-50 text-primary-700 flex items-center justify-center border border-primary-100"><i class="fa-solid fa-question text-xs"></i></div>
                                <h4 class="font-semibold text-sm text-slate-700 group-hover:text-primary-700 transition-colors leading-snug pt-1"><?php the_title(); ?></h4>
                            </a>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php endif;
        endif;
        ?>

        <?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
    </main>

<?php
endwhile;
get_footer();
