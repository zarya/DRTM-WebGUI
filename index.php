<?php
include("repeaters.php");
include("config.php");

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
<h1>DMR Real time Monitor</h1>
<div id="main" class="container-fluid">
    <div class="row">
        <div id="sidebar-left" class="col-xs-2 col-sm-2">
            <div style="background-color: #ffffff;">
            </div>
            <ul class="nav main-menu">
                <li>
                    <a href="#">
                        Made possible by: PD0ZRY in cooperation with PI4AMF
                    </a>
                </li>
                <li><a href="#">&nbsp</a></li>
                <li><a href="index.php" <?=($_GET['page']=='home'?'class="active"':'')?>><i class="fa fa-home"></i>Home</a></li>
                <li><a href="index.php?page=news" <?=($_GET['page']=='news'?'class="active"':'')?>><i class="fa fa-newspaper-o"></i>News</a></li>
                <li><a href="index.php?page=map" <?=($_GET['page']=='map'?'class="active"':'')?>><i class="fa fa-map-marker"></i>Map</a></li>
                <li><a href="index.php?page=how" <?=($_GET['page']=='how'?'class="active"':'')?>><i class="fa fa-heartbeat"></i>How</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-info-circle"></i>
                        <span class="hidden-xs">Legenda</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-sort-up"></i> PA Forward power </a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sort-down"></i> Reflected power </a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-tachometer"></i> SWR </a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fire"></i> PA Temperature</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bolt"></i> Voltage</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-mobile"></i> RSSI</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-user"></i> User</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-clock-o"></i> Time since last QSO</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-phone"></i> Talkgroup</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-legal"></i> Aan deze pagina kunnen geen rechten worden ontleend</a>
                </li>
                <li>
                    <a href="mailto:pd0zry@gigafreak.net"><i class="fa fa-envelope"></i> Contact</a>
                </li>
            </ul>
        </div>
        <div id="content" class="col-xs-12 col-sm-10">
                <?
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
<!-- End Piwik Code -->

