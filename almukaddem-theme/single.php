<?php
/**
 * The template for displaying all single posts (articles).
 *
 * @package almukaddem
 */

get_header();
?>

    <main class="container mx-auto px-4 py-8 max-w-7xl" x-data="{ scrollProgress: 0, fontSize: 20, increaseFont(){ if(this.fontSize<32) this.fontSize+=2 }, decreaseFont(){ if(this.fontSize>16) this.fontSize-=2 }, updateScroll(){ let h=document.documentElement.scrollHeight-document.documentElement.clientHeight; this.scrollProgress=( (document.body.scrollTop||document.documentElement.scrollTop)/h )*100 } }" @scroll.window="updateScroll()">

        <!-- Reading Progress Bar -->
        <div class="fixed top-0 left-0 h-1 bg-accent-600 z-[60] reading-progress transition-all duration-150 ease-out no-print" :style="'width: ' + scrollProgress + '%'"></div>

        <!-- Breadcrumbs -->
        <div class="text-xs text-slate-400 font-medium mb-8 flex items-center gap-2 no-print">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary-700 transition-colors"><i class="fa-solid fa-home"></i> <?php esc_html_e( 'الرئيسية', 'almukaddem' ); ?></a>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="hover:text-primary-700 transition-colors"><?php esc_html_e( 'المقالات والبحوث', 'almukaddem' ); ?></a>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <span class="text-primary-900 font-bold"><?php the_title(); ?></span>
        </div>

        <div class="flex flex-col lg:flex-row gap-10">

            <!-- MAIN ARTICLE AREA -->
            <?php while ( have_posts() ) : the_post(); ?>
            <article class="w-full lg:w-3/4 flex flex-col gap-6 bg-white rounded-3xl p-6 md:p-12 shadow-sm border border-slate-100">

                <!-- Article Header -->
                <header class="border-b border-slate-100 pb-8 mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <?php
                        $cats = get_the_category();
                        if ( ! empty( $cats ) ) :
                            echo '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '" class="bg-primary-50 text-primary-700 text-xs font-bold px-4 py-1.5 rounded-full border border-primary-100">' . esc_html( $cats[0]->name ) . '</a>';
                        endif;
                        ?>
                        <span class="text-xs text-slate-400 font-serif flex items-center gap-1"><i class="fa-regular fa-clock text-accent-600"></i> <?php echo esc_html( almukaddem_reading_time() ); ?></span>
                    </div>

                    <h1 class="text-3xl md:text-5xl font-bold text-primary-900 leading-snug mb-6"><?php the_title(); ?></h1>

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-primary-700 text-xl">
                                <i class="fa-solid fa-pen-nib"></i>
                            </div>
                            <div>
                                <span class="text-[11px] text-slate-400 font-bold block mb-0.5"><?php esc_html_e( 'بقلم', 'almukaddem' ); ?></span>
                                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="font-bold text-slate-800 text-sm hover:text-primary-700 transition-colors"><?php the_author(); ?></a>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 text-sm text-slate-500 font-serif">
                            <span><i class="fa-regular fa-calendar ml-1 text-primary-400"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?></span>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span><i class="fa-regular fa-eye ml-1 text-primary-400"></i> <?php echo esc_html( number_format_i18n( almukaddem_get_views() ) ); ?> <?php esc_html_e( 'قراءة', 'almukaddem' ); ?></span>
                        </div>
                    </div>
                </header>

                <!-- Featured image -->
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="rounded-2xl overflow-hidden mb-2">
                        <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto' ) ); ?>
                    </div>
                <?php endif; ?>

                <!-- Reading Tools -->
                <div class="bg-slate-50 rounded-2xl p-4 flex flex-wrap justify-between items-center gap-4 border border-slate-100 no-print">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-slate-500 ml-2"><?php esc_html_e( 'حجم الخط:', 'almukaddem' ); ?></span>
                        <button @click="increaseFont()" class="w-10 h-10 rounded-xl bg-white text-slate-600 hover:bg-primary-50 hover:text-primary-700 hover:border-primary-200 flex items-center justify-center border border-slate-200 transition-all shadow-sm" title="<?php esc_attr_e( 'تكبير الخط', 'almukaddem' ); ?>"><i class="fa-solid fa-plus text-sm"></i></button>
                        <button @click="decreaseFont()" class="w-10 h-10 rounded-xl bg-white text-slate-600 hover:bg-primary-50 hover:text-primary-700 hover:border-primary-200 flex items-center justify-center border border-slate-200 transition-all shadow-sm" title="<?php esc_attr_e( 'تصغير الخط', 'almukaddem' ); ?>"><i class="fa-solid fa-minus text-sm"></i></button>
                        <button onclick="window.print()" class="w-10 h-10 rounded-xl bg-white text-slate-600 hover:bg-primary-50 hover:text-primary-700 hover:border-primary-200 flex items-center justify-center border border-slate-200 transition-all shadow-sm mr-2" title="<?php esc_attr_e( 'طباعة', 'almukaddem' ); ?>"><i class="fa-solid fa-print"></i></button>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-500 ml-2"><?php esc_html_e( 'مشاركة:', 'almukaddem' ); ?></span>
                        <a href="https://api.whatsapp.com/send?text=<?php echo rawurlencode( get_the_title() . ' ' . get_the_permalink() ); ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white text-[#25D366] hover:bg-[#25D366] hover:text-white flex items-center justify-center border border-slate-200 transition-all shadow-sm"><i class="fa-brands fa-whatsapp text-lg"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( get_the_permalink() ); ?>&text=<?php echo rawurlencode( get_the_title() ); ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white text-[#1DA1F2] hover:bg-[#1DA1F2] hover:text-white flex items-center justify-center border border-slate-200 transition-all shadow-sm"><i class="fa-brands fa-twitter text-lg"></i></a>
                        <a href="https://t.me/share/url?url=<?php echo rawurlencode( get_the_permalink() ); ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white text-[#0088cc] hover:bg-[#0088cc] hover:text-white flex items-center justify-center border border-slate-200 transition-all shadow-sm"><i class="fa-brands fa-telegram text-lg"></i></a>
                    </div>
                </div>

                <!-- Article Content -->
                <div class="article-content font-serif text-slate-700 leading-loose transition-all duration-300" :style="'font-size: ' + fontSize + 'px'">
                    <?php
                    the_content();
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . esc_html__( 'الصفحات:', 'almukaddem' ),
                        'after'  => '</div>',
                    ) );
                    ?>
                </div>

                <!-- Tags -->
                <div class="mt-8 pt-8 border-t border-slate-100 no-print flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-bold text-slate-500 ml-2"><i class="fa-solid fa-tags"></i> <?php esc_html_e( 'الكلمات الدلالية:', 'almukaddem' ); ?></span>
                        <?php
                        $tags = get_the_tags();
                        if ( $tags ) :
                            foreach ( $tags as $tag ) :
                                echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="bg-slate-50 hover:bg-primary-50 hover:text-primary-700 text-slate-600 border border-slate-100 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors">' . esc_html( $tag->name ) . '</a>';
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>

                <?php
                if ( comments_open() || get_comments_number() ) {
                    comments_template();
                }
                ?>
            </article>
            <?php endwhile; ?>

            <!-- SIDEBAR -->
            <aside class="w-full lg:w-1/4 flex flex-col gap-8 no-print">

                <!-- Related Articles -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden sticky top-24">
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                        <i class="fa-solid fa-layer-group text-accent-500 text-lg"></i>
                        <h3 class="font-bold text-primary-900"><?php esc_html_e( 'مقالات ذات صلة', 'almukaddem' ); ?></h3>
                    </div>
                    <div class="flex flex-col">
                        <?php
                        $related = new WP_Query( array(
                            'category__in'   => wp_get_post_categories( get_the_ID(), array( 'fields' => 'ids' ) ),
                            'posts_per_page' => 4,
                            'post__not_in'   => array( get_the_ID() ),
                        ) );
                        if ( $related->have_posts() ) :
                            while ( $related->have_posts() ) : $related->the_post(); ?>
                                <a href="<?php the_permalink(); ?>" class="p-5 border-b border-slate-50 hover:bg-slate-50 transition-colors group">
                                    <h4 class="font-bold text-sm text-slate-800 leading-snug group-hover:text-primary-700 transition-colors mb-2"><?php the_title(); ?></h4>
                                    <span class="text-[11px] text-slate-400 font-serif flex items-center gap-1"><i class="fa-regular fa-calendar text-accent-500"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?></span>
                                </a>
                            <?php endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p class="p-5 text-sm text-slate-400">' . esc_html__( 'لا توجد مقالات ذات صلة.', 'almukaddem' ) . '</p>';
                        endif;
                        ?>
                    </div>
                </div>

                <?php get_template_part( 'template-parts/newsletter' ); ?>

            </aside>
        </div>
    </main>

<?php
get_footer();
