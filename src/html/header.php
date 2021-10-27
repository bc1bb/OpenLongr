<?php
function add_header(string $to_be_added = "") {
    if (! is_curl()) {
    ?>
<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#">
<head>
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="<?= env('ext_url') ?>/src/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?= env('ext_url') ?>/src/css/water.css" />

    <!-- meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1">
    <meta name="application-name" content="<?= env('title') ?>">
    <meta name="msapplication-tooltip" content="<?= env('title') ?>"/>
    <meta name="description" content="<?= env('title') ?> - Share messages easily & quickly.">

    <meta property="og:url" content="<?= env('ext_url') ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= env('title') ?>">
    <meta property="og:image" content="<?= env('ext_url') ?>/src/img/logo.png">
    <meta property="og:image:alt" content="<?= env('title') ?> - Share messages easily & quickly.">
    <meta property="og:description" content="<?= env('title') ?> - Share messages easily & quickly.">
    <meta property="og:site_name" content="<?= env('title') ?>">
    <meta property="og:locale" content="en_US">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:creator" content="@jusdepatate_">
    <meta name="twitter:url" content="<?= env('ext_url') ?>">
    <meta name="twitter:title" content="<?= env('title') ?>">
    <meta name="twitter:description" content="<?= env('title') ?> - Share messages easily & quickly.">
    <meta name="twitter:image:alt" content="<?= env('title') ?> - Share messages easily & quickly.">
    <meta name="twitter:dnt" content="on">

    <?= $to_be_added."\n" ?>
    <title><?= env('title') ?></title>
</head>
<body>
<div><a class="name grey" href="<?= env('ext_url') ?>">OpenLongr</a></div>
    <?php
    }
}
