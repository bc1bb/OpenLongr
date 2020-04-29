<?php
function add_footer(string $to_be_added = "") {
    if (! is_curl()) {
    ?>
    <footer>
        <?= $to_be_added."\n" ?>
        <small class="grey"><span class="copyleft">&copy;</span> 2020 - Jus de Patate_ - <a href="https://github.com/jusdepatate/openlongr/commit/<?= get_current_git_commit() ?>"><?= get_current_git_commit("master", true) ?></a></small>
    </footer>
</body>
</html>
<?php
    }
}
