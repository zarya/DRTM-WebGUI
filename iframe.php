<?php
include("repeaters.php");
include("config.php");
?>
<head>
    <title>DMR Realtime</title>
    <link href="plugins/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
    <link href="plugins/select2/select2.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css" type="text/css" />
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="socket.io.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <script type="text/javascript">
    var rssi1log={};
    var rssi2log={};
    var repeater="<?=$repeaters[$repeater]['ip']?>";
    $(document).ready(function () {
        $('.sparkline').sparkline([],{width: '120px',});
<?
foreach($repeaters as $key => $value) {
?>
        //createRepeaterGauge("<?=$key?>",false);
<?}?>
        createKnob();
/*
        setInterval(function() {
            jQuery.get('dmrusers.txt', function(data) {
                console.log(data);
            });
        }, 10000);
*/
    });
      var socket = io.connect('<?=$config['pusher']?>');
        socket.on('connect', function () {
          socket.on('mqtt', function (msg) {
            var elma=msg.topic.split('/');
            var elm = elma[2]+elma[1].replace(/\./g,'');
            console.log(elm+' '+msg.payload);

            if (parseFloat(msg.payload) > 0)
                msg.payload = round_float(msg.payload,2);
            if (strEndsWith(elma[2],"Alarm") == false)
                $('#'.concat(elm)).html(msg.payload);
            if (elma[2] == "rptTxFwdPower") {
                $('#knobPower'+elma[1].replace(/\./g,'')).val(msg.payload).trigger("change");
            }
            if (elma[2] == "rptTxRefPower") {
                $('#knobRefPower'+elma[1].replace(/\./g,'')).val(msg.payload).trigger("change");
            }
            if (elma[2] == "rptSlot1Rssi") {
                var host = elma[1].replace(/\./g,'')
                if (rssi1log[host] == undefined)
                    rssi1log[host] = [msg.payload];
                else
                    rssi1log[host] = statsarray(rssi1log[host],msg.payload);
                $('#rssi1'.concat(host)).sparkline(rssi1log[host]);
            }
            if (elma[2] == "rptSlot2Rssi") {
                var host = elma[1].replace(/\./g,'')
                if (rssi2log[host] == undefined)
                    rssi2log[host] = [msg.payload];
                else
                    rssi2log[host] = statsarray(rssi2log[host],msg.payload);
                $('#rssi2'.concat(host)).sparkline(rssi2log[host]);
            }
            if (strEndsWith(elma[2],"Alarm") == true) {
                if (msg.payload == 1) {
                    $('#'+elma[2]+elma[1].replace(/\./g,'')).addClass('txt-danger');
                    $('#'+elma[2]+elma[1].replace(/\./g,'')).removeClass('txt-success');
                } else {
                    $('#'+elma[2]+elma[1].replace(/\./g,'')).removeClass('txt-danger');
                    $('#'+elma[2]+elma[1].replace(/\./g,'')).addClass('txt-success');
                }
            } 
         });
         socket.emit('subscribe',{topic:'hytera/#'});
        });
</script>
</head>
<body>
    <div class="row" style="margin-left: 0px;">
        <div id="content" class="width: 100%; margin-left: 40px;">
            <div class="">
<?
if (isset($_GET['repeater'])) {
    $_repeaters=array();
    $_repeaters[$_GET['repeater']] = $repeaters[$_GET['repeater']];
} else 
    $_repeaters = $repeaters;
foreach($_repeaters as $key => $value) {
$repeater = $key;
$_ip = str_replace(".","",$value['ip']);
?>
                <div class="row" style="">
                    <div class="col-xs-12 col-sm-6 col-md-4" style="width: 250px; height: 260px;">
                        <h4 class="page-header text-right"><?=strtoupper($repeater)?></h4>
                        <small>Repeater van <?=$repeaters[$repeater]['location']?></small>
                        <br>
                        <table width="300px">
                        <tr><td width="150px">
                                <div class="knob-slider" style="margin-left: -80px;margin-top:-80px;">
                                 <div style="position:relative;margin:auto">
                                  <div style="position:absolute;left:10px;top:10px">
        <input class="knob power" id="knobPower<?=$_ip?>" data-min="0" data-max="50" data-bgColor="#333" data-fgColor="#ffec03" data-displayInput=false data-width="80" data-height="80" data-thickness=".3" data-readOnly=true>
                                  </div>
                                  <div style="position:absolute;left:25px;top:25px">
        <input class="knob reflectedpower" id="knobRefPower<?=$_ip?>" data-min="0" data-max="50" data-bgColor="#333" data-displayInput=false data-width="50" data-height="50" data-thickness=".45" data-readOnly=true>
                                  </div>
                                 </div>
                            </td><td>
                                <i class="fa fa-sort-up" id="rptTxFwdPowerAlarm<?=$_ip?>"></i> <span id="rptTxFwdPower<?=$_ip?>">0.0</span> <span style="align: right">W</span><br>
                                <i class="fa fa-sort-down" id="rptTxRefPowerAlarm<?=$_ip?>"></i> <span id="rptTxRefPower<?=$_ip?>">0.0</span> <span style="align: right">W</span><br>
                                <i class="fa fa-tachometer" id="rptVswrAlarm<?=$_ip?>"></i> 1:<span id="rptVswr<?=$_ip?>">0.0</span><br>
                                <i class="fa fa-fire" id="rptPaTempratureAlarm<?=$_ip?>"></i><span id="rptPaTemprature<?=$_ip?>"></span> C<br>
                                <i class="fa fa-bolt" id="rptVoltageAlarm<?=$_ip?>"></i><span id="rptVoltage<?=$_ip?>"></span> V<br>
                                <i class="fa fa-mobile"></i> <span id="rptSlot1Rssi<?=$_ip?>"></span> dB<br>
                                <span class="sparkline" id="rssi1<?=$_ip?>">Loading..</span><br>
                                <i class="fa fa-mobile"></i> <span id="rptSlot2Rssi<?=$_ip?>"></span> dB<br>
                                <span class="sparkline" id="rssi2<?=$_ip?>">Loading..</span><br>
                            </div>
                        </td></tr></table>
                    </div>
                </div>
<? } ?>
                <!--End Dashboard Tab 4-->
            </div>
            <div class="clearfix"></div>
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

