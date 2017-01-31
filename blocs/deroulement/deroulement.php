<?php

$args_tous = array(
    //Déroulement NON REPAS
    'post_type'		=> 'deroulement',
    'orderby' => 'menu_order',
    'order' => 'ASC'
    'meta_key'		=> 'categorie',
    'meta_value'	=> '0',
); 

$query_tous = new WP_Query( $args_tous );

?>
<?php if( $query_tous->have_posts() ): ?>  


<section class="bgsection">

<div class="wrapper-title">
    <h2>Déroulement</h2>
    <p class="subtitle">Toutes les étapes de notre journée</p>
    <svg viewBox="0 0 100 100" width="50" height="50"><use xlink:href="#icon-fleur"></use></svg>
</div>

<div>
    
    <?php while( $query_tous->have_posts() ) : $query_tous->the_post(); ?>

        <div class="singleHalf textContent">


            <?php $image = get_field('photo_illustrative'); ?>

            <?php if( !empty($image) ): ?>

            <div class="halfPhoto" style="background-image:url('<?php echo $image['sizes']['sL1200']; ?>');"></div>

            <?php endif; //empty $image ?>

            <div class="contentHalf">
                <h3><?php the_title();?></h3>

                <p class="h4 lieu"><?php the_field('titre_du_lieu');?></p>
                <span class="date"><?php the_field('date_et_heure');?></span>

                <?php the_field('description');?>
            </div>

        </div>                

    <?php endwhile;?>

</div>

</section>
         
<?php endif;?>
                                      
                       
<?php

$args_tous = array(
    //Déroulement NON REPAS
    'post_type'		=> 'deroulement',
    'meta_key'		=> 'categorie',
    'meta_value'	=> '1',
); 

$query_tous = new WP_Query( $args_tous );

?>
<?php if( $query_tous->have_posts() ): ?> 

<section class="wrapperPadding">
<div class="wrapper-title">
    <h2>Vous êtes invité au repas ?</h2>
    <svg viewBox="0 0 100 100" width="50" height="50"><use xlink:href="#icon-fleur"></use></svg>
</div>

<div class="wrapper-halfBlock">

    <?php while( $query_tous->have_posts() ) : $query_tous->the_post(); ?>

        <div class="singleHalf textContent">


            <?php $image = get_field('photo_illustrative'); ?>

            <?php if( !empty($image) ): ?>

            <div class="halfPhoto" style="background-image:url('<?php echo $image['sizes']['sL1200']; ?>');"></div>

            <?php endif; //empty $image ?>

            <div class="contentHalf">
                <h3><?php the_title();?></h3>

                <p class="h4 lieu"><?php the_field('titre_du_lieu');?></p>
                <span class="date"><?php the_field('date_et_heure');?></span>

                <?php the_field('description');?>
            </div>

        </div>                

    <?php endwhile;?>

</div>

</section>


<?php endif;?>