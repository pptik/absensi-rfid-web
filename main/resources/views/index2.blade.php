@extends('templates.template')
@section('title')
    Selamat datang
@endsection
@section('css')
    hr{
    border: solid 0.1px #D4D4D5 !important;
    height: 0.1px !important;
    opacity: 0.2 !important;
    }
    #map {
    height: 400px;
    width: 100%;
    }
    #panic-detail-waktu{
    color: #666666;
    opacity: 0.5;
    }
@endsection
@section('body')

    <div class="ui container">
        <div class="ui secondary pointing menu">
            <a class="active item" href="{{url('/')}}">
                <img src="{{url('/')}}/main/resources/assets/images/nelayan.png">
                {{--<h4>IDUN NELAYAN</h4>--}}
            </a>

            <div class="right menu">
                @section('jquery')
                    $('.button')
                    .popup({
                    inline: true,
                    hoverable  : true
                    })
                    ;
            @endsection
            <!--<a class="ui item button" data-tooltip="Add users to your feed" data-position="bottom right">
                    <i class="alarm outline circular icon link"></i>
                    Panic
                </a>-->

                <a class="ui item">
                    <div class="ui button" style="background-color: orangered;color: white;font-weight: lighter;">
                        <i class="alarm outline icon"></i>
                        Panic
                    </div>
                    <div class="ui special popup">
                        <div class="ui grid">
                            <div class="sixteen wide column" style="font-size: smaller;">
                                <?php
                                foreach ($panic as $panic) {
                                    echo $panic->username . "<br/><span id='panic-detail-waktu'>" . $panic->detail_waktu . "</span><hr/>";
                                    ?>
<?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </a>

            </div>
        </div>
        <div class="ui segment">
            <div id="map">

            </div>
            @section('js')
                var markerCuaca = {!! $markerCuaca !!}
                var markerKeadaanLaut = {!! $markerKeadaanLaut !!}
                var markerKejahatan = {!! $markerKejahatan !!}
                var markerTangkapan= {!! $markerTangkapan !!}
                var markerPanic = {!! $markerPanic !!}

                console.log("Banyak marker panic: "+ markerPanic.length);
                console.log("Lokasi panic: "+ JSON.stringify(markerPanic));



                var markerCuacaFin = [];
                var markerKeadaanLautFin = [];
                var markerKejahatanFin = [];
                var markerTangkapanFin = [];
                var markerPanicFin = [];



                for(var i=0; i < markerPanic.length;i++){
                    markerPanicFin.push(new Array());
                    markerPanicFin[i].push("Keterangan",markerPanic[i].latitude,markerPanic[i].longitude,1);

                    /*markerPanicFin.push("Keterangan",markerPanic[i].latitude,markerPanic[i].longitude,1);
                    markerPanicFin.concat(markerPanic[i].latitude);
                    markerPanicFin.concat(markerPanic[i].longitude);
                    markerPanicFin.concat(1);*/
                }

                for(var i=0; i < markerCuaca.length;i++){
                markerCuacaFin.push(new Array());
                markerCuacaFin[i].push("Keterangan",markerCuaca[i].latitude,markerCuaca[i].longitude,1);
                }

                for(var i=0; i < markerKeadaanLaut.length;i++){
                markerKeadaanLautFin.push(new Array());
                markerKeadaanLautFin[i].push("Keterangan",markerKeadaanLaut[i].latitude,markerKeadaanLaut[i].longitude,1);
                }

                for(var i=0; i < markerKejahatan.length;i++){
                markerKejahatanFin.push(new Array());
                markerKejahatanFin[i].push("Keterangan",markerKejahatan[i].latitude,markerKejahatan[i].longitude,1);
                }

                for(var i=0; i < markerTangkapan.length;i++){
                markerTangkapanFin.push(new Array());
                markerTangkapanFin[i].push("Keterangan",markerTangkapan[i].latitude,markerTangkapan[i].longitude,1);
                }

                //alert("Isinya "+markerPanicFin);
                //alert("Panjangnya "+markerPanicFin.length);





                var locations = [
                ['Bondi Beach', -6.4925083, 107.61, 4],
                ['Coogee Beach', -33.923036, 151.259052, 5],
                ['Cronulla Beach', -34.028249, 151.157507, 3],
                ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
                ['Maroubra Beach', -33.950198, 151.259302, 1]
                ];


                //alert("Contoh Isi: "+locations);
                //alert("Contoh Pangjangya: "+locations.length);

                //var weather_locations = [['Bondi Beach', -6.4925083, 107.61, 4],['Pangandaran', -7.6150611, 108.4988269, 4]];
                var weather_locations = markerCuacaFin;

                //var seaCondition_locations = [['Coogee Beach', -33.923036, 151.259052, 5]];
                var seaCondition_locations = markerKeadaanLautFin;

                //var crime_locations = [['Cronulla Beach', -34.028249, 151.157507, 3]];
                var crime_locations = markerKejahatanFin;

                //var fish_locations = [['Bali', -8.4095178, 115.188916, 2],['Makassar', -5.1476651, 119.4327314, 2]];
                var fish_locations = markerTangkapanFin;

                //var panic_locations = [['Nusa Tenggara Timur', -8.6573819, 121.0793705, 2],['Indramayu', -6.33731, 108.3258329, 2]];

                var panic_locations = markerPanicFin;

                function initMap() {

                var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: new google.maps.LatLng(-6.4925083, 107.61),
                mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var infowindow = new google.maps.InfoWindow();

                var infowindow_weather = new google.maps.InfoWindow();

                var infowindow_seaCondition = new google.maps.InfoWindow();

                var infowindow_crime = new google.maps.InfoWindow();

                var infowindow_fish = new google.maps.InfoWindow();

                var infowindow_panic = new google.maps.InfoWindow();

                var marker, i;

                /*for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map
                });

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
                }
                })(marker, i));
                }*/

                var marker_weather, i;

                for (i = 0; i < weather_locations.length; i++) {
                marker_weather = new google.maps.Marker({
                position: new google.maps.LatLng(weather_locations[i][1], weather_locations[i][2]),
                map: map
                });

                marker_weather.setIcon('{{url('/')}}/main/resources/assets/images/markers/weather-marker.png');

                google.maps.event.addListener(marker_weather, 'click', (function(marker_weather, i) {
                return function() {
                infowindow_weather.setContent(weather_locations[i][0]);
                infowindow_weather.open(map, marker_weather);
                }
                })(marker_weather, i));
                }

                var marker_seaCondition, i;

                for (i = 0; i < seaCondition_locations.length; i++) {
                marker_seaCondition = new google.maps.Marker({
                position: new google.maps.LatLng(seaCondition_locations[i][1], seaCondition_locations[i][2]),
                map: map
                });

                marker_seaCondition.setIcon('{{url('/')}}/main/resources/assets/images/markers/keadaan-laut-marker.png');

                google.maps.event.addListener(marker_seaCondition, 'click', (function(marker_seaCondition, i) {
                return function() {
                infowindow_seaCondition.setContent(seaCondition_locations[i][0]);
                infowindow_seaCondition.open(map, marker_seaCondition);
                }
                })(marker_seaCondition, i));
                }

                var marker_crime, i;

                for (i = 0; i < crime_locations.length; i++) {
                marker_crime = new google.maps.Marker({
                position: new google.maps.LatLng(crime_locations[i][1], crime_locations[i][2]),
                map: map
                });

                marker_crime.setIcon('{{url('/')}}/main/resources/assets/images/markers/criminal-marker.png');

                google.maps.event.addListener(marker_crime, 'click', (function(marker_crime, i) {
                return function() {
                infowindow_crime.setContent(crime_locations[i][0]);
                infowindow_crime.open(map, marker_crime);
                }
                })(marker_crime, i));
                }

                var marker_tangkapan, i;

                for (i = 0; i < fish_locations.length; i++) {
                marker_tangkapan = new google.maps.Marker({
                position: new google.maps.LatLng(fish_locations[i][1], fish_locations[i][2]),
                map: map
                });

                marker_tangkapan.setIcon('{{url('/')}}/main/resources/assets/images/markers/fish-marker.png');

                google.maps.event.addListener(marker_weather, 'click', (function(marker_tangkapan, i) {
                return function() {
                infowindow_fish.setContent(fish_locations[i][0]);
                infowindow_fish.open(map, marker_tangkapan);
                }
                })(marker_tangkapan, i));
                }

                var marker_panic, i;

                for (i = 0; i < panic_locations.length; i++) {
                marker_panic = new google.maps.Marker({
                position: new google.maps.LatLng(panic_locations[i][1], panic_locations[i][2]),
                map: map
                });

                marker_panic.setIcon('{{url('/')}}/main/resources/assets/images/markers/panic-marker.png');

                google.maps.event.addListener(marker_panic, 'click', (function(marker_panic, i) {
                return function() {
                infowindow_weather.setContent(panic_locations[i][0]);
                infowindow_weather.open(map, marker_panic);
                }
                })(marker_panic, i));
                }

                }
            @endsection
        </div>
        <div class="ui grid">
            <div class="four wide column">
                <div class="ui card">
                    <div class="content">
                        <div class="header">
                            <div class="ui grid">
                                <div class="twelve wide column">
                                    Cuaca
                                </div>
                                <div class="four wide column" style="padding-top: 0.5em;">
                                    <i class="square icon big" style="color: #00B5AD;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <?php
                        foreach ($cuaca as $cuaca){?>
                        <div class="ui grid">
                            <div class="four wide column">
                                <img src="<?php echo $cuaca->foto_source;?>"
                                     class="ui small image"/>
                            </div>
                            <div class="twelve wide column">
                                <span style="font-weight: bold;"><?php echo $cuaca->username;?></span>
                                <br/>
                                <span><?php echo $cuaca->jenis_cuaca;?></span>
                                <br/>
                                <span style="font-size: smaller"><?php echo $cuaca->keterangan;?></span>
                                <br/>
                                <span style="color: #666666;opacity: 0.5;font-size: smaller;"><?php echo $cuaca->detail_waktu;?></span>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="four wide column">
                <div class="ui card">
                    <div class="content">
                        <div class="header">
                            <div class="ui grid">
                                <div class="twelve wide column">
                                    Keadaan Laut
                                </div>
                                <div class="four wide column" style="padding-top: 0.5em;">
                                    <i class="square icon big" style="color: #F89406;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <?php
                        foreach ($keadaan_laut as $keadaan_laut){?>
                        <div class="ui grid">
                            <div class="four wide column">
                                <img src="<?php echo $keadaan_laut->foto_source;?>"
                                     class="ui small image"/>
                            </div>
                            <div class="twelve wide column">
                                <span style="font-weight: bold;"><?php echo $keadaan_laut->username;?></span>
                                <br/>
                                <span><?php echo $keadaan_laut->jenis_ombak;?></span>
                                <br/>
                                <span style="font-size: smaller"><?php echo $keadaan_laut->keterangan;?></span>
                                <br/>
                                <span style="color: #666666;opacity: 0.5;font-size: smaller;"><?php echo $keadaan_laut->detail_waktu;?></span>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="four wide column">
                <div class="ui card">
                    <div class="content">
                        <div class="header">
                            <div class="ui grid">
                                <div class="twelve wide column">
                                    Kejahatan
                                </div>
                                <div class="four wide column" style="padding-top: 0.5em;">
                                    <i class="square icon big" style="color: #BF55EC;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <?php
                        foreach ($kejahatan as $kejahatan){?>
                        <div class="ui grid">
                            <div class="four wide column">
                                <img src="<?php echo $kejahatan->foto_source;?>"
                                     class="ui small image"/>
                            </div>
                            <div class="twelve wide column">
                                <span style="font-weight: bold;"><?php echo $kejahatan->username;?></span>
                                <br/>
                                <span style="font-size: smaller"><?php echo $kejahatan->keterangan;?></span>
                                <br/>
                                <span style="color: #666666;opacity: 0.5;font-size: smaller;"><?php echo $kejahatan->detail_waktu;?></span>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="four wide column">
                <div class="ui card">
                    <div class="content">
                        <div class="header">
                            <div class="ui grid">
                                <div class="twelve wide column">
                                    Detail Tangkapan
                                </div>
                                <div class="four wide column" style="padding-top: 0.5em;">
                                    <i class="square icon big" style="color: #87D37C;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <?php
                        foreach ($tangkapan as $tangkapan){?>
                        <div class="ui grid">
                            <div class="four wide column">
                                <img src="<?php echo $tangkapan->foto_source;?>"
                                     class="ui small image"/>
                            </div>
                            <div class="twelve wide column">
                                <span style="font-weight: bold;"><?php echo $tangkapan->username;?></span>
                                <br/>
                                <span style="font-size: smaller"><?php echo $tangkapan->keterangan;?></span>
                                <br/>
                                <span style="color: #666666;opacity: 0.5;font-size: smaller;"><?php echo $tangkapan->detail_waktu;?></span>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
