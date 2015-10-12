<?php
include("repeaters.php");
include("config.php");
include("language/{$config['language']}.php");

if  (!isset($_GET['page'])) $_GET['page'] = "home";

?>
<head>
    <title>DMR Realtime</title>
    <link href="plugins/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
    <link href="plugins/select2/select2.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css" type="text/css" />
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="js/socket.io.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
</head>
<body>
<h1><?=$language['DRTM']?></h1>
<div id="main" class="container-fluid">
    <div class="row">
        <div id="sidebar-left" class="col-xs-2 col-sm-2">
            <div style="background-color: #ffffff;">
            </div>
            <ul class="nav main-menu">
                <li>
                    <a href="#">
                        <?=$language['possible']?>: PD0ZRY
                    </a>
                </li>
                <li>
                    <a href="#">
                        <?=$config['hosted']?>
                    </a>
                </li>
                <li><a href="#">&nbsp</a></li>
                <li><a href="index.php" <?=($_GET['page']=='home'?'class="active"':'')?>><i class="fa fa-home"></i><?=$language['home']?></a></li>
                <li><a href="index.php?page=news" <?=($_GET['page']=='news'?'class="active"':'')?>><i class="fa fa-newspaper-o"></i><?=$language['news']?></a></li>
                <li><a href="index.php?page=map" <?=($_GET['page']=='map'?'class="active"':'')?>><i class="fa fa-map-marker"></i><?=$language['map']?></a></li>
                <li><a href="index.php?page=how" <?=($_GET['page']=='how'?'class="active"':'')?>><i class="fa fa-heartbeat"></i><?=$language['how']?></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-info-circle"></i>
                        <span class="hidden-xs"><?=$language['legenda']?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-sort-up"></i> <?=$language['forward_power']?> </a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sort-down"></i> <?=$language['reflected_power']?> </a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-tachometer"></i> SWR </a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fire"></i> <?=$language['pa_temp']?></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bolt"></i> <?=$language['voltage']?></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-mobile"></i> RSSI</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user"></i> <?=$language['user']?></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-clock-o"></i> <?=$language['last_time_qso']?></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-phone"></i> <?=$language['talkgroup']?></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-legal"></i> <?=$language['legal']?></a>
                </li>
                <li>
                    <a href="mailto:pd0zry@gigafreak.net"><i class="fa fa-envelope"></i> <?=$language['contact']?></a>
                </li>
            </ul>
        </div>
        <div id="content" class="col-xs-12 col-sm-10">
                <?php
                require_once('pages/'.$_GET['page'].'.php');
                ?>
        </div>
    </div>
</div>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="plugins/bootstrap/bootstrap.min.js"></script>
<script src="plugins/jQuery-Knob/jquery.knob.js"></script>
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//stats.gigafreak.net/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 11]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//stats.gigafreak.net/piwik.php?idsite=11" style="border:0;" alt="" /></p></noscript>
<script type="text/javascript">
function timeSince(date) {
    date = date * 1000
    var seconds = Math.floor((new Date() - date)/1000);

    var interval = Math.floor(seconds / 31536000);

    if (interval > 1) {
        return interval + " <?=$language['years']?>";
    }
    interval = Math.floor(seconds / 2592000);
    if (interval > 1) {
        return interval + " <?=$language['months']?>";
    }
    interval = Math.floor(seconds / 86400);
    if (interval > 1) {
        return interval + " <?=$language['days']?>";
    }
    interval = Math.floor(seconds / 3600);
    if (interval > 1) {
        return interval + " <?=$language['hours']?>";
    }
    interval = Math.floor(seconds / 60);
    if (interval > 1) {
        return interval + " <?=$language['minutes']?>";
    }
    return Math.floor(seconds) + " <?=$language['seconds']?>";
}
</script>

<!-- End Piwik Code -->

