<h4>Sourcecode</h4>
<a href="https://github.com/zarya/DRTM-WebGUI">Webinterface<a><br>
<a href="https://github.com/zarya/DRTM-Backend">Backend</a><br>
<a href="https://github.com/zarya/DRTM-Pusher">Pusher</a><br>

<h4>Internals</h4>
<img src="img/dmr_realtime_diagram.png"><br>
* pytrap.py Takes care of receiving the snmp traps from the repeaters<br>
* pyget.py Get the RSSI of the repeaters<br>
* pydmruser.py Get the last user from the userlog page<br>
* MQTT is a pice of software called <a href="http://mosquitto.org/">Mosquitto</a><br>
* The webserver is used to serve the static contend php is used to generate the page<br>
* pusher.js is the daemon that takes care of sending the data to the webbrowser<br>
<hr>
<h4>Repeater dialog</h4>
<img src="img/repeater_display.png"><br>
* The outside ring is for Forward power <i class="fa fa-sort-up"></i><br>
* The inside ring is for Reflected power <i class="fa fa-sort-down"></i><br>
<hr>
<h4>Map</h4>
* Green: TS1<br>
* Blue: TS2<br>
* Size of the circle RSSI<br>

