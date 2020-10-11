<?php require_once 'inc/html_header.php'; ?>

<div>
    <a href="/movies/edit" role="button" class="btn btn-primary mt-0 mb-3">Neuen Film anlegen</a>
</div>

<?php if (isset($authors) && count($authors) > 0) : ?>
    <div class="float-right mr-4">
        <form id="frm" name="frm" method="post" action="/movies">
            <div class="form-group row">
                <label for="author_id" class="col-form-label">Bei Autor</label>
                <select
                        class="ml-2"
                        name="author_id"
                        id="author_id" <?php if ($selectedAuthor) : ?>
                    value="<?php echo $selectedAuthor; ?>"<?php endif; ?>
                >
                    <option value="0">Alle</option>
                    <?php foreach ($authors as $author) : ?>
                        <option value="<?php echo $author['id']; ?>" <?php if ($selectedAuthor && $author['id'] === $selectedAuthor) : ?>selected<?php endif; ?>>
                            <?php echo $author['firstname'] . ' ' . $author['lastname']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>
<?php endif; ?>

<?php if (isset($list) && count($list) > 0) : ?>
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Price</th>
            <th colspan="2"><br></th>
        </tr>
        <?php foreach ($list as $movie) : ?>
            <tr>
                <td><?php echo $movie['id']; ?></td>
                <td><a href="/movies/<?php echo $movie['id']; ?>"><?php echo $movie['title']; ?></a></td>
                <td><?php echo $movie['price']; ?></td>
                <td class="col-1"><a href="/movies/edit/<?php echo $movie['id']; ?>" class="btn-sm btn-primary" role="button">Edit</a></td>
                <td class="col-1"><a href="/movies/delete/<?php echo $movie['id']; ?>" class="btn-sm btn-danger delsoft" role="button">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <h3>Keine Daten vorhanden</h3>
<?php endif; ?>

<script>
	$('#author_id').change(function(){
		document.frm.submit();
	});
</script>

<?php require_once 'inc/html_footer.php'; ?>
