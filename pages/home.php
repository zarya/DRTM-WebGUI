<div class="" style="width: 100%;">
                <div class="row" style="position: absolute;">
<?php
foreach($repeaters as $key => $value) {
$repeater = $key;
$_ip = str_replace(".","",$value['ip']);
?>
                    <div class="col-xs-12 col-sm-6 col-md-4" style="width: 250px; height: 360px;">
                        <h4 class="page-header text-right"><?=strtoupper($repeater)?></h4>
                        <small><?=$language['repeater']?> <?=$language['in']?> <?=$repeaters[$repeater]['location']?></small>
                        <br> 
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                <div class="knob-slider">
                                 <div style="position:relative;width:350px;margin:auto">
                                  <div style="position:absolute;left:10px;top:10px">
        <input class="knob power" id="knobPower<?=$_ip?>" data-min="0" data-max="50" data-bgColor="#333" data-fgColor="#ffec03" data-displayInput=false data-width="80" data-height="80" data-thickness=".3" data-readOnly=true>
                                  </div>
                                  <div style="position:absolute;left:25px;top:25px">
        <input class="knob reflectedpower" id="knobRefPower<?=$_ip?>" data-min="0" data-max="50" data-bgColor="#333" data-displayInput=false data-width="50" data-height="50" data-thickness=".45" data-readOnly=true>
                                  </div>
                                 </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-8" style="left: 100px;">
                                <div class="row"><i class="fa fa-sort-up" id="rptTxFwdPowerAlarm<?=$_ip?>"></i> <span id="rptTxFwdPower<?=$_ip?>">0.0</span> <span style="align: right">W</span></div>
                                <div class="row"><i class="fa fa-sort-down" id="rptTxRefPowerAlarm<?=$_ip?>"></i> <span id="rptTxRefPower<?=$_ip?>">0.0</span> <span style="align: right">W</span></div>
                                <div class="row"><i class="fa fa-tachometer" id="rptVswrAlarm<?=$_ip?>"></i> 1:<span id="rptVswr<?=$_ip?>">0.0</span></div>
                                <div class="row"><i class="fa fa-fire" id="rptPaTempratureAlarm<?=$_ip?>"></i><span id="rptPaTemprature<?=$_ip?>"></span> C</div>
                                <div class="row"><i class="fa fa-bolt" id="rptVoltageAlarm<?=$_ip?>"></i><span id="rptVoltage<?=$_ip?>"></span> V</div>
                                <div class="row"><i class="fa fa-mobile"></i>1 <span id="rptSlot1Rssi<?=$_ip?>"></span> dB</div>
                                <div class="row"><span class="sparkline" id="rssi1<?=$_ip?>"><?=$language['loading']?>..</span></div>
                                <div class="row"><i class="fa fa-user"></i> <span id="usrTs1<?=$_ip?>"></span></div>
                                <div class="row"><i class="fa fa-clock-o"></i> <span id="lastTs1<?=$_ip?>"></span></div>
                                <div class="row"><i class="fa fa-phone"></i> <span id="tlkTs1<?=$_ip?>"></span></div>
                                <div class="row"><i class="fa fa-mobile"></i>2 <span id="rptSlot2Rssi<?=$_ip?>"></span> dB</div>
                                <div class="row"><span class="sparkline" id="rssi2<?=$_ip?>"><?=$language['loading']?>..</span></div>
                                <div class="row"><i class="fa fa-user"></i> <span id="usrTs2<?=$_ip?>"></span></div>
                                <div class="row"><i class="fa fa-clock-o"></i> <span id="lastTs2<?=$_ip?>"></span></div>
                                <div class="row"><i class="fa fa-phone"></i> <span id="tlkTs2<?=$_ip?>"></span></div>
                                <div class="row">&nbsp;</div>
                            </div>
                        </div>
                    </div>
<?php } ?>
<script type="text/javascript">
    var rssi1log={};
    var rssi2log={};
    var repeater="<?=$repeaters[$repeater]['ip']?>";
    $(document).ready(function () {
        $('.sparkline').sparkline([],{width: '120px',});
<?php
foreach($repeaters as $key => $value) {
?>
        //createRepeaterGauge("<?=$key?>",false);
<?php } ?>
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
                if (msg.payload == "Alarm") {
                    $('#'+elma[2]+elma[1].replace(/\./g,'')).addClass('txt-danger');
                    $('#'+elma[2]+elma[1].replace(/\./g,'')).removeClass('txt-success');
                } else {
                    $('#'+elma[2]+elma[1].replace(/\./g,'')).removeClass('txt-danger');
                    $('#'+elma[2]+elma[1].replace(/\./g,'')).addClass('txt-success');
                }
            }
            if (elma[2] == "lastTs1") {
                console.log(elma[1]+" "+msg.payload);
                var since = timeSince(msg.payload);
                $('#lastTs1'+elma[1].replace(/\./g,'')).html(since+" <?=$language['ago']?>");
            }
            if (elma[2] == "lastTs2") {
                console.log(elma[1]+" "+msg.payload);
                var since = timeSince(msg.payload);
                $('#lastTs2'+elma[1].replace(/\./g,'')).html(since+" <?=$language['ago']?>");
            }
         });
         socket.emit('subscribe',{topic:'hytera/#'});
        });
</script>
</div>
                <!--End Dashboard Tab 4-->
            </div>
            <div class="clearfix"></div>
