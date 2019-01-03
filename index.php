<?php

use Brainex\ShopperGrabber\ShopperGrabber;
use Brainex\ShopperGrabber\Url;

require_once 'vendor/autoload.php';
require_once 'config.jumia.php';

$config = new JumiaConfig();
$grabber = new ShopperGrabber();
$grabber->setConfig($config);

$url = new Url(
    'https://www.jumia.com.ng/gionee-s10-lite-4gb-ram-32gb-rom-qualcomm-snapdragon-427-5.2hd-android-7.1-4g-lte-smartphone-20108315.html?seller_product=1');

$result = $grabber->getResult($url);
$price = $result->getPrice();
$title = $result->getTitle();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
</head>
<body>
    <h1>
        <?= $title ?>
    </h1>
    <div>
        <img src="<?= $result->getImageUrl() ?>" alt="">
    </div>
    <h2>
        Price: NGN<?= number_format($price, 2) ?>
    </h2>
    <div>
        <?php foreach($result->getCustom('subimages') as $image): ?>
        <div>
            <img src="<?= $image ?>">
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>