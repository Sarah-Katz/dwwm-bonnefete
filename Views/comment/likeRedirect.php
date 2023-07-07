<form id="redirectForm" action="../comment/showComments" method="post">
    <input type="hidden" name="ID_post" value="<?= $data['ID_post'] ?>">
    <input type="hidden" name="ID_comment" value="<?= $data['ID_comment'] ?>">
    <input type="hidden" name="origin" value="<?= $origin ?>">
</form>

<!-- JS pour la redirection -->
<script>
    document.getElementById('redirectForm').submit();
</script>