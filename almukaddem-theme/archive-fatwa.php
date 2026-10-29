<?php
/**
 * Archive template for Fatwas (الفتاوى الشرعية).
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
            <span class="text-primary-900 font-bold"><?php esc_html_e( 'الفتاوى الشرعية', 'almukaddem' ); ?></span>
        </div>

        <!-- Hero & Search -->
        <div class="bg-gradient-to-br from-primary-900 to-slate-900 rounded-3xl p-8 md:p-12 mb-8 relative overflow-hidden shadow-sm border-t-4 border-accent-600 text-center">
            <div class="absolute inset-0 opacity-10 bg-[url('<?php echo esc_attr( ALMUKADDEM_PATTERN ); ?>')]"></div>
            <div class="relative z-10 max-w-3xl mx-auto">
                <div class="w-20 h-20 mx-auto rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-accent-500 text-4xl shadow-inner mb-6">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4"><?php esc_html_e( 'قسم الفتاوى الشرعية', 'almukaddem' ); ?></h2>
                <p class="text-primary-200 font-serif leading-relaxed mb-8"><?php esc_html_e( 'مكتبة تضم الفتاوى الشرعية والأجوبة العلمية المؤصلة على أسئلة المستفتين في مختلف أبواب الفقه والعقيدة.', 'almukaddem' ); ?></p>
                <div class="relative w-full max-w-2xl mx-auto group">
                    <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="relative w-full">
                        <input type="text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'اكتب سؤالك أو كلمة مفتاحية للبحث في الفتاوى...', 'almukaddem' ); ?>" class="w-full bg-white/10 text-white placeholder-white/60 text-base md:text-lg rounded-2xl py-4 px-6 pr-14 border border-white/30 focus:outline-none focus:border-accent-500 focus:bg-white/20 transition-all backdrop-blur-md shadow-[0_0_20px_rgba(0,0,0,0.2)]" />
                        <input type="hidden" name="post_type" value="fatwa" />
                        <button type="submit" class="absolute right-4 top-4 text-accent-400 group-focus-within:text-accent-500 transition-colors"><i class="fa-solid fa-search text-xl"></i></button>
                    </form>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Fatawa List -->
            <div class="w-full lg:w-3/4 flex flex-col gap-6 order-2 lg:order-1">

                <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                    <h3 class="text-xl font-bold text-primary-900 flex items-center gap-2"><i class="fa-solid fa-list-check text-accent-600"></i> <?php esc_html_e( 'أحدث الفتاوى', 'almukaddem' ); ?></h3>
                </div>

                <!-- Accordion list -->
                <div class="space-y-4" x-data="{ activeFatwa: null }">
                    <?php if ( have_posts() ) : $idx = 0; ?>
                        <?php while ( have_posts() ) : the_post(); $idx++;
                            $cats     = get_the_terms( get_the_ID(), 'fatwa_category' );
                            $cat_name = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : '';
                            $fatwa_no = almukaddem_get_field( 'fatwa_number' );
                            $answer   = almukaddem_get_field( 'fatwa_answer' );
                        ?>
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden transition-all duration-300" :class="activeFatwa === <?php echo esc_attr( $idx ); ?> ? 'ring-2 ring-primary-500/20 shadow-md' : 'hover:border-primary-300'">
                            <button @click="activeFatwa = activeFatwa === <?php echo esc_attr( $idx ); ?> ? null : <?php echo esc_attr( $idx ); ?>" class="w-full flex items-start sm:items-center justify-between p-5 md:p-6 text-right focus:outline-none">
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 flex-shrink-0 rounded-full bg-primary-50 text-primary-700 flex items-center justify-center font-bold text-lg border border-primary-100"><i class="fa-solid fa-question text-sm"></i></div>
                                    <div class="mt-1 sm:mt-0">
                                        <h4 class="font-bold text-primary-900 text-sm md:text-base leading-snug pr-2" :class="activeFatwa === <?php echo esc_attr( $idx ); ?> ? 'text-accent-700' : ''"><?php the_title(); ?></h4>
                                        <div class="flex items-center gap-3 mt-2 text-[11px] text-slate-400 font-serif pr-2">
                                            <?php if ( $cat_name ) : ?><span class="bg-slate-100 px-2 py-0.5 rounded font-sans font-bold text-slate-500"><?php echo esc_html( $cat_name ); ?></span><?php endif; ?>
                                            <?php if ( $fatwa_no ) : ?><span><?php echo esc_html( sprintf( __( 'رقم الفتوى: %s', 'almukaddem' ), $fatwa_no ) ); ?></span><?php endif; ?>
                                            <span><i class="fa-regular fa-calendar ml-1 text-primary-400"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300 mt-2 sm:mt-0" :class="activeFatwa === <?php echo esc_attr( $idx ); ?> ? 'rotate-180 text-accent-600' : ''"></i>
                            </button>
                            <div x-show="activeFatwa === <?php echo esc_attr( $idx ); ?>" x-collapse class="border-t border-slate-100 bg-slate-50">
                                <div class="p-6 md:p-8 fatwa-content font-serif text-slate-700 leading-loose text-sm md:text-base">
                                    <p class="font-bold text-primary-800 mb-4 font-sans text-sm"><i class="fa-solid fa-check-circle text-accent-600 ml-1"></i> <?php esc_html_e( 'الإجابة:', 'almukaddem' ); ?></p>
                                    <?php if ( $answer ) : echo wp_kses_post( wpautop( $answer ) ); else : the_content(); endif; ?>
                                    <div class="mt-6 pt-4 border-t border-slate-200 flex items-center justify-between">
                                        <a href="<?php the_permalink(); ?>" class="bg-white border border-slate-200 hover:bg-primary-50 text-primary-700 text-xs font-bold px-4 py-2 rounded-lg transition-colors"><?php esc_html_e( 'قراءة الفتوى كاملة', 'almukaddem' ); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p class="text-slate-500"><?php esc_html_e( 'لا توجد فتاوى حالياً.', 'almukaddem' ); ?></p>
                    <?php endif; ?>
                </div>

                <?php almukaddem_pagination(); ?>
            </div>

            <!-- Sidebar -->
            <aside class="w-full lg:w-1/4 flex flex-col gap-6 order-1 lg:order-2">

                <!-- CTA Ask -->
                <div class="bg-gradient-to-b from-accent-600 to-accent-700 rounded-3xl p-6 text-center shadow-lg border-2 border-accent-500 relative overflow-hidden text-white">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-accent-600 shadow-inner border-4 border-accent-400/50"><i class="fa-solid fa-comment-dots text-3xl"></i></div>
                        <h3 class="font-bold text-lg mb-2"><?php esc_html_e( 'هل لديك سؤال شرعي؟', 'almukaddem' ); ?></h3>
                        <p class="text-xs text-accent-100 font-serif mb-6 leading-relaxed"><?php esc_html_e( 'أرسل سؤالك عبر النموذج المخصص وسيتم الإجابة عليه بإذن الله.', 'almukaddem' ); ?></p>
                        <a href="<?php echo esc_url( home_url( '/ask' ) ); ?>" class="block w-full bg-white text-accent-700 hover:bg-primary-50 hover:text-primary-800 font-bold py-3 rounded-xl transition-colors text-sm shadow-md"><?php esc_html_e( 'طرح سؤال جديد', 'almukaddem' ); ?></a>
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mt-2">
                    <div class="bg-primary-50 px-5 py-4 border-b border-primary-100">
                        <h3 class="font-bold text-primary-900 flex items-center gap-2 text-sm"><i class="fa-solid fa-folder-tree text-accent-600"></i> <?php esc_html_e( 'أبواب الفتاوى', 'almukaddem' ); ?></h3>
                    </div>
                    <ul class="p-2 space-y-1">
                        <?php
                        $fatawa_cats = get_terms( array( 'taxonomy' => 'fatwa_category', 'hide_empty' => true ) );
                        foreach ( $fatawa_cats as $fc ) : ?>
                            <li>
                                <a href="<?php echo esc_url( get_term_link( $fc ) ); ?>" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 text-slate-700 hover:text-primary-700 transition-colors text-sm font-bold group">
                                    <span class="flex items-center gap-2"><i class="fa-solid fa-angle-left text-[10px] text-slate-300 group-hover:text-accent-500 transition-colors"></i> <?php echo esc_html( $fc->name ); ?></span>
                                    <span class="bg-primary-50 text-primary-600 border border-primary-100 text-[10px] px-2 py-0.5 rounded-lg"><?php echo esc_html( $fc->count ); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Info box -->
                <div class="bg-slate-50 rounded-2xl shadow-sm border border-slate-200 p-5 text-center">
                    <i class="fa-solid fa-circle-info text-2xl text-slate-400 mb-2"></i>
                    <h4 class="font-bold text-slate-700 text-sm mb-2"><?php esc_html_e( 'تنبيه هام', 'almukaddem' ); ?></h4>
                    <p class="text-xs text-slate-500 font-serif leading-relaxed"><?php esc_html_e( 'جميع الفتاوى المنشورة هي من تفريغ دروس ولقاءات الشيخ. ولا تُغني عن سؤال أهل العلم المباشر في النوازل.', 'almukaddem' ); ?></p>
                </div>
            </aside>
        </div>
    </main>

<?php
get_footer();
