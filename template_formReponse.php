<?php /* Template Name: Form reponse */ get_header(); ?>

<?php
    //Photos officielles
    $imagesOfficielle = get_field('galerie_photo');
?>

<?php

$nbPersonnes = 0;

if(isset($_POST['name_dude']) && $_POST['name_dude'] != ""){
    $name = $_POST['name_dude'];
}

if(isset($_POST['email']) && $_POST['email'] != ""){
    $email = $_POST['email'];
}

if(isset($_POST['participe_question']) && $_POST['participe_question'] != ""){
    $participe = $_POST['participe_question'];
}

if(isset($_POST['plusOne']) && $_POST['plusOne'] != ""){
    $plusOne = $_POST['plusOne'];
}

if(isset($_POST['nomInvites']) && $_POST['nomInvites'] != ""){
    $nomInvites = $_POST['nomInvites'];
    $parseInvites = explode(',',$nomInvites);
}

if(isset($_POST['okMailing']) && $_POST['okMailing'] != ""){
    $mailing = $_POST['okMailing'];
}

if(isset($_POST['message_fac']) && $_POST['message_fac'] != ""){
    $message_correct = true;
    $message = $_POST['message_fac'];
}


// Rempli le CPT

if(isset($_POST['name_dude']) && $_POST['name_dude'] != "" && isset($_POST['participe_question']) && $_POST['participe_question'] != ""){
    
    $postArgs = array(
        'post_title' => $name,
        'post_type' => 'invite',
        'post_status' => 'publish',
    ); 
    
    $id = wp_insert_post($postArgs);

    update_field('email', $email, $id);    
    if($participe == "true"){
        update_field('participera', $participe, $id);
        $nbPersonnes += 1;
    }
    if($mailing == "true"){update_field('ok_email', $mailing, $id);}
    update_field('accompagne', $plusOne, $id);
    update_field('email', $email, $id);
    
    
    // Noms des accompagnants
    if(isset($nomInvites)){
        //nb invités
        $nbInvites = count($parseInvites);
        $nbPersonnes += $nbInvites;
        
        $value = array();
        
        for($i = 0; $i < $nbInvites; $i++){
            array_push($value, array('nom' => $parseInvites[$i]));
        }
        
        update_field('accompagnants', $value, $id);
    }
    
    update_field('nombre_de_personnes', $nbPersonnes, $id);
    update_field('message_facultatif', $message, $id);
    

    // Envoi d'un email s'il a pas coché la case pour pas avoir les notifs email
    if(!get_field('email_invite', 'option')){
        
        include('emails/template_email.php');

        $message = '<h2>Nouvelle inscription</h2>
            <ul>
                <li><b>Nom : </b>'.$name.'</li>
                <li><b>Email : </b>'.$email.'</li>
                <li><b>Participation : </b>'.$participe.'</li>
                <li><b>Viendra accompagné : </b>'.$plusOne.'</li>
                <li><b>Viendra avec : </b>'.$nomInvites.'</li>
                <li><b>A laissé ce message : </b>'.$message.'</li>
            </ul>';
        
        $message = bja_email($message);

        $headers = array('Content-Type: text/html; charset=UTF-8;');

        // Envoi de l'email

        function bjrA_set_html_email_content(){
            return 'text/html';
        }

        add_filter('wp_mail_content_type', 'bjrA_set_html_email_content');

        wp_mail(get_option('admin_email'), '[Mariage] '.$name.' a rempli le formulaire d\'inscription', $message, $headers);

        remove_filter( 'wp_mail_content_type', 'bjrA_set_html_email_content' );

        function set_html_content_type() {
            return 'text/html';
        }
    }
    
    echo('<div class="alertRsvp alert_ok">Votre réponse a bien été prise en compte !</div>');
    
}else{
    if(isset($_POST['hiddenForm']) && $_POST['hiddenForm'] == 'true'){
        print('<div class="alertRsvp alert_nok">Le formulaire est incomplet, merci de remplir tous les champs obligatoires.</div>');
    }  
}
//end isset

?>

<!-- header -->
<header class="header" role="banner">

    <?php include('logo-nav.php');?>
    
    <div class="headerContent">     
        <h1><?php the_title();?></h1>      
    </div>

</header>
<!-- /header -->

<section class="bgsection wrapperPadding" id="addLive">
    <div class="wrapper-title">
        <h2><?php the_title();?></h2>
            <?php     
        $dateformat = "j F";
        $unixtimestamp = strtotime(get_field('reponse_souhaitee_avant', 'option', false));
    ?>

        <p class="subtitle">Veuillez s'il vous plait confirmer votre présence avant le <?php echo date_i18n($dateformat, $unixtimestamp); ?></p>
        <svg viewBox="0 0 100 100" width="50" height="50"><use xlink:href="#icon-fleur"></use></svg>
    </div>	

   <?php if( have_rows('maries', 'option') ): ?>


    <div class="mariesContact">

        <?php while ( have_rows('maries', 'option') ) : the_row(); ?>
        <?php $image = get_sub_field('photo'); ?>
        <div>
            <div class="photoReponse">
                <img src="<?php echo $image['sizes']['s150']; ?>" alt="" />
            </div>
            <div class="textReponse">
                <p class="h3"><?php the_sub_field('prenom'); ?></p>
                <p><a href="tel:<?php echo(str_replace(' ','',get_sub_field('telephone')));?>"><?php the_sub_field('telephone'); ?></a></p>
                <p><a href="mailto:<?php the_sub_field('email'); ?>"><?php the_sub_field('email'); ?></a></p>
            </div>
        </div>
        <?php endwhile;?>

        <div class="coeurForm">
            <svg viewBox="0 0 100 100" width="30" height="30" class="">
              <use xlink:href="#icon-coeur"></use>
            </svg>
        </div>

    </div>

    <?php endif; ?>

    <form action="<?php echo ods_getTemplatePermalink('template_formReponse.php'); ?>" method="post" enctype="multipart/form-data" class="" id="reponseInvit">

        <div>
            <p class="formHalf">
                <label for="name">Votre nom ?</label>
                <input type="text" id="name" name="name_dude" value="<?php if(isset($_COOKIE["name"])){echo $_COOKIE["name"];} ?>" required>
            </p>

            <p class="formHalf halfRight">
                <label for="email">Une adresse mail ?</label>
                <input type="email" id="email" name="email" required>
            </p>

            <div class="wrapper-radios">

                <p>
                    <input type="radio" id="participeOk" name="participe_question" value="true" required>
                    <label for="participeOk">Je participerai aux festivités</label>
                </p>

                <p>
                    <input type="radio" id="participeNok" name="participe_question" value="false" required>
                    <label for="participeNok">Je ne suis malheureusement pas disponible</label>
                </p>

            </div>

            <div class="wrapper-checkbox">

                <p>
                    <input type="checkbox" id="plusOne" name="plusOne" value="true">
                    <label for="plusOne">Je viendrais accompagné<span class="tick"></span></label>
                </p>       

            </div>

            <p class="accompagnants">
                <label for="nomInvites">Merci de préciser le ou les noms des accompagnants <span>(en les séparants par des virgules ou en appuyant sur entré)</span></label>
                <input type="text" name="nomInvites" id="nomInvites" cols="30" rows="5" />
            </p>


            <p>
                <label for="message">Votre message ? <span>(facultatif)</span></label>
                <textarea name="message_fac" id="message" cols="30" rows="5"></textarea>
            </p>
            
            <?php if(get_field('pack_achete', 'option') == "pack2" OR get_field('pack_achete', 'option') == "pack3"):?>
            
            <div class="wrapper-checkbox">
                <p>
                    <input type="checkbox" id="mailNews" name="okMailing" value="true">
                    <label for="mailNews">M'envoyer un mail à chaque nouvelle actualité<span class="tick"></span></label>
                </p>       
            </div>
            
            <?php endif;?>
            
            <input type="hidden" value="true" name="hiddenForm">

            <p class="tcenter">
                <button type="submit">
                    <span class="value_submit show">Envoyer ma réponse</span>
                    <span class="wait-submit hide">
                       <svg viewBox="0 0 100 100" width="30" height="30">
                            <use xlink:href="#icon-refresh"></use>
                        </svg>
                    </span>
                </button>
            </p>
        </div>

    </form>
</section>

<?php get_footer(); ?>