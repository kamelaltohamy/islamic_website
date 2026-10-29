<?php
/**
 * Archive template for Books / Transcripts (التفريغات النصية).
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
            <span class="text-primary-900 font-bold"><?php esc_html_e( 'التفريغات النصية', 'almukaddem' ); ?></span>
        </div>

        <!-- Hero -->
        <div class="bg-gradient-to-br from-primary-900 to-primary-950 rounded-3xl p-8 mb-8 relative overflow-hidden shadow-sm border-t-4 border-accent-600">
            <div class="absolute inset-0 opacity-10 bg-[url('<?php echo esc_attr( ALMUKADDEM_PATTERN ); ?>')]"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-accent-500 text-3xl shadow-inner"><i class="fa-solid fa-file-signature"></i></div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-2"><?php esc_html_e( 'التفريغات النصية', 'almukaddem' ); ?></h2>
                        <p class="text-sm text-primary-200 font-serif leading-relaxed max-w-xl"><?php esc_html_e( 'نصوص المحاضرات والسلاسل العلمية مفرغة ومراجعة لتيسير القراءة والبحث والنسخ والاقتباس.', 'almukaddem' ); ?></p>
                    </div>
                </div>
                <div class="w-full md:w-72"><?php get_search_form(); ?></div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Main List -->
            <div class="w-full lg:w-3/4 flex flex-col gap-4 order-2 lg:order-1">

                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post();
                        $pdf   = almukaddem_get_field( 'transcript_pdf' );
                        $pdf_url = is_array( $pdf ) ? $pdf['url'] : $pdf;
                        $word  = almukaddem_get_field( 'transcript_doc' );
                        $word_url = is_array( $word ) ? $word['url'] : $word;
                        $pages = almukaddem_get_field( 'transcript_pages' );
                        $series = get_the_terms( get_the_ID(), 'book_category' );
                    ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:border-primary-300 hover:shadow-md transition-all group">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-primary-50 rounded-xl text-primary-700 flex items-center justify-center text-xl border border-primary-100 flex-shrink-0 group-hover:bg-primary-700 group-hover:text-white transition"><i class="fa-solid fa-file-lines"></i></div>
                                <div>
                                    <?php if ( $series && ! is_wp_error( $series ) ) : ?>
                                        <div class="text-[10px] text-slate-400 font-bold mb-1 flex items-center gap-1"><i class="fa-solid fa-folder-tree text-accent-600"></i> <?php echo esc_html( $series[0]->name ); ?></div>
                                    <?php endif; ?>
                                    <h3 class="font-bold text-slate-800 text-base group-hover:text-primary-700 transition leading-snug"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="flex items-center gap-4 mt-2 text-xs text-slate-500 font-serif">
                                        <?php if ( $pages ) : ?><span><i class="fa-solid fa-file-word text-blue-500 ml-1"></i> <?php echo esc_html( sprintf( __( '%s صفحة', 'almukaddem' ), $pages ) ); ?></span><?php endif; ?>
                                        <span><i class="fa-regular fa-calendar text-primary-400 ml-1"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 w-full sm:w-auto border-t sm:border-t-0 border-slate-100 pt-3 sm:pt-0 mt-2 sm:mt-0">
                                <?php if ( $pdf_url ) : ?>
                                    <a href="<?php echo esc_url( $pdf_url ); ?>" download class="flex-1 sm:flex-none text-slate-500 hover:text-red-500 bg-slate-50 hover:bg-red-50 w-10 h-10 rounded-lg flex items-center justify-center transition border border-slate-100" title="<?php esc_attr_e( 'تحميل PDF', 'almukaddem' ); ?>"><i class="fa-solid fa-file-pdf"></i></a>
                                <?php endif; ?>
                                <?php if ( $word_url ) : ?>
                                    <a href="<?php echo esc_url( $word_url ); ?>" download class="flex-1 sm:flex-none text-slate-500 hover:text-blue-600 bg-slate-50 hover:bg-blue-50 w-10 h-10 rounded-lg flex items-center justify-center transition border border-slate-100" title="<?php esc_attr_e( 'تحميل Word', 'almukaddem' ); ?>"><i class="fa-solid fa-file-word"></i></a>
                                <?php endif; ?>
                                <a href="<?php the_permalink(); ?>" class="flex-1 sm:flex-none bg-primary-50 text-primary-800 hover:bg-primary-800 hover:text-white border border-primary-200 font-bold px-5 py-2 rounded-lg transition text-sm text-center"><?php esc_html_e( 'قراءة التفريغ', 'almukaddem' ); ?></a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p class="text-slate-500"><?php esc_html_e( 'لا توجد تفريغات بعد.', 'almukaddem' ); ?></p>
                <?php endif; ?>

                <?php almukaddem_pagination(); ?>
            </div>

            <!-- Sidebar -->
            <aside class="w-full lg:w-1/4 flex flex-col gap-6 order-1 lg:order-2">

                <!-- Volunteer CTA -->
                <div class="bg-gradient-to-br from-accent-600 to-accent-700 rounded-2xl p-6 text-center text-white shadow-lg relative overflow-hidden border border-accent-500">
                    <div class="absolute -right-6 -top-6 w-20 h-20 bg-white/20 rounded-full blur-xl"></div>
                    <i class="fa-solid fa-pen-fancy text-4xl mb-3 text-white/90"></i>
                    <h3 class="font-bold text-lg mb-2"><?php esc_html_e( 'تطوع في التفريغ', 'almukaddem' ); ?></h3>
                    <p class="text-xs text-accent-100 font-serif mb-4 leading-relaxed"><?php esc_html_e( 'ساهم معنا في تفريغ المحاضرات ونشر العلم النافع، وكن شريكاً في الأجر.', 'almukaddem' ); ?></p>
                    <a href="<?php echo esc_url( home_url( '/volunteer' ) ); ?>" class="block w-full bg-white text-accent-700 hover:bg-primary-50 font-bold py-2.5 rounded-xl transition shadow-md text-sm"><?php esc_html_e( 'انضم لفريق التفريغ', 'almukaddem' ); ?></a>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="bg-primary-50 px-5 py-4 border-b border-primary-100">
                        <h3 class="font-bold text-primary-900 text-sm"><i class="fa-solid fa-folder-open text-accent-600 ml-2"></i> <?php esc_html_e( 'تصنيفات التفريغات', 'almukaddem' ); ?></h3>
                    </div>
                    <ul class="p-2 space-y-1">
                        <?php
                        $book_cats = get_terms( array( 'taxonomy' => 'book_category', 'hide_empty' => true ) );
                        foreach ( $book_cats as $bc ) : ?>
                            <li><a href="<?php echo esc_url( get_term_link( $bc ) ); ?>" class="flex justify-between items-center p-3 hover:bg-slate-50 rounded-xl text-sm font-bold text-slate-700 transition"><span><?php echo esc_html( $bc->name ); ?></span><span class="bg-slate-100 text-xs px-2 py-0.5 rounded text-slate-500"><?php echo esc_html( $bc->count ); ?></span></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>
        </div>
    </main>

<?php
get_footer();
