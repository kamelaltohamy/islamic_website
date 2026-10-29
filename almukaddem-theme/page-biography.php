<?php
/**
 * Template Name: السيرة الذاتية (Biography)
 * Template Post Type: page
 *
 * @package almukaddem
 */

get_header();
?>

    <!-- Breadcrumbs -->
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="text-xs text-slate-400 font-medium mb-4 flex items-center gap-2">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary-700 transition-colors"><i class="fa-solid fa-home"></i> <?php esc_html_e( 'الرئيسية', 'almukaddem' ); ?></a>
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <span class="text-primary-900 font-bold"><?php the_title(); ?></span>
        </div>
    </div>

    <?php while ( have_posts() ) : the_post(); ?>

    <main class="container mx-auto px-4 py-12 max-w-4xl">

        <!-- Bio Hero -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-12 mb-10 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-br from-primary-900 to-primary-800"></div>
            <div class="absolute top-0 left-0 w-full h-32 opacity-10 bg-[url('<?php echo esc_attr( ALMUKADDEM_PATTERN ); ?>')]"></div>

            <div class="relative z-10">
                <div class="w-32 h-32 mx-auto rounded-full bg-white p-2 shadow-lg mb-6 mt-4">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'almukaddem-thumb', array( 'class' => 'w-full h-full rounded-full object-cover' ) ); ?>
                    <?php else : ?>
                        <div class="w-full h-full rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-primary-200 text-5xl"><i class="fa-solid fa-user-tie"></i></div>
                    <?php endif; ?>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-primary-900 mb-2"><?php echo esc_html( almukaddem_get_field( 'sheikh_name' ) ? almukaddem_get_field( 'sheikh_name' ) : get_bloginfo( 'name' ) ); ?></h1>
                <?php $subtitle = almukaddem_get_field( 'sheikh_title' ); ?>
                <?php if ( $subtitle ) : ?><p class="text-accent-700 font-bold text-sm mb-6"><?php echo esc_html( $subtitle ); ?></p><?php endif; ?>
                <div class="flex justify-center gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-50 text-slate-500 hover:bg-primary-50 hover:text-primary-700 flex items-center justify-center transition border border-slate-200"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-50 text-slate-500 hover:bg-primary-50 hover:text-primary-700 flex items-center justify-center transition border border-slate-200"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
        </div>

        <!-- Page content (timeline editable via the editor) -->
        <?php if ( get_the_content() ) : ?>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-10 article-content">
            <div class="font-serif text-slate-700 leading-loose">
                <?php the_content(); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Timeline sections (ACF repeater "bio_sections" or fallback) -->
        <div class="relative timeline-line mt-10">
            <?php
            $sections = almukaddem_get_field( 'bio_sections' );
            $default_sections = array(
                array( 'icon' => 'fa-baby',           'title' => __( 'المولد والنشأة', 'almukaddem' ),          'text' => __( 'نبذة عن مولد الشيخ ونشأته وحبه للعلم منذ الصغر.', 'almukaddem' ) ),
                array( 'icon' => 'fa-graduation-cap', 'title' => __( 'الدراسة الأكاديمية', 'almukaddem' ),       'text' => __( 'تفاصيل الدراسة الأكاديمية والتخصص العلمي.', 'almukaddem' ) ),
                array( 'icon' => 'fa-book-open-reader','title' => __( 'طلب العلم والمشايخ', 'almukaddem' ),      'text' => __( 'مشايخ الشيخ وأبرز من تلقى عنهم العلم.', 'almukaddem' ) ),
                array( 'icon' => 'fa-pen-nib',        'title' => __( 'المؤلفات والإنتاج العلمي', 'almukaddem' ), 'text' => __( 'أبرز مؤلفات الشيخ وإنتاجه العلمي.', 'almukaddem' ) ),
            );

            $rows = $sections ? $sections : $default_sections;

            foreach ( $rows as $section ) :
                $icon  = isset( $section['icon'] ) ? $section['icon'] : 'fa-circle-info';
                $title = isset( $section['title'] ) ? $section['title'] : '';
                $text  = isset( $section['text'] ) ? $section['text'] : '';
            ?>
                <div class="relative z-10 pl-4 pr-16 mb-12 last:mb-0">
                    <div class="absolute right-2 top-0 w-12 h-12 bg-white rounded-full border-4 border-primary-100 flex items-center justify-center text-accent-600 text-xl shadow-sm">
                        <i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="text-xl font-bold text-primary-900 mb-3"><?php echo esc_html( $title ); ?></h3>
                        <div class="font-serif text-slate-700 leading-loose"><?php echo wp_kses_post( wpautop( $text ) ); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </main>

    <?php endwhile; ?>

<?php
get_footer();
