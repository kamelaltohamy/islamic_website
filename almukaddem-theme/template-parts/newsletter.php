<?php
/**
 * Newsletter subscribe block.
 *
 * @package almukaddem
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="bg-gradient-to-br from-primary-900 to-slate-950 rounded-2xl shadow-md p-6 text-white text-center border-t-2 border-accent-700 relative overflow-hidden">
    <div class="absolute -right-10 -bottom-10 w-24 h-24 bg-accent-700/10 rounded-full blur-xl"></div>
    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center mx-auto mb-3 backdrop-blur-sm border border-white/10 text-accent-200">
        <i class="fa-regular fa-envelope text-xl"></i>
    </div>
    <h3 class="font-bold text-sm mb-1.5"><?php esc_html_e( 'القائمة البريدية', 'almukaddem' ); ?></h3>
    <p class="text-xs text-slate-400 mb-4 font-serif"><?php esc_html_e( 'اشترك لجديد المحاضرات والمقالات', 'almukaddem' ); ?></p>
    <form class="flex bg-white/5 p-1 rounded-xl border border-white/10" onsubmit="return false;">
        <input type="email" placeholder="<?php esc_attr_e( 'بريدك الإلكتروني', 'almukaddem' ); ?>" class="w-full bg-transparent px-3 py-1.5 text-white placeholder-slate-500 text-xs focus:outline-none" />
        <button class="bg-accent-700 hover:bg-accent-600 text-white px-4 py-1.5 rounded-lg transition font-medium text-xs whitespace-nowrap"><?php esc_html_e( 'اشترك', 'almukaddem' ); ?></button>
    </form>
</div>
