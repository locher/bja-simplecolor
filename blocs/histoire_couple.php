<?php

$args_histoire = array(
    'post_type'		=> 'histoire',
    'orderby' => 'menu_order',
    'order' => 'ASC'
); 

$query_histoire = new WP_Query( $args_histoire );

?>
<?php if( $query_histoire->have_posts() ): ?>  

<div class="timeline">
       
    <div class="wrapper-title">
        <h2><?php the_field('titre_de_la_section', 'option', false);?></h2>
        <p class="subtitle"><?php the_field('sous_titre_de_la_section', 'option', false);?></p>
        <svg viewBox="0 0 100 100" width="50" height="50">
          <use xlink:href="#icon-fleur"></use>
        </svg>
    </div>	

    <section>

        <ul>

            <span></span>

            <?php while( $query_histoire->have_posts() ) : $query_histoire->the_post(); ?>

            <li class="single_moment">
                <div class="col1">
                    <p class="meta_moment"><?php the_field('date_de_letape'); ?></p>
                </div>

                <div class="col2">

                  <div class="wrapper-col2">

                    <?php $image = get_field('photo_de_letape'); ?>

                    <a href="<?php echo $image['sizes']['sL1200']; ?>" class="<?php echo $classImage; ?> lightbox" title="<?php the_field('nom');?>">
                         <img src="<?php echo $image['sizes']['s300']; ?>" alt="<?php echo $image['alt']; ?>" class="<?php echo $classImage;?>" />
                    </a>

                    <div class="text-col2">
                        <h3><?php the_title();?></h3>
                        <?php the_field('texte_de_letape'); ?>
                    </div>

                  </div>

                </div>
                                <div class="milieu">
                    <svg viewBox="0 0 100 100" width="30" height="30" class="icon">
                      <use xlink:href="#icon-coeur"></use>
                    </svg>
                </div>
            </li>

            <?php endwhile; ?>

        </ul>

    </section>
    
</div>


<?php endif; ?>