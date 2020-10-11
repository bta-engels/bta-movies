<?php require_once 'inc/html_header.php'; ?>

<div>
    <a href="/authors/edit" role="button" class="btn btn-primary mt-0 mb-3">Neuen Autor anlegen</a>
</div>

<?php if (isset($list) && count($list) > 0) : ?>
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th colspan="2"><br></th>
        </tr>
        <?php foreach ($list as $author) : ?>
            <tr>
                <td><?php echo $author['id']; ?></td>
                <td><?php echo $author['firstname']; ?></td>
                <td><a href="/authors/<?php echo $author['id']; ?>"><?php echo $author['lastname']; ?></a></td>
                <td class="col-1"><a href="/authors/edit/<?php echo $author['id']; ?>" class="btn-sm btn-primary" role="button">Edit</a></td>
                <td class="col-1"><a href="/authors/delete/<?php echo $author['id']; ?>" class="btn-sm btn-danger delsoft" role="button">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <h3>Keine Daten vorhanden</h3>
<?php endif; ?>

<?php require_once 'inc/html_footer.php'; ?>