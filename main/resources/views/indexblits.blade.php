@extends('templates.template')
@section('body')
    <div class="ui right sidebar inverted vertical menu" style="background: white">
        <div class="ui bulleted list">
            <div class="item">
                <h2 style="color: black">Map Selector</h2>
                <div class="list">
                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="cctv_v" id="cctv_v" onclick="onclick_cctv_video()" checked="true">
                            <label>CCTV</label>
                        </div>
                    </div>
                    <br>
                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox"  name="tracer" id="tracer" onclick="onclick_gps()" checked="true" >
                            <label>BRT Tracer</label>
                        </div>
                    </div>
                    <br>
                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox"  name="socialreport" id="socialreport" onclick="onclick_socialreport()">
                            <label>Social Report</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ui inverted vertical footer segment">
            <div class="ui container" style="margin-left: 5px">
                <div class="field" style="margin-left: 2px">
                    Supported by
                </div>
                <div class="list" style="margin-left: 7px">
                    <div class="field">
                        PPTIK ITB
                    </div>
                    <div class="field">
                        Universitas Bandar Lampung
                    </div>
                    <div class="field">
                       Dinas Perhubungan Kota Bandar Lampung
                    </div>
                    <div class="field">
                        Balitbangnovda Lampung
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="pusher" style="height: 100%">
        <div class="ui container" style="width: 100% ;height: 100%">
            <div class="ui secondary pointing menu" style="padding: 5px" >
                <img class="ui image" src="{{url('/')}}/main/resources/assets/images/blitss.png" style="height: 100px">



                <div class="right menu">

                    <img class="ui  image" src="{{url('/')}}/main/resources/assets/images/logobandarlampung.png">
                    <img class="ui  image" src="{{url('/')}}/main/resources/assets/images/logopptik.png">
                    <img class="ui  image" src="{{url('/')}}/main/resources/assets/images/logoitb.png">
                    <img class="ui  image" src="{{url('/')}}/main/resources/assets/images/logoubl.png">
                </div>
            </div>



                <div id="mymap" style="height: 82%; width: 100%">

                </div>
                @section('js')

                    var map = L.map('mymap').setView([-5.398449,105.266519], 13);
                    var cctvLayer = L.layerGroup();
                    var gpstracersLayer = L.layerGroup();
                    var reportLayer = L.layerGroup();
                    var cameraIcon = L.icon({
                    iconUrl: "{{url('/')}}/main/resources/assets/images/camera.png",

                    iconSize:     [28, 44], // size of the icon
                    iconAnchor:   [14, 43], // point of the icon which will correspond to marker's location
                    popupAnchor:  [0, -43] // point from which the popup should open relative to the iconAnchor
                    });

                    var nocameraIcon = L.icon({
                    iconUrl: "{{url('/')}}/main/resources/assets/images/camerared.png",

                    iconSize:     [28, 44], // size of the icon
                    iconAnchor:   [14, 43], // point of the icon which will correspond to marker's location
                    popupAnchor:  [0, -43] // point from which the popup should open relative to the iconAnchor
                    });


                    var tracerIcon = L.icon({
                    iconUrl: "{{url('/')}}/main/resources/assets/images/tracer.png",

                    iconSize:     [28, 44], // size of the icon
                    iconAnchor:   [14, 43], // point of the icon which will correspond to marker's location
                    popupAnchor:  [0, -43] // point from which the popup should open relative to the iconAnchor
                    });

                    L.tileLayer('http://api.tiles.mapbox.com/v4/mapbox.streets/{z}/{x}/{y}.png?access_token=pk.eyJ1Ijoic3J1cGllZWUiLCJhIjoib05wWVBWTSJ9.RqbymEhEdLg2eDuVr6oPZg', {
                    maxZoom: 18,
                    id: 'your.mapbox.project.id',
                    accessToken: 'your.mapbox.public.access.token'
                    }).addTo(map);

                    function click_location_bandarlampung() {
                    map.setView([-5.398449,105.266519], 13);
                    }
                    function onclick_map_setting() {
                    $('.ui.sidebar')
                    .sidebar('toggle')
                    ;
                    }


                    function onclick_cctv_video() {
                    cctvLayer.clearLayers();
                    $.get('<?=url('maps/get_cctv')?>', function(cctv) {
                    cctv = $.parseJSON(cctv);
                    if($('#cctv_v').is(":checked")){
                    for(i=0;i<cctv.length;i++){
                        if(cctv[i].isexist){
                        cctvmarker = new L.marker([cctv[i].Latitude,cctv[i].Longitude], {icon: cameraIcon});
                        cctvLayer.addLayer(cctvmarker);
                        cctvmarker.bindPopup('<video width="320" height="240" autoplay controls><source src="'+ cctv[i].Video +'" type="video/mp4">Your browser does not support the video tag.</video>',{maxWidth: 400});

                        }else{
                        cctvmarker = new L.marker([cctv[i].Latitude,cctv[i].Longitude], {icon: nocameraIcon});
                        cctvLayer.addLayer(cctvmarker);
                        cctvmarker.bindPopup('<video width="320" height="240" autoplay controls><source src="'+ cctv[i].Video +'" type="video/mp4">Your browser does not support the video tag.</video>',{maxWidth: 400});
                        }

                    }
                    cctvLayer.addTo(map);
                    }

                    });
                    }
                    onclick_cctv_video();

                    function onclick_gps() {
                    gpstracersLayer.clearLayers();
                    $.get('<?=url('maps/get_gpstracer')?>', function(gpstr) {
                    gpstr = $.parseJSON(gpstr);
                    if($('#tracer').is(":checked")){
                    for(i=0;i<gpstr.length;i++){
                    gpstracersmarker = new L.marker([gpstr[i].Latitude,gpstr[i].Longitude], {icon: tracerIcon});
                    gpstracersLayer.addLayer(gpstracersmarker);
                    gpstracersmarker.bindPopup(gpstr[i].Lokasi+'<br>'+gpstr[i].Keterangan);
                    }
                    gpstracersLayer.addTo(map);
                    }
                    });
                    setInterval(function(){
                    gpstracersLayer.clearLayers();
                    $.get('<?=url('maps/get_gpstracer')?>', function(gpstr) {
                    gpstr = $.parseJSON(gpstr);
                    if($('#tracer').is(":checked")){
                    for(i=0;i<gpstr.length;i++){
                    gpstracersmarker = new L.marker([gpstr[i].Latitude,gpstr[i].Longitude], {icon: tracerIcon});
                    gpstracersLayer.addLayer(gpstracersmarker);
                    gpstracersmarker.bindPopup(gpstr[i].Lokasi+'<br>'+gpstr[i].Keterangan);
                    }
                    gpstracersLayer.addTo(map);
                    }
                    });
                    },10000);

                    }
                    onclick_gps();

                var legend = L.control({position: 'bottomleft'});
                var semutweb='http://bsts.lskk.ee.itb.ac.id';
                legend.onAdd = function (map) {

                var div = L.DomUtil.create('div', 'info legend');

                // loop through our density intervals and generate a label with a colored square for each interva
                div.innerHTML +='<img src="{{url('/')}}/main/resources/assets/images/logo_large.png"  onclick="window.open(semutweb)" height="50" width="50" >';

                return div;
                };

                legend.addTo(map);

                var GooglePlacesSearchBox = L.Control.extend({position: 'bottomleft',
                onAdd: function() {
                var element = document.createElement("input");
                element.id = "searchBox";
                element.style.width = "250px";
                element.style.margin = "20px";
                return element;
                }
                });
                (new GooglePlacesSearchBox).addTo(map);

                var input = document.getElementById("searchBox");
                var searchBox = new google.maps.places.SearchBox(input);

                searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                return;
                }

                var group = L.featureGroup();

                places.forEach(function(place) {

                // Create a marker for each place.
                var marker = L.marker([
                place.geometry.location.lat(),
                place.geometry.location.lng()
                ]);
                group.addLayer(marker);
                });

                group.addTo(map);
                map.fitBounds(group.getBounds());

                });

                var button = L.control({position: 'bottomright'});
                button.onAdd = function (map) {

                var div = L.DomUtil.create('div', 'info legend');
                div.innerHTML +=' <a class="ui item" onclick="click_location_bandarlampung()"><div class="ui button" style="background-color: rgba(0, 0, 0, 0.1);color: orangered;font-weight: lighter;"><i class="location arrow icon"></i>Bandar Lampung</div></a>';
                div.innerHTML +=' <a class="ui item" onclick="onclick_map_setting()"><div class="ui button" style="background-color: rgba(0, 0, 0, 0.1);color: orangered;font-weight: lighter;"><i class="setting icon"></i>Edit Map</div></a>';



                return div;
                };

                button.addTo(map);
                var trafficIcon = L.icon({
                iconUrl: "{{url('/')}}/main/resources/assets/images/traffic.png",

                iconSize:     [28, 44], // size of the icon
                iconAnchor:   [14, 43], // point of the icon which will correspond to marker's location
                popupAnchor:  [0, -43] // point from which the popup should open relative to the iconAnchor
                });
                var policeIcon = L.icon({
                iconUrl: "{{url('/')}}/main/resources/assets/images/police.png",

                iconSize:     [28, 44], // size of the icon
                iconAnchor:   [14, 43], // point of the icon which will correspond to marker's location
                popupAnchor:  [0, -43] // point from which the popup should open relative to the iconAnchor
                });
                var accidentIcon = L.icon({
                iconUrl: "{{url('/')}}/main/resources/assets/images/accident.png",

                iconSize:     [28, 44], // size of the icon
                iconAnchor:   [14, 43], // point of the icon which will correspond to marker's location
                popupAnchor:  [0, -43] // point from which the popup should open relative to the iconAnchor
                });
                var disasterIcon = L.icon({
                iconUrl: "{{url('/')}}/main/resources/assets/images/disaster.png",

                iconSize:     [28, 44], // size of the icon
                iconAnchor:   [14, 43], // point of the icon which will correspond to marker's location
                popupAnchor:  [0, -43] // point from which the popup should open relative to the iconAnchor
                });
                var closureIcon = L.icon({
                iconUrl: "{{url('/')}}/main/resources/assets/images/closure.png",

                iconSize:     [28, 44], // size of the icon
                iconAnchor:   [14, 43], // point of the icon which will correspond to marker's location
                popupAnchor:  [0, -43] // point from which the popup should open relative to the iconAnchor
                });
                var otherIcon = L.icon({
                iconUrl: "{{url('/')}}/main/resources/assets/images/other.png",

                iconSize:     [28, 44], // size of the icon
                iconAnchor:   [14, 43], // point of the icon which will correspond to marker's location
                popupAnchor:  [0, -43] // point from which the popup should open relative to the iconAnchor
                });


                function onclick_socialreport() {
                reportLayer.clearLayers();
                var reportIcon;
                $.get('<?=url('maps/get_socialreport')?>', function(reports) {
                reports = $.parseJSON(reports);
                if($('#socialreport').is(":checked")){
                for(i=0;i<reports.length;i++){
                if (reports[i].parenttype == 1 || reports[i].parenttype == 2 || reports[i].parenttype == 3) {
                reportIcon = trafficIcon;
                } else if (reports[i].parenttype == 4 || reports[i].parenttype == 5) {
                reportIcon = policeIcon;
                } else if (reports[i].parenttype == 6 || reports[i].parenttype == 7 || reports[i].parenttype == 8) {
                reportIcon = accidentIcon;
                } else if (reports[i].parenttype == 9 || reports[i].parenttype == 10) {
                reportIcon = disasterIcon;
                } else if (reports[i].parenttype == 11 || reports[i].parenttype == 12 || reports[i].parenttype == 13 || reports[i].parenttype == 14 ||reports[i].parenttype == 15) {
                reportIcon = closureIcon;
                } else if (reports[i].parenttype == 16 || reports[i].parenttype == 17 || reports[i].parenttype == 18 || reports[i].parenttype == 19){
                reportIcon = otherIcon;
                };
                reportsmarker = new L.marker([reports[i].lat,reports[i].lon], {icon: reportIcon});
                reportLayer.addLayer(reportsmarker);
                reportsmarker.bindPopup(reports[i].type+' | '+ reports[i].description +'<br>  By: '+reports[i].reporter);
                }
                reportLayer.addTo(map);
                }

                });
                }
            @endsection


        </div>
    </div>



@endsection
