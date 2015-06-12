<form method="post" action='<?php echo base_url(); ?>artikels/update/<?php echo $id ?>'>
    <a href="<?php echo base_url(); ?>artikels" class="btn-sm btn-default btn-xs">Terug</a>

    <div class="container">
        Artikel :
        <input type="text" name="naam" id="naam" value=<?php echo "'" . $naam . "'" ?>>
        <button type="submit" class="btn-sm btn-default">Opslaan</button>

    </div>
</form>