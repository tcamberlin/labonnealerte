<h2>Créer une alerte</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('alerts/create') ?>

    <label for="search_terms">Termes de recherche</label><br />
    <input type="input" name="search_terms" /><br />

    <label for="email">email</label><br />
    <input type="input" name="email" /><br />

    <input type="submit" name="submit" value="Créer" />

</form>