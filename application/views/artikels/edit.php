<form method="post" action='<?php echo base_url();?>artikels/update/<?php echo $id ?>'>
    <div class="container">
        Artikel :
        <input type="text" name="naam" id="naam" value=<?php echo $naam ?>>
        <button type="submit" class="btn-sm btn-default">Opslaan</button>

    </div>
</form>