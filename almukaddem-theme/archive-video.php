<?php
/**
 * Archive template for the Video library (المكتبة المرئية).
 *
 * @package almukaddem
 */

get_header();
?>

    <main class="container mx-auto px-4 py-8 max-w-7xl">

        <!-- Breadcrumbs -->
        <div class="text-xs text-slate-400 font-medium mb-6 flex items-center gap-2">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary-700 transition-colors"><i class="fa-solid fa-home"></i> <?php esc_html_e( 'الرئيسية', 'almukaddem' ); ?></a>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <span class="text-primary-900 font-bold"><?php esc_html_e( 'المكتبة المرئية', 'almukaddem' ); ?></span>
        </div>

        <!-- Page Hero -->
        <div class="bg-gradient-to-br from-slate-900 to-primary-950 rounded-3xl p-8 mb-8 relative overflow-hidden shadow-sm border-t-4 border-accent-600">
            <div class="absolute inset-0 opacity-20 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+CjxjaXJjbGUgY3g9IjIiIGN5PSIyIiByPSIyIiBmaWxsPSIjZWFiMzA4Ii8+Cjwvc3ZnPg==')]"></div>
            <div class="relative z-10 flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-accent-500 text-3xl shadow-inner">
                    <i class="fa-solid fa-play ml-1"></i>
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-2"><?php esc_html_e( 'المكتبة المرئية', 'almukaddem' ); ?></h2>
                    <p class="text-sm text-primary-200 font-serif leading-relaxed max-w-xl"><?php esc_html_e( 'شاهد أحدث السلاسل المرئية، الخطب، واللقاءات التلفزيونية بجودة عالية ومصنفة لتسهيل الوصول.', 'almukaddem' ); ?></p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 mb-8 overflow-x-auto">
            <div class="flex items-center gap-3 min-w-max">
                <span class="text-xs text-slate-400 font-bold ml-2"><i class="fa-solid fa-filter"></i> <?php esc_html_e( 'تصفح المرئيات:', 'almukaddem' ); ?></span>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'video' ) ); ?>" class="bg-primary-900 text-white px-5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 shadow-md"><i class="fa-solid fa-border-all"></i> <?php esc_html_e( 'الكل', 'almukaddem' ); ?></a>
                <?php
                $cats = get_terms( array( 'taxonomy' => 'video_category', 'hide_empty' => true ) );
                foreach ( $cats as $c ) :
                    echo '<a href="' . esc_url( get_term_link( $c ) ) . '" class="bg-slate-50 text-slate-600 border border-slate-200 hover:border-primary-300 hover:text-primary-700 px-5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2"><i class="fa-solid fa-tag text-accent-500"></i> ' . esc_html( $c->name ) . '</a>';
                endforeach;
                ?>
            </div>
        </div>

        <!-- Videos Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post();
                    $duration  = almukaddem_get_field( 'video_duration' );
                    $cats      = get_the_terms( get_the_ID(), 'video_category' );
                    $badge     = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : __( 'مرئي', 'almukaddem' );
                ?>
                <article <?php post_class( 'bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg hover:border-primary-300 transition-all duration-300 group flex flex-col' ); ?>>
                    <a href="<?php the_permalink(); ?>" class="relative w-full pt-[56.25%] bg-slate-900 overflow-hidden block">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'almukaddem-card', array( 'class' => 'absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700' ) ); ?>
                        <?php else : ?>
                            <div class="absolute inset-0 bg-gradient-to-tr from-primary-950 to-primary-800 flex items-center justify-center group-hover:scale-105 transition-transform duration-700">
                                <i class="fa-solid fa-video text-7xl text-white/10"></i>
                            </div>
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-300"></div>
                        <div class="absolute inset-0 flex items-center justify-center opacity-80 group-hover:opacity-100 transition-opacity">
                            <div class="w-14 h-14 bg-accent-600/90 text-white rounded-full flex items-center justify-center backdrop-blur-sm border-2 border-white/20 shadow-[0_0_15px_rgba(234,179,8,0.5)] group-hover:scale-110 transition-transform duration-300">
                                <i class="fa-solid fa-play ml-1 text-xl"></i>
                            </div>
                        </div>
                        <?php if ( $duration ) : ?>
                            <span class="absolute bottom-3 left-3 bg-black/70 text-white text-[10px] font-bold px-2 py-1 rounded backdrop-blur-sm"><?php echo esc_html( $duration ); ?></span>
                        <?php endif; ?>
                        <span class="absolute top-3 right-3 bg-primary-600/90 text-white text-[10px] font-bold px-2.5 py-1 rounded shadow-sm backdrop-blur-sm"><?php echo esc_html( $badge ); ?></span>
                    </a>
                    <div class="p-4 flex flex-col flex-grow">
                        <?php
                        $series = get_the_terms( get_the_ID(), 'video_series' );
                        if ( $series && ! is_wp_error( $series ) ) :
                            echo '<a href="' . esc_url( get_term_link( $series[0] ) ) . '" class="text-[10px] text-slate-500 mb-1.5 hover:text-accent-600 transition-colors font-bold flex items-center gap-1"><i class="fa-solid fa-layer-group text-accent-500"></i> ' . esc_html( $series[0]->name ) . '</a>';
                        endif;
                        ?>
                        <h3 class="font-bold text-slate-800 text-sm leading-snug mb-3 group-hover:text-primary-700 transition-colors">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="mt-auto pt-4 border-t border-slate-50 flex justify-between items-center text-[11px] text-slate-400 font-serif">
                            <span><i class="fa-regular fa-calendar ml-1 text-primary-400"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?></span>
                            <span><i class="fa-solid fa-eye ml-1 text-primary-400"></i> <?php echo esc_html( number_format_i18n( almukaddem_get_views() ) ); ?></span>
                        </div>
                    </div>
                </article>
                <?php endwhile; ?>
            <?php else : ?>
                <p class="text-slate-500 col-span-full"><?php esc_html_e( 'لا توجد مقاطع مرئية بعد.', 'almukaddem' ); ?></p>
            <?php endif; ?>
        </div>

        <?php almukaddem_pagination(); ?>
    </main>

<?php
get_footer();
