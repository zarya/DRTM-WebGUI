 <style type="text/css">
      #map-canvas { height: 100%; margin: 0; padding: 0;}
    </style>

            <div style="height: 900px; width: 100%; margin-left: -15px;"><div id="map-canvas"></div></div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCu_vTt5K1N_4gGGqyP2DdA5uD8IsrN3U4"></script>
<script>
var map;
var repeaterLocations = {};
var repeaterRSSI1 = {};
var repeaterRSSI2 = {};
var repeaters = {};
var repeatersip = {};
<?
foreach($repeaters as $key => $value) {
$_ip = str_replace(".","",$value['ip']);
?>
repeaters['<?=$key?>'] = {
 center: new google.maps.LatLng(<?=$value['gps'][0]?>, <?=$value['gps'][1]?>),
 rssi: <?=($value['rssi']>0?$value['rssi']:'0')?>,
 city: '<?=$value['location']?>'
} 
repeatersip['<?=$_ip?>'] = "<?=$key?>";
<? } ?>

function bindInfoWindow(marker, map, infowindow, html) {
    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(html);
        infowindow.open(map, marker);
    });
}

function init_map() {
  var styles = [
  {
    "stylers": [
      { "visibility": "off" }
    ]
  },{
    "featureType": "water",
    "stylers": [
      { "visibility": "on" },
      { "color": "#808080" }
    ]
  },{
    "featureType": "administrative",
    "stylers": [
      { "visibility": "on" },
      { "lightness": 54 }
    ]
  },{
    "featureType": "landscape.natural",
    "stylers": [
      { "visibility": "on" }
    ]
  },{
    "featureType": "water",
    "elementType": "labels",
    "stylers": [
      { "visibility": "off" }
    ]
  },{
    "featureType": "landscape",
    "stylers": [
      { "visibility": "off" }
    ]
  },{
    "featureType": "administrative",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "lightness": -42 }
    ]
  }
];
  var styledMap = new google.maps.StyledMapType(styles,
    {name: "Styled Map"});

  var mapOptions = {
    zoom: 8,
    center: new google.maps.LatLng(52.155314, 5.387725),
    mapTypeControlOptions: {
      mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
    }
  };
  var map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);

  map.mapTypes.set('map_style', styledMap);
  map.setMapTypeId('map_style');

  var infowindow =  new google.maps.InfoWindow({
    content: ''
  });

  for (var repeater in repeaters) {
    var repeaterLocation = {
      position: repeaters[repeater].center,
      icon: {
        path: google.maps.SymbolPath.CIRCLE,
        fillColor: 'green',
        fillOpacity: 0.8,
        scale: 3,
        strokeColor: 'yellow',
        strokeWeight: 0
      },
      draggable: false,
      map: map,
      title: repeater.toUpperCase()
    };
    repeaterLocations[repeater] = new google.maps.Marker(repeaterLocation);
    bindInfoWindow(repeaterLocations[repeater], map, infowindow, "<b>"+repeater.toUpperCase()+"</b><br>"+repeaters[repeater].city);
  }

  for (var repeater in repeaters) {
    var repeaterSignal = {
      strokeColor: '#00FF00',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#00FF00',
      fillOpacity: 0.35,
      map: map,
      center: repeaters[repeater].center,
      radius: Math.sqrt(0) * 100
    };
    if (repeaters[repeater].rssi > 1) {
        repeaterRSSI1[repeater] = new google.maps.Circle(repeaterSignal);
    }
  }

  for (var repeater in repeaters) {
    var repeaterSignal = {
      strokeColor: '#0000FF',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#0000FF',
      fillOpacity: 0.35,
      map: map,
      center: repeaters[repeater].center,
      radius: Math.sqrt(0) * 100
    };
    if (repeaters[repeater].rssi > 1) {
        repeaterRSSI2[repeater] = new google.maps.Circle(repeaterSignal);
    }
  }
}

google.maps.event.addDomListener(window, 'load', init_map);

var socket = io.connect('http://home.gigafreak.net:5000');
socket.on('connect', function () {
  socket.on('mqtt', function (msg) {
    var elma=msg.topic.split('/');
    var ip = elma[1].replace(/\./g,'');
    if (elma[2] == "rptTxFwdPower" && ip in repeatersip && repeatersip[ip] in repeaterLocations){
        var power = 0;
        if (msg.payload > 0) 
            power = 10;
        var icons = repeaterLocations[repeatersip[ip]].get('icon');
        icons['strokeWeight'] = power; 
        repeaterLocations[repeatersip[ip]].set('icon',icons); 
    }
    if (strEndsWith(elma[2],"1Rssi") == true  && 
        repeatersip[ip] in repeaterRSSI1 && 
        ip in repeatersip && 
        repeaters[repeatersip[ip]].rssi > 0){
        var rssi = msg.payload * -1;
        var reverserssi = repeaters[repeatersip[ip]].rssi - rssi
        if (reverserssi > 0)
            repeaterRSSI1[repeatersip[ip]].set('radius',Math.sqrt(rssi * 500) * 100);
        else
            repeaterRSSI1[repeatersip[ip]].set('radius',Math.sqrt(0) * 100);
    }
    if (strEndsWith(elma[2],"2Rssi") == true  && 
        ip in repeatersip && 
        repeatersip[ip] in repeaterRSSI2 && 
        repeaters[repeatersip[ip]].rssi > 0){
        var rssi = msg.payload * -1;
        var reverserssi = repeaters[repeatersip[ip]].rssi - rssi
        if (reverserssi > 0)
            repeaterRSSI2[repeatersip[ip]].set('radius',Math.sqrt(rssi * 500) * 100);
        else
            repeaterRSSI2[repeatersip[ip]].set('radius',Math.sqrt(0) * 100);
    }
  });
  socket.emit('subscribe',{topic:'hytera/#'});
});

</script>
