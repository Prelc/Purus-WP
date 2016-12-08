<?php if ( 'hide' !== get_theme_mod( 'meta_author_avatar', 'show' ) ) : ?>
  <div class="meta__author-avatar">
    <?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
  </div>
<?php endif; ?>
<div class="meta">
  <?php if ( 'hide' !== get_theme_mod( 'meta_author', 'show' ) ) : ?>
    <span class="meta__item  meta__item--author"><?php esc_html_e( 'by ' , 'purus' ); ?><?php the_author_posts_link(); ?></span>
  <?php endif; ?>
  <?php if ( 'hide' !== get_theme_mod( 'meta_date', 'show' ) ) : ?>
  <a class="meta__item  meta__item--date" href="<?php the_permalink(); ?>">
    <time datetime="<?php the_time( 'c' ); ?>"><?php echo get_the_date(); ?></time>
  </a>
  <?php endif; ?>
  <?php if ( 'hide' !== get_theme_mod( 'meta_comment_number', 'show' ) ) : ?>
    <?php if ( comments_open() ) { ?>
      <a class="meta__item  meta__item--comments" href="<?php comments_link(); ?>">
        <?php
          printf( // WPCS: XSS OK.
            esc_html( _nx( '1 comment', '%1$s comments', get_comments_number(), 'comments title', 'purus' ) ),
            number_format_i18n( get_comments_number() ),
            '<span>' . get_the_title() . '</span>'
          );
        ?>
      </a>
    <?php } ?>
  <?php endif; ?>
  <?php if ( 'hide' !== get_theme_mod( 'meta_categories', 'show' ) ) : ?>
    <?php if ( has_category() ) { ?>
      <span class="meta__item  meta__item--categories"><?php the_category( ', ' ); ?></span>
    <?php } ?>
  <?php endif; ?>
</div>
