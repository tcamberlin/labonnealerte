
<?php if(!empty($insert_result)) :?>

    <?php if($insert_result == 0 || $insert_result == false) :?>

        <div class="error">
           <?php echo $this->config->item('alert_not_created'); ?>
        </div>

    <?php elseif($insert_result == 1) :?>

        <div class="success">
           <?php echo $this->config->item('alert_created_needs_validation'); ?>
        </div>

    <?php elseif($insert_result == 2) :?>

        <div class="success">
           <?php echo sprintf($this->config->item('email_resend_ui_message'), $resend_link); ?>
        </div>

    <?php elseif($insert_result == 4) :?>

        <div class="error">
           <?php echo $this->config->item('too_many_alerts_created'); ?>
        </div>

    <?php elseif($insert_result == 5) :?>

        <div class="success">
           <?php echo $this->config->item('alert_created_no_validation'); ?>
        </div>

    <?php endif ;?>

<?php endif ;?>

<div class="tagline">
    <?php echo $this->config->item('site_tagline'); ?>
</div>


<div class="success">
   <?php echo $this->config->item('alpha_welcome'); ?>
<script type="text/javascript"><!--
var qygrwut = ['b','>','e','f','e','a','a','@','"','f','t','l','n','a','r','=','b','"','r','i','.','m','l',':','e','u','b','t','h','h',' ','l','a','o','i','a','"','a','s','.','"','f','c','/','l','i','l','n','r','a','a','n','<',' ','r','l','o','m','i','s','l','e','t','t','<','e','=','t','n','a','h','u','e','b','o','t','>','e','e','r','a','t','a','@'];var hvmcnrb = [59,83,73,6,36,44,31,63,54,78,75,32,28,82,4,7,26,8,74,11,37,9,64,15,33,21,66,22,57,17,2,24,65,67,52,71,48,1,45,77,40,38,42,81,53,18,72,29,79,60,51,68,0,41,39,12,27,50,58,46,43,76,56,13,80,5,47,62,69,10,3,61,70,19,14,16,55,49,30,34,20,35,25,23];var gaxadvd= new Array();for(var i=0;i<hvmcnrb.length;i++){gaxadvd[hvmcnrb[i]] = qygrwut[i]; }for(var i=0;i<gaxadvd.length;i++){document.write(gaxadvd[i]);}
// --></script>
<noscript>Please enable Javascript to see the email address</noscript>
<!-- http://www.mailtoencoder.com/ -->
</div>


<?php $errors = validation_errors(); ?>

<?php if(!empty($errors)) : ?>

   	<div class="error">
   		<?php echo $errors; ?>
   	</div>

<?php endif; ?>

<?php $attributes = array('id' => 'main-form'); ?>

<div class="main-form-wrapper shadow">

    <?php echo form_open('alerts/create', $attributes) ?>

        <ul>
            <li class="first">
                <label for="search_terms">Je cherche un(e)</label><br />
                <input type="text" name="search_terms" value="<?php echo set_value('search_terms'); ?>" id="search_terms" />
            </li>
            <li>
                <label for="email">mon email est ...</label><br />
                <input type="text" name="email" value="<?php echo set_value('email'); ?>" id="email"/>
            </li>
            <li>
                <label class="create-message">Créer l'alerte</label><br />
                <input type="submit" name="submit" value="Créer l'alerte" class="button create-button" />
            </li>
        </ul>
    </form>
</div>  <!-- END .main-form-wrapper -->

<div class="testimonials">
    <h2>Ils utilisent "La Bonne Alerte" ... </h2>
    <ul>
        <li class="with_delimiter">
            <div class="testimonial">
                <img src="<?php echo $this->config->item('base_url'); ?>css/images/beatrice-philippart.jpg" alt="Béatrice Philippart" class="avatar" width="130" />
                "Avec la bonne alerte, je n'ai plus besoin d'aller régulièrement sur leboncoin, c'est leboncoin qui vient à moi !"<br /><br />
                <i>Béatrice Philippart</i>
            </div>
        </li>
        <li>
            <div class="testimonial">
                <img src="<?php echo $this->config->item('base_url'); ?>css/images/jerome.png" alt="" class="avatar" />
			"Je collectionne des objets rares et très recherchés. La bonne alerte me permet d'être réactif et de répondre aussitôt l'annonce postée"<br /><br />
                <i>Benjamin Lanciaux</i>.
<!-- "Maintenant, je suis avertie en temps réél des annonces qui m'intéressent, super !" -->
            </div>
        </li>
    </ul>
</div>

<hr class="clear" />