<?php
/**
 * The template for displaying search forms.
 *
 * @package almukaddem
 */
?>
<form role="search" method="get" class="relative w-full" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="sr-only" for="s"><?php esc_html_e( 'ابحث في الموقع...', 'almukaddem' ); ?></label>
    <input type="text" id="s" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php esc_attr_e( 'ابحث في الموقع...', 'almukaddem' ); ?>" class="w-full bg-slate-50 text-sm rounded-xl py-2 px-4 pl-10 border border-slate-200 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all" />
    <button type="submit" class="absolute left-3 top-2.5 text-slate-400" aria-label="<?php esc_attr_e( 'بحث', 'almukaddem' ); ?>">
        <i class="fa-solid fa-search"></i>
    </button>
</form>
