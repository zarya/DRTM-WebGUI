function strEndsWith(str, suffix) {
    return str.match(suffix+"$")==suffix;
}

function round_float(x,n){
  if(!parseInt(n))
    var n=0;
  if(!parseFloat(x))
    return false;
  return Math.round(x*Math.pow(10,n))/Math.pow(10,n);
}

function createRepeaterGauge(rptName,swr) {
    $('#gaugePower'+rptName).jqxGauge({
        animationDuration: 500,
        width: 50,
        height: 50,
        min: 0,
        max: 50,
        caption: { offset: [0, -25], value: 'pwr', position: 'bottom' },
        labels: { position: 'outside', interval: 25 }
    });

    $('#gaugeRefPower'+rptName).jqxGauge({
        animationDuration: 500,
        width: 150,
        height: 150,
        min: 0,
        max: 10,
        caption: { offset: [0, -25], value: 'Ref pwr', position: 'bottom' },
        labels: { position: 'outside', interval: 5 }
    });
    if (swr) {
        $('#gaugeSwr'+rptName).jqxLinearGauge({
            orientation: 'horizontal',
            width: 500,
            height: 75,
            min: 0,
            max: 5,
            value: 0,
            labels: { interval: 0.5 },
            ticksMajor: { size: '15%', interval: 1, style: { 'stroke-width': 1, stroke: '#aaaaaa'} },
            ticksMinor: { size: '10%', interval: 0.1, style: { 'stroke-width': 1, stroke: '#aaaaaa'} },
            ranges: [
                { startValue: 0, endValue: 1.5, style: { fill: '#FFF157', stroke: '#FFF157'} },
                { startValue: 1.5, endValue: 3, style: { fill: '#FFA200', stroke: '#FFA200'} },
                { startValue: 3, endValue: 5, style: { fill: '#FF4800', stroke: '#FF4800'}}]
        });
    }
}

function createKnob() {
    $(".knob").knob({
        /*change : function (value) {
            //console.log("change : " + value);
        },
        release : function (value) {
            console.log("release : " + value);
        },
        cancel : function () {
            console.log("cancel : " + this.value);
        },*/
        draw : function () {

            // "tron" case
            if(this.$.data('skin') == 'tron') {

                var a = this.angle(this.cv)  // Angle
                    , sa = this.startAngle          // Previous start angle
                    , sat = this.startAngle         // Start angle
                    , ea                            // Previous end angle
                    , eat = sat + a                 // End angle
                    , r = true;

                this.g.lineWidth = this.lineWidth;

                this.o.cursor
                    && (sat = eat - 0.3)
                    && (eat = eat + 0.3);

                if (this.o.displayPrevious) {
                    ea = this.startAngle + this.angle(this.value);
                    this.o.cursor
                        && (sa = ea - 0.3)
                        && (ea = ea + 0.3);
                    this.g.beginPath();
                    this.g.strokeStyle = this.previousColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                    this.g.stroke();
                }

                this.g.beginPath();
                this.g.strokeStyle = r ? this.o.fgColor : this.fgColor ;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                this.g.stroke();

                this.g.lineWidth = 2;
                this.g.beginPath();
                this.g.strokeStyle = this.o.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                this.g.stroke();

                return false;
            }
        }
    });
}

function statsarray(data,value) {
    if (data.length > 50)
        data = data.slice(1);
    data.push(value);
    return data;
}

