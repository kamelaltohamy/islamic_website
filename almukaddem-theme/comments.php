<?php
/**
 * The comments template.
 *
 * @package almukaddem
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8 mt-6">

    <?php if ( have_comments() ) : ?>
        <h3 class="text-lg font-bold text-primary-900 mb-6 flex items-center gap-2 border-b border-slate-100 pb-4">
            <i class="fa-solid fa-comments text-accent-500"></i>
            <?php
            printf(
                esc_html( _n( 'تعليق واحد', '%s تعليق', get_comments_number(), 'almukaddem' ) ),
                number_format_i18n( get_comments_number() )
            );
            ?>
        </h3>

        <ol class="space-y-4 mb-8">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
            ) );
            ?>
        </ol>

        <?php the_comments_pagination( array(
            'prev_text' => '<i class="fa-solid fa-chevron-right text-xs"></i>',
            'next_text' => '<i class="fa-solid fa-chevron-left text-xs"></i>',
        ) ); ?>

    <?php endif; ?>

    <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="text-slate-400 text-sm font-serif"><?php esc_html_e( 'التعليقات مغلقة على هذا المحتوى.', 'almukaddem' ); ?></p>
    <?php endif; ?>

    <?php
    comment_form( array(
        'title_reply'        => '<span class="font-bold text-primary-900 text-lg flex items-center gap-2 mb-4"><i class="fa-solid fa-pen-to-square text-accent-500"></i> ' . __( 'أضف تعليقك', 'almukaddem' ) . '</span>',
        'title_reply_to'     => __( 'الرد على %s', 'almukaddem' ),
        'cancel_reply_link'  => __( 'إلغاء الرد', 'almukaddem' ),
        'label_submit'       => __( 'إرسال التعليق', 'almukaddem' ),
        'class_form'         => 'flex flex-col gap-4',
        'class_submit'       => 'bg-primary-900 hover:bg-primary-800 text-white font-bold px-6 py-3 rounded-xl transition-colors text-sm cursor-pointer',
        'submit_button'      => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
        'submit_field'       => '<div class="mt-2">%1$s %2$s</div>',
        'comment_field'      => '<label class="block"><span class="text-xs font-bold text-slate-500 mb-1 block">' . __( 'تعليقك', 'almukaddem' ) . '</span><textarea id="comment" name="comment" rows="4" class="w-full bg-slate-50 rounded-xl py-2.5 px-4 border border-slate-200 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all" required></textarea></label>',
        'fields'             => apply_filters( 'comment_form_default_fields', array(
            'author' => '<label class="block"><span class="text-xs font-bold text-slate-500 mb-1 block">' . __( 'الاسم', 'almukaddem' ) . '</span><input id="author" name="author" type="text" class="w-full bg-slate-50 rounded-xl py-2.5 px-4 border border-slate-200 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all" required /></label>',
            'email'  => '<label class="block"><span class="text-xs font-bold text-slate-500 mb-1 block">' . __( 'البريد الإلكتروني', 'almukaddem' ) . '</span><input id="email" name="email" type="email" class="w-full bg-slate-50 rounded-xl py-2.5 px-4 border border-slate-200 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all" required /></label>',
        ) ),
    ) );
    ?>
</div>
