<?php
/**
 * The template for displaying archive pages (articles / categories).
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
            <span class="text-primary-900 font-bold"><?php the_archive_title(); ?></span>
        </div>

        <!-- Page Hero -->
        <div class="bg-gradient-to-br from-primary-900 to-slate-900 rounded-3xl p-8 mb-8 relative overflow-hidden shadow-sm border-t-4 border-accent-600">
            <div class="absolute inset-0 opacity-10 bg-[url('<?php echo esc_attr( ALMUKADDEM_PATTERN ); ?>')]"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-accent-500 text-3xl shadow-inner">
                        <i class="fa-solid fa-feather-pointed"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-2"><?php the_archive_title(); ?></h2>
                        <?php $desc = get_the_archive_description(); ?>
                        <?php if ( $desc ) : ?><p class="text-sm text-primary-200 font-serif leading-relaxed max-w-xl"><?php echo wp_kses_post( wp_strip_all_tags( $desc ) ); ?></p><?php endif; ?>
                    </div>
                </div>
                <div class="w-full md:w-72">
                    <div class="relative w-full">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            <!-- MAIN CONTENT AREA -->
            <div class="w-full lg:w-3/4 flex flex-col gap-6 order-2 lg:order-1">

                <!-- Quick Filters (categories) -->
                <div class="flex items-center gap-2 overflow-x-auto pb-2 text-sm">
                    <?php
                    $current_cat = is_category() ? get_queried_object_id() : 0;
                    $all_class = ( 0 === $current_cat ) ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:border-primary-300 hover:text-primary-700';
                    echo '<a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '" class="px-5 py-2.5 rounded-xl font-bold border transition-all whitespace-nowrap ' . esc_attr( $all_class ) . '">' . esc_html__( 'الكل', 'almukaddem' ) . '</a>';
                    $cats = get_categories( array( 'hide_empty' => true, 'number' => 6 ) );
                    foreach ( $cats as $c ) {
                        $c_class = ( $current_cat === $c->term_id ) ? 'bg-primary-900 text-white shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:border-primary-300 hover:text-primary-700';
                        echo '<a href="' . esc_url( get_category_link( $c ) ) . '" class="px-5 py-2.5 rounded-xl font-bold border transition-all whitespace-nowrap ' . esc_attr( $c_class ) . '">' . esc_html( $c->name ) . '</a>';
                    }
                    ?>
                </div>

                <!-- Articles Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <article <?php post_class( 'bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden group article-card-hover flex flex-col' ); ?>>
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="h-32 bg-gradient-to-r from-slate-100 to-primary-50 relative overflow-hidden flex items-center justify-center border-b border-slate-100">
                                        <i class="fa-solid fa-mosque text-5xl text-primary-200/50 article-image transition-transform duration-500"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="p-6 flex flex-col flex-grow">
                                    <div class="mb-4 flex justify-between items-center">
                                        <?php
                                        $cats = get_the_category();
                                        if ( ! empty( $cats ) ) :
                                            echo '<span class="bg-primary-50 text-primary-700 text-[10px] font-bold px-3 py-1 rounded-full border border-primary-100">' . esc_html( $cats[0]->name ) . '</span>';
                                        endif;
                                        ?>
                                        <span class="text-[11px] text-slate-400 font-serif flex items-center gap-1"><i class="fa-regular fa-clock text-accent-500"></i> <?php echo esc_html( almukaddem_reading_time() ); ?></span>
                                    </div>
                                    <h3 class="font-bold text-lg text-primary-900 leading-snug mb-3 group-hover:text-accent-700 transition-colors">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <p class="text-slate-600 text-sm font-serif leading-loose line-clamp-3 mb-6 flex-grow"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 25 ) ); ?></p>
                                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                        <div class="flex items-center gap-2 text-[11px] text-slate-500">
                                            <i class="fa-regular fa-calendar text-primary-400"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?>
                                        </div>
                                        <a href="<?php the_permalink(); ?>" class="text-accent-700 hover:text-primary-800 text-xs font-bold transition-colors flex items-center gap-1"><?php esc_html_e( 'اقرأ المزيد', 'almukaddem' ); ?> <i class="fa-solid fa-arrow-left text-[10px]"></i></a>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p class="text-slate-500 col-span-full"><?php esc_html_e( 'لا توجد مقالات في هذا القسم.', 'almukaddem' ); ?></p>
                    <?php endif; ?>
                </div>

                <?php almukaddem_pagination(); ?>
            </div>

            <!-- SIDEBAR -->
            <aside class="w-full lg:w-1/4 flex flex-col gap-6 order-1 lg:order-2">
                <!-- Categories List -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="bg-primary-50 px-5 py-4 border-b border-primary-100">
                        <h3 class="font-bold text-primary-900 flex items-center gap-2 text-sm"><i class="fa-solid fa-folder-tree text-accent-600"></i> <?php esc_html_e( 'تصنيفات المقالات', 'almukaddem' ); ?></h3>
                    </div>
                    <ul class="p-2 space-y-1">
                        <?php
                        $cats = get_categories( array( 'hide_empty' => true ) );
                        foreach ( $cats as $c ) : ?>
                            <li>
                                <a href="<?php echo esc_url( get_category_link( $c ) ); ?>" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 text-slate-700 hover:text-primary-700 transition-colors text-sm font-bold">
                                    <span><?php echo esc_html( $c->name ); ?></span>
                                    <span class="bg-slate-100 text-slate-500 text-[10px] px-2 py-0.5 rounded-lg"><?php echo esc_html( $c->count ); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Most Read -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-fire text-red-500"></i>
                        <h3 class="font-bold text-slate-800 text-sm"><?php esc_html_e( 'الأكثر قراءة', 'almukaddem' ); ?></h3>
                    </div>
                    <div class="p-4 space-y-4">
                        <?php
                        $popular = new WP_Query( array(
                            'post_type'      => 'post',
                            'posts_per_page' => 3,
                            'meta_key'       => 'almukaddem_views',
                            'orderby'        => 'meta_value_num',
                            'order'          => 'DESC',
                        ) );
                        $i = 0;
                        while ( $popular->have_posts() ) : $popular->the_post(); $i++; ?>
                            <a href="<?php the_permalink(); ?>" class="flex gap-4 group">
                                <div class="text-3xl font-black text-slate-100 group-hover:text-accent-200 transition-colors italic leading-none"><?php echo esc_html( $i ); ?></div>
                                <div>
                                    <h4 class="font-bold text-sm text-slate-700 group-hover:text-primary-700 transition-colors leading-snug"><?php the_title(); ?></h4>
                                    <span class="text-[10px] text-slate-400 font-serif mt-1 block"><?php echo esc_html( number_format_i18n( almukaddem_get_views() ) ); ?> <?php esc_html_e( 'قراءة', 'almukaddem' ); ?></span>
                                </div>
                            </a>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                </div>

                <?php get_template_part( 'template-parts/newsletter' ); ?>
            </aside>
        </div>
    </main>

<?php
get_footer();
