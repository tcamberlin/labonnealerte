<h2>Créer une annonce</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('ads/create') ?>
    <p>Ce formulaire permet de créer manuellement une annonce. A terme, un crawler récupèrera les annonces automatiquement.</p>
    <label for="title">Titre de l'annonce</label><br />
    <input type="input" name="title" /><br />

    <label for="description">Description</label><br />
    <input type="input" name="description" /><br />

    <label for="phone_image_url">URL de l'image</label><br />
    <input type="input" name="phone_image_url" /><br />

    <input type="hidden" name="area" value="annonces/offres/ile_de_france/" />
    <input type="submit" name="submit" value="Créer" />

</form>