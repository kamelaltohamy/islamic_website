<?php
/**
 * Single Book / Transcript template.
 *
 * @package almukaddem
 */

get_header();

while ( have_posts() ) : the_post();
    $pdf   = almukaddem_get_field( 'transcript_pdf' );
    $pdf_url = is_array( $pdf ) ? $pdf['url'] : $pdf;
    $word  = almukaddem_get_field( 'transcript_doc' );
    $word_url = is_array( $word ) ? $word['url'] : $word;
    $cats  = get_the_terms( get_the_ID(), 'book_category' );
    $cat_name = ( $cats && ! is_wp_error( $cats ) ) ? $cats[0]->name : '';
?>

    <main class="container mx-auto px-4 py-8 max-w-5xl" x-data="{ fontSize: 20, increaseFont(){ if(this.fontSize<32) this.fontSize+=2 }, decreaseFont(){ if(this.fontSize>16) this.fontSize-=2 } }">

        <!-- Breadcrumbs -->
        <div class="text-xs text-slate-400 font-medium mb-6 flex items-center gap-2">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary-700 transition-colors"><i class="fa-solid fa-home"></i> <?php esc_html_e( 'الرئيسية', 'almukaddem' ); ?></a>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'book' ) ); ?>" class="hover:text-primary-700 transition-colors"><?php esc_html_e( 'التفريغات النصية', 'almukaddem' ); ?></a>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <span class="text-primary-900 font-bold"><?php the_title(); ?></span>
        </div>

        <!-- Header -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-10 mb-6">
            <?php if ( $cat_name ) : ?><span class="bg-primary-50 text-primary-700 text-xs font-bold px-4 py-1.5 rounded-full border border-primary-100 mb-4 inline-block"><?php echo esc_html( $cat_name ); ?></span><?php endif; ?>
            <h1 class="text-2xl md:text-4xl font-bold text-primary-900 leading-snug mb-4"><?php the_title(); ?></h1>
            <div class="flex flex-wrap items-center gap-6 text-sm text-slate-500 font-serif border-t border-slate-100 pt-4">
                <span><i class="fa-regular fa-calendar ml-1 text-primary-400"></i> <?php echo esc_html( almukaddem_arabic_date() ); ?></span>
                <span><i class="fa-regular fa-eye ml-1 text-primary-400"></i> <?php echo esc_html( number_format_i18n( almukaddem_get_views() ) ); ?></span>
            </div>
        </div>

        <!-- Reading tools -->
        <div class="bg-slate-50 rounded-2xl p-4 flex flex-wrap justify-between items-center gap-4 border border-slate-100 mb-6">
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-slate-500 ml-2"><?php esc_html_e( 'حجم الخط:', 'almukaddem' ); ?></span>
                <button @click="increaseFont()" class="w-10 h-10 rounded-xl bg-white text-slate-600 hover:bg-primary-50 hover:text-primary-700 border border-slate-200 transition-all shadow-sm"><i class="fa-solid fa-plus text-sm"></i></button>
                <button @click="decreaseFont()" class="w-10 h-10 rounded-xl bg-white text-slate-600 hover:bg-primary-50 hover:text-primary-700 border border-slate-200 transition-all shadow-sm"><i class="fa-solid fa-minus text-sm"></i></button>
                <button onclick="window.print()" class="w-10 h-10 rounded-xl bg-white text-slate-600 hover:bg-primary-50 hover:text-primary-700 border border-slate-200 transition-all shadow-sm mr-2"><i class="fa-solid fa-print"></i></button>
            </div>
            <div class="flex items-center gap-2">
                <?php if ( $pdf_url ) : ?>
                    <a href="<?php echo esc_url( $pdf_url ); ?>" download class="bg-red-50 text-red-600 hover:bg-red-500 hover:text-white px-4 py-2 rounded-xl font-bold text-xs transition flex items-center gap-2 border border-red-100"><i class="fa-solid fa-file-pdf"></i> PDF</a>
                <?php endif; ?>
                <?php if ( $word_url ) : ?>
                    <a href="<?php echo esc_url( $word_url ); ?>" download class="bg-blue-50 text-blue-600 hover:bg-blue-500 hover:text-white px-4 py-2 rounded-xl font-bold text-xs transition flex items-center gap-2 border border-blue-100"><i class="fa-solid fa-file-word"></i> Word</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Content -->
        <article class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-12">
            <div class="article-content font-serif text-slate-700 leading-loose transition-all duration-300" :style="'font-size: ' + fontSize + 'px'">
                <?php the_content(); ?>
            </div>
        </article>

        <?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
    </main>

<?php
endwhile;
get_footer();
