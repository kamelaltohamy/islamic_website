<?php
/**
 * The generic taxonomy archive (handles audio_topic, video_category,
 * fatwa_category, book_category and other terms).
 *
 * @package almukaddem
 */

get_header();

$term    = get_queried_object();
$tax     = $term->taxonomy;
$post_type = '';
$icon    = 'fa-tags';
if ( 'audio_topic' === $tax )      { $post_type = 'audio'; $icon = 'fa-microphone-lines'; }
elseif ( 'video_category' === $tax ) { $post_type = 'video'; $icon = 'fa-video'; }
elseif ( 'fatwa_category' === $tax ) { $post_type = 'fatwa'; $icon = 'fa-scale-balanced'; }
elseif ( 'book_category' === $tax )  { $post_type = 'book'; $icon = 'fa-file-lines'; }
?>

    <main class="container mx-auto px-4 py-8 max-w-7xl">

        <!-- Breadcrumbs -->
        <div class="text-xs text-slate-400 font-medium mb-6 flex items-center gap-2">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary-700 transition-colors"><i class="fa-solid fa-home"></i> <?php esc_html_e( 'الرئيسية', 'almukaddem' ); ?></a>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <span class="text-primary-900 font-bold"><?php echo esc_html( single_term_title( '', false ) ); ?></span>
        </div>

        <!-- Hero -->
        <div class="bg-gradient-to-br from-primary-900 to-slate-900 rounded-3xl p-8 mb-8 relative overflow-hidden shadow-sm border-t-4 border-accent-600">
            <div class="absolute inset-0 opacity-10 bg-[url('<?php echo esc_attr( ALMUKADDEM_PATTERN ); ?>')]"></div>
            <div class="relative z-10 flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-accent-500 text-3xl shadow-inner">
                    <i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-2"><?php echo esc_html( single_term_title( '', false ) ); ?></h2>
                    <?php if ( term_description( $term ) ) : ?>
                        <p class="text-sm text-primary-200 font-serif leading-relaxed max-w-xl"><?php echo wp_kses_post( wp_strip_all_tags( term_description( $term ) ) ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <article <?php post_class( 'bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md hover:border-primary-300 transition-all group flex flex-col' ); ?>>
                        <a href="<?php the_permalink(); ?>" class="block">
                            <div class="relative h-40 bg-gradient-to-br from-primary-900 to-slate-900 flex items-center justify-center overflow-hidden">
                                <div class="absolute inset-0 opacity-5 bg-[url('<?php echo esc_attr( ALMUKADDEM_PATTERN ); ?>')]"></div>
                                <?php if ( has_post_thumbnail() ) the_post_thumbnail( 'almukaddem-card', array( 'class' => 'absolute inset-0 w-full h-full object-cover opacity-60' ) ); ?>
                                <div class="w-14 h-14 rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-sm flex items-center justify-center text-accent-200 z-10 group-hover:scale-105 transition-transform">
                                    <i class="fa-solid <?php echo esc_attr( $icon ); ?> text-xl"></i>
                                </div>
                            </div>
                        </a>
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="font-bold text-slate-800 text-sm leading-snug mb-3 group-hover:text-primary-700 transition">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="text-slate-600 text-xs font-serif line-clamp-2 flex-grow leading-relaxed"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></p>
                            <div class="mt-4 pt-4 border-t border-slate-50 flex justify-between items-center text-[10px] text-slate-400">
                                <span><i class="fa-regular fa-calendar ml-1 text-accent-700"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?></span>
                                <span><i class="fa-regular fa-eye ml-1 text-accent-700"></i> <?php echo esc_html( number_format_i18n( almukaddem_get_views() ) ); ?></span>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <p class="text-slate-500 col-span-full"><?php esc_html_e( 'لا يوجد محتوى في هذا التصنيف بعد.', 'almukaddem' ); ?></p>
            <?php endif; ?>
        </div>

        <?php almukaddem_pagination(); ?>
    </main>

<?php
get_footer();
