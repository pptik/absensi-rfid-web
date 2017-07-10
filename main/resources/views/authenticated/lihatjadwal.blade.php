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
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });
        var inputKodeJadwal = document.getElementById("kodeJadwal");

        function searchbyinputtext() {
            var kodeJadwal=inputKodeJadwal.value;
            $.post('<?=url('jadwal/listbykode')?>',{ kodeJadwal:kodeJadwal},
                function(data) {
                    loadtabeljadwal(data)
                }
            );
        }
        function loadtabeljadwal(data) {
            $("#jadwaltabel tr").remove();
            var table = document.getElementById("jadwaltabel");
            var thead, tr, td;
            table.appendChild(thead = document.createElement("thead"));
            thead.appendChild(tr = document.createElement("tr"));
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "No";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Kode Jadwal";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Jumlah Peserta";
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
                td.innerHTML =data[i].Kode_jadwal;
                tr.appendChild(td = document.createElement("td"));
                td.innerHTML =data[i].totalabsen;
                tr.appendChild(td = document.createElement("td"));
                btn[i] = document.createElement('input');
                btn[i].type = "button";
                btn[i].id = "button"+i;
                btn[i].name = "button"+i;
                btn[i].className = "ui green button";
                btn[i].value = "Lihat Detail";
                btn[i].kode=data[i].Kode_jadwal;
                td.appendChild(btn[i]);
                $("#button"+i+"").click(function () {
                    detailJadwal($(this).prop("kode"));
                });

                count++;
            };
        }
        $("#submit1").on("click", searchbyinputtext);

        function detailJadwal(kodeJadwal) {

        }
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
        <h3>Tambah Ruang</h3>
        <div class="ui segment">
            <div class="ui grid">
                <div class="sixteen wide column" id="searchbytext">
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
                        <label>Kode Jadwal</label>
                        <input class="ui input" type="kodeJadwal" name="kodeJadwal"id="kodeJadwal">
                    </div>
                    <button class="ui primary button" id="submit1" name="submit1">Submit</button>
                </div>

            </div>
        </div>
    </div>
    <div class="thirteen wide column" >
        <div >
            <h1>Detail Jadwal</h1>
        </div>
        <table class="ui celled padded table" id="jadwaltabel">

        </table>

    </div>
</div>






</div>
</body>
</html>


