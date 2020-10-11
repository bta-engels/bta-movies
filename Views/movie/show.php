<?php require_once 'inc/html_header.php'; ?>

<?php if (isset($item) && is_array($item)) : ?>
    <table class="table table-striped">
        <tr>
            <th>ID:</th>
            <td><?php echo $item['id']; ?></td>
        </tr>
        <tr>
            <th>Title:</th>
            <td><?php echo $item['title']; ?></td>
        </tr>
        <tr>
            <th>Price:</th>
            <td><?php echo $item['price']; ?></td>
        </tr>
        <tr>
            <th>Author:</th>
            <td><?php echo $item['author']['name']; ?></td>
        </tr>

        <?php if ($item['image']) : ?>
            <tr>
                <th>Bild:</th>
                <td>
                    <img 
                        src="/uploads/<?php echo trim($item['image']); ?>" 
                        width="400" 
                        title="<?php echo $item['image']; ?>" 
                        alt="<?php echo $item['image']; ?>" 
                    />
                </td>

            </tr>
        <?php endif; ?>
    </table>
<?php else : ?>
    <h3>Keine Daten vorhanden</h3>
<?php endif; ?>

<?php require_once 'inc/html_footer.php'; ?>