<?php
/**
 * The template for displaying all single pages.
 *
 * @package almukaddem
 */

get_header();
?>

    <main class="container mx-auto px-4 py-8 max-w-4xl">
        <?php while ( have_posts() ) : the_post(); ?>

            <!-- Breadcrumbs -->
            <div class="text-xs text-slate-400 font-medium mb-6 flex items-center gap-2">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary-700 transition-colors"><i class="fa-solid fa-home"></i> <?php esc_html_e( 'الرئيسية', 'almukaddem' ); ?></a>
                <i class="fa-solid fa-chevron-left text-[10px]"></i>
                <span class="text-primary-900 font-bold"><?php the_title(); ?></span>
            </div>

            <article class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-12">
                <header class="mb-8 pb-6 border-b border-slate-100">
                    <h1 class="text-3xl md:text-4xl font-bold text-primary-900 leading-snug"><?php the_title(); ?></h1>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="rounded-2xl overflow-hidden mb-8">
                        <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto' ) ); ?>
                    </div>
                <?php endif; ?>

                <div class="article-content font-serif text-slate-700 leading-loose">
                    <?php
                    the_content();
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . esc_html__( 'الصفحات:', 'almukaddem' ),
                        'after'  => '</div>',
                    ) );
                    ?>
                </div>
            </article>

            <?php if ( comments_open() || get_comments_number() ) comments_template(); ?>

        <?php endwhile; ?>
    </main>

<?php
get_footer();
