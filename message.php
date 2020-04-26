<?php

require "autoload.php";

add_header();

// https://stackoverflow.com/a/31107425/10503297
function random_str(int $length, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string {
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

function get_country(string $ip) {
    if ($ip == "127.0.0.1") {
        return "Unknown";
    } elseif (function_exists("curl_init")) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://ipapi.co/".$ip."/country_name");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);

        if (curl_errno($ch)) {
            return "Unknown";
        }

        curl_close($ch);
    } else {
        return "Unknown";
    }

    if ($output == "Undefined") {
        return "Unknown";
    } else {
        return $output;
    }
}

if (isset($_POST["message"])) {
    $message = $_POST["message"];
    $message = strip_tags($message);

    $Parsedown = new Parsedown();
    $message = $Parsedown->text($message);

    if (strlen(strip_tags($message)) <= 10420) {
        $dsn = "mysql:host=" . env("mysql_address") . ";dbname=" . env("mysql_database") . ";port=".env("mysql_port").";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $pdo = new PDO($dsn, env("mysql_username"), env("mysql_password"), $options);
            $pdo->exec("use ". env("mysql_database"));
        } catch (PDOException $e) {
            die($e->getMessage()." ".(int)$e->getCode());
        }

        while (true) {
            $id = random_str(env("char_per_id"));
            $req = $pdo->prepare("select * from LONGR where id = ?");
            $req->execute([$id]);

            $row = $req->fetch();
            if (! isset($row['original'])) {
                break;
            }
        }

        # tiny hack to do a unique ID
        $req = $pdo->prepare("insert into LONGR (id, text, country) values (?, ?, ?)");
        $req->execute([$id, $message, get_country($_SERVER['REMOTE_ADDR'])]);

        $req = $pdo->prepare("select * from LONGR where id = ?");
        $req->execute([$id]);

        $row = $req->fetch();
        if (! isset($row['country']) && ! is_curl()) {
            ?>
            <center>
                <h1>An unknown error happened.</h1>
                <a class="btn goback" href="<?= env("ext_url") ?>">Go back</a>
            </center>
            <?php
        } elseif (! isset($row['country']) && is_curl()) {
            echo "erreur";
        } elseif (isset($row['country']) && ! is_curl()) {
            ?>
            <h1 class="center">Your link is ready.</h1>
            <center>
                <input type="text" class="link-form" value="<?= env("ext_url")."/?".$id ?>">
                <a class="btn goback" href="<?= env("ext_url") ?>">Go back</a>
            </center>
            <?php
        } elseif (isset($row['country']) && is_curl()) {
            echo env("ext_url")."/?".$id;
        }

    } elseif (! is_curl()) {
        ?>
        <center>
            <h1>Your message is too long.</h1>
            <a class="btn goback" href="<?= env("ext_url") ?>">Go back</a>
        </center>
        <?php
    }
} else {
    ?>
    <center>
        <h1>Invalid Request.</h1>
        <a class="btn goback" href="<?= env("ext_url") ?>">Go back</a>
    </center>
    <?php
}

add_footer();