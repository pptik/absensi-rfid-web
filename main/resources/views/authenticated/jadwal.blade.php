<!DOCTYPE html>
<html>
<head>
    <title> Absensi</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
    <link href="{{url('/')}}/main/resources/assets/semantic/dist/semantic.css" rel="stylesheet" type="text/css">
    <link href="{{url('/')}}/main/resources/assets/leafletsearch/src/leaflet-search.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{url('/')}}/main/resources/assets/images/absensi.png"/>

    <style>


    </style>
</head>
<body style="height: 100%">


<script type="text/javascript" src="{{url('/')}}/main/resources/assets/semantic/dist/jquery.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/main/resources/assets/semantic/dist/semantic.js"></script>
<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
<script type="text/javascript" src="{{url('/')}}/main/resources/assets/leafletsearch/src/leaflet-search.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3&libraries=places&key=AIzaSyCSGRdkLk-IiiUGIucZP3Vs6FnpCqNJLew"></script>

<link href="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.css" rel="stylesheet" type="text/css" />
<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>
<meta charset="utf-8">
<meta name="_token" content="{{ csrf_token() }}">
<script type="text/javascript">
    $(document).ready(function(){
        var selectInstansi = document.getElementById("selectInstansi");
        var selectKelas = document.getElementById("selectKelas");
        var selectMac = document.getElementById("selectMac");
        var submitButton = document.getElementById("submit");
        var inputNamaMatpel = document.getElementById("namaMatpel");
        function windowSize() {
            windowHeight = window.innerHeight ? window.innerHeight : $(window).height();
            windowWidth = window.innerWidth ? window.innerWidth : $(window).width();
        }
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });
        function removeOptions(selectbox)
        {
            var i;
            for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
            {
                selectbox.remove(i);
            }
        }
        function loaddatajadwal() {
            $.get('<?=url('jadwal/listall')?>',
                    function(data) {
                       loadtabeljadwal(data)
                    }
            );

        }
        loaddatajadwal();
        function loadtabeljadwal(data) {
            $("#jadwaltabel tr").remove();
            var table = document.getElementById("jadwaltabel");
            var thead, tr, td;
            table.appendChild(thead = document.createElement("thead"));
            thead.appendChild(tr = document.createElement("tr"));
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "No";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Nama Instansi";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Kode Ruangan";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Mata Kuliah";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Mulai";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Akhir";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Aksi";
            var count=1;
            var btn=new Array();
            for (var i = 0; i < data.length; i++) {
                tr = document.createElement("tr");
                tr.setAttribute("id", "row" + i);
                if (i%2 == 0)
                {
                    tr.setAttribute("style", "background:white");
                }
                table.appendChild(tr);
                tr.appendChild(td = document.createElement("td"));
                td.innerHTML =count;
                tr.appendChild(td = document.createElement("td"));
                td.innerHTML =data[i].namainstansi;
                tr.appendChild(td = document.createElement("td"));
                td.innerHTML =data[i].koderuangan;
                tr.appendChild(td = document.createElement("td"));
                td.innerHTML =data[i].nama;
                tr.appendChild(td = document.createElement("td"));
                td.innerHTML =data[i].startdate+" | "+data[i].starttime;
                tr.appendChild(td = document.createElement("td"));
                td.innerHTML =data[i].enddate+" |"+data[i].endtime;
                tr.appendChild(td = document.createElement("td"));
                btn[i] = document.createElement('input');
                btn[i].type = "button";
                btn[i].id = "button"+i;
                btn[i].name = "button"+i;
                btn[i].className = "ui red button";
                btn[i].value = "delete";
                btn[i].nama=data[i].nama;
                btn[i].idjadwal=data[i].id;
                btn[i].id_instansi=data[i].idinstansi;
                td.appendChild(btn[i]);
                $("#button"+i+"").click(function () {
                    deleteJadwal($(this).prop("idjadwal"));
                });

                count++;
            };
        }
        function deleteJadwal(jadwalid) {
            $.post('<?=url('jadwal/delete')?>',{ jadwalid:jadwalid},
                function(data) {
                    window.location.reload();
                }
            );
        }
        function loaddatainstansi() {
            $.get('<?=url('instansi/getlist')?>',
                    function(data) {
                        removeOptions(selectInstansi);
                        for (var i = 0; i < data.length; i++) {
                            var opt = data[i].nama;
                            var el = document.createElement("option");
                            el.textContent = opt;
                            el.value =  data[i].idinstansi;
                            selectInstansi.appendChild(el);

                        };
                        getByInstansiDefault(data[0].nama);
                    }
            );

        }
        loaddatainstansi();
        function getByInstansi() {
            namaInstansi=$("#selectInstansi :selected").text();
            $.post('<?=url('ruang/byinstansi')?>',{ namaInstansi: namaInstansi},
                function(data) {
                    removeOptions(selectKelas);
                    for (var i = 0; i < data.length; i++) {
                        var ruang=data[i].ruang;
                        for(var j=0;j<ruang.length;j++){
                            if (ruang[j].Nama!=null||ruang[j].Nama!=undefined){
                                var opt = ruang[j].Nama;
                                var kode = ruang[j].Kode_ruangan;
                                var el = document.createElement("option");
                                el.textContent = opt;
                                el.value = kode;
                                selectKelas.appendChild(el);
                            }
                        }
                    };
                }
            );

        }
        function getByInstansiDefault(namaInstansi) {
            $.post('<?=url('ruang/byinstansi')?>',{ namaInstansi: namaInstansi},
                    function(data) {
                        removeOptions(selectKelas);
                        for (var i = 0; i < data.length; i++) {
                            var ruang=data[i].ruang;
                            for(var j=0;j<ruang.length;j++){
                                if (ruang[j].Nama!=null||ruang[j].Nama!=undefined){
                                    var opt = ruang[j].Nama;
                                    var kode = ruang[j].Kode_ruangan;
                                    var el = document.createElement("option");
                                    el.textContent = opt;
                                    el.value = kode;
                                    selectKelas.appendChild(el);
                                }
                            }
                        };
                    }
            );
        }
        $("#selectInstansi").on("change", getByInstansi);
        $(".openbtn").on("click", function() {
            $(".ui.sidebar").toggleClass("very thin icon");
            $(".asd").toggleClass("marginlefting");
            $(".sidebar z").toggleClass("displaynone");
            $(".ui.accordion").toggleClass("displaynone");
            $(".ui.dropdown.item").toggleClass("displayblock");
            $(".logo").find('img').toggle();
            if(!isMobile) isMobile = true;
            else isMobile = false;

        })
        $(".ui.dropdown").dropdown({
            allowCategorySelection: true,
            transition: "fade up",
            context: 'sidebar',
            on: "hover"
        });

        $('.ui.accordion').accordion({
            selector: {

            }
        });
        $('#rangestart').calendar({
            type: 'time',
            endCalendar: $('#rangeend'),
            onChange: function (time, text) {
                var time = text;
                var hours = Number(time.match(/^(\d+)/)[1]);
                var minutes = Number(time.match(/:(\d+)/)[1]);
                var AMPM = time.match(/\s(.*)$/)[1];
                if (AMPM == "PM" && hours < 12) hours = hours + 12;
                if (AMPM == "AM" && hours == 12) hours = hours - 12;
                var sHours = hours.toString();
                var sMinutes = minutes.toString();
                if (hours < 10) sHours = "0" + sHours;
                if (minutes < 10) sMinutes = "0" + sMinutes;
                jamawal=sHours+":"+sMinutes+":00 GMT+0700"
            },
        });

        $('#rangeend').calendar({
            type: 'time',
            startCalendar: $('#rangestart'),
            onChange: function (time, text) {
                var time = text;
                var hours = Number(time.match(/^(\d+)/)[1]);
                var minutes = Number(time.match(/:(\d+)/)[1]);
                var AMPM = time.match(/\s(.*)$/)[1];
                if (AMPM == "PM" && hours < 12) hours = hours + 12;
                if (AMPM == "AM" && hours == 12) hours = hours - 12;
                var sHours = hours.toString();
                var sMinutes = minutes.toString();
                if (hours < 10) sHours = "0" + sHours;
                if (minutes < 10) sMinutes = "0" + sMinutes;
                jamakhir=sHours+":"+sMinutes+":00 GMT+0700";
                submitButton.disabled=false;
            },
        });
        $('#tanggal').calendar({
            type: 'date',
            onChange: function (date, text) {
                tanggal = text;
            },
        });
        function submitjadwal() {
            if(tanggal==null||jamawal==null||jamakhir==null){

            }else{

                var idInstansi=selectInstansi.options[selectInstansi.selectedIndex].value;
                var kodeRuangan=selectKelas.options[selectKelas.selectedIndex].value;
                var nama=inputNamaMatpel.value;
                var starttime=new Date(tanggal+" "+jamawal).toISOString();
                var endtime=new Date(tanggal+" "+jamakhir).toISOString();
                $.post('<?=url('jadwal/tambah')?>',{ selectInstansi:idInstansi ,namaMatpel:nama,selectRuangan:kodeRuangan, starttime: starttime ,endtime: endtime},
                        function(data) {
                            window.location.reload(true);

                        }
                );

            }




        }
        $("#submit").on("click", submitjadwal);
    });


</script>

<div class="pusher" style="padding-left:5%;padding-right: 5%">
    <div class="ui secondary pointing menu" style="padding: 5px">
        <a class="item" href="{{url('/')}}">Home</a>
        <a class=" item" href="{{url('/instansi')}}">Instansi</a>
        <a class=" item" href="{{url('/ruang')}}">Ruang</a>
        <a class=" item" href="{{url('/scanner')}}" >Scanner</a>
        <a class="active item" href="{{url('/jadwal')}}" >Jadwal</a>
        <div class="right menu">
            <div class="ui dropdown item">
                Pengaturan <i class="dropdown icon"></i>
                <div class="menu">
                    <a class="item">Akun</a>
                    <a href="{{url('user/logout')}}"  class="item">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div  class="ui grid" style="padding: 5%">
    <div id="searchmanual" class="three wide column ui form" >
        <h3>Tambah Jadwal</h3>
        <div class="ui segment">
            <div class="ui grid">
                <div class="sixteen wide column">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>

                        @if (count($errors) > 0)
                            <div class="ui ignored negative message">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if ( Session::has('message') )
                            <div class="ui ignored negative message">
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        <div class="field">
                            <label>Pilih Instansi</label>
                            <select id="selectInstansi" name="selectInstansi">
                            </select>
                        </div>
                        <div class="field">
                            <label>Pilih Kelas</label>
                            <select id="selectKelas" name="selectKelas">
                            </select>
                        </div>
                        <div class="field">
                            <label>Nama Subject</label>
                            <input class="ui input" type="namaMatpel" name="namaMatpel"id="namaMatpel">
                        </div>
                        <label>Pilih Tanggal</label>
                        <div class="ui calendar" id="tanggal">
                            <div class="ui input left icon">
                                <i class="calendar icon"></i>
                                <input type="text" placeholder="Tanggal">
                            </div>
                        </div>
                        <label>Waktu Mulai</label>
                        <div class="ui calendar" id="rangestart">
                            <div class="ui input left icon">
                                <i class="calendar icon"></i>
                                <input type="text" placeholder="Mulai">
                            </div>
                        </div>
                        <label>Waktu Berakhir</label>
                        <div class="ui calendar" id="rangeend">
                            <div class="ui input left icon">
                                <i class="calendar icon"></i>
                                <input type="text" placeholder="Akhir">
                            </div>
                        </div>

                        <button class="ui primary button" id="submit" name="submit" disabled>Submit</button>


                </div>

            </div>
        </div>
    </div>
    <div class="thirteen wide column" >
        <table class="ui celled padded table" id="jadwaltabel">

        </table>

    </div>
</div>






</div>
</body>
</html>


