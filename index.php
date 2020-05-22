<?php

require "autoload.php";
require "src/html/header.php";
require "src/html/footer.php";

$argument = preg_split('/[\/].*[?]/', $_SERVER["REQUEST_URI"]);
if (sizeof($argument) === 2) {
    $argument = $argument[1];

    $dsn = "mysql:host=" . env("mysql_address") . ";dbname=" . env("mysql_database") . ";port=".env("mysql_port").";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    try {
        $pdo = new PDO($dsn, env("mysql_username"), env("mysql_password"), $options);
        $pdo->exec("use ". env("mysql_database"));
    } catch (\PDOException $e) {
        die($e->getMessage()." ".(int)$e->getCode());
    }

    $req = $pdo->prepare("select * from LONGR where id = ?");
    $req->execute([$argument]);

    $row = $req->fetch();
    if (isset($row['text'])) {
        add_header();
        ?>
        <center>
            <div class="message">
                <?= $row['text'] ?>
            </div>
        </center>
        <?php
        add_footer("<small class=\"grey from\">Message uploaded from " . $row['country'] . "</small><br>");
        die();
    } else {
        add_header();
        ?>
        <center>
            <h1>This message doesn't exist.</h1>
            <a href="<?= env("ext_url") ?>" class="btn goback">Go back</a>
        </center>
        <?php
    }
} else {
    add_header();
    ?>
                    <div class="center"><h1>Turn your giant messages into small links.</h1></div>
                    <form method="post" action="<?= env('ext_url') ?>/message.php">
                        <center>
                            <div id="epiceditor">
                                <textarea placeholder="Put your message here" id="message" name="message" maxlength="<?= env("char_per_msg") ?>"required></textarea>
                            </div>
                            <small class="grey">You can't put messages longer than <?= env("char_per_msg") ?> characters</small>
                            <input type="submit" value="Transformation" class="btn">
                        </center>
                    </form>
    <?php
}

add_footer();
