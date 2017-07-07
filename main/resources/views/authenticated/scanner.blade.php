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
        function loaddatascanner() {
            $.get('<?=url('scanner/getlist')?>',
                    function(data) {
                       loadtabelscanner(data,1);
                    }
            );

        }
        loaddatascanner();
        function loaddatainstansi() {
            $.get('<?=url('instansi/getlist')?>',
                    function(data) {
                        removeOptions(selectInstansi);
                        for (var i = 0; i < data.length; i++) {
                            var opt = data[i].nama;
                            var el = document.createElement("option");
                            el.textContent = opt;
                            el.value = opt;
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
            getlistmacbystatus()
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
            getlistmacbystatus();
        }
        $("#selectInstansi").on("change", getByInstansi);
        function getlistmacbystatus() {
            $.post('<?=url('absensi/get_listmacbystatus')?>',{ status: false},
                    function(data) {
                        removeOptions(selectMac);
                        if (data.length==0){
                            var opt = "No Free Device";
                            var el = document.createElement("option");
                            el.textContent = opt;
                            el.value = opt;
                            selectMac.appendChild(el);

                        }else {
                            for (var i = 0; i < data.length; i++) {
                                var opt = data[i].mac;
                                var el = document.createElement("option");
                                el.textContent = opt;
                                el.value = opt;
                                selectMac.appendChild(el);
                            };
                            submitButton.disabled=false;
                        }
                    }
            );
        }
        $("#selectKelas").on("change", getlistmacbystatus);
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

        function loadtabelscanner(data,x) {

            $("#scannertabel tr").remove();
            var table = document.getElementById("scannertabel");
            var thead, tr, td;
            table.appendChild(thead = document.createElement("thead"));
            thead.appendChild(tr = document.createElement("tr"));
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "No";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Nama Instansi";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Nama Kelas";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Kode Kelas";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Scanner";
            tr.appendChild(td = document.createElement("td"));
            td.innerHTML = "Aksi";
            var count=1;
            var btn=new Array();
            var countBtn=0;
            for (var i = 0; i < data.length; i++) {
                var ruang=data[i].ruanganlist;
                for(var j=0;j<ruang.length;j++){
                    countBtn++
                    if (ruang[j].Nama_ruangan!=null||ruang[j].Nama_ruangan!=undefined){
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
                        td.innerHTML =data[i].nama;
                        tr.appendChild(td = document.createElement("td"));
                        td.innerHTML =ruang[j].Nama_ruangan;
                        tr.appendChild(td = document.createElement("td"));
                        td.innerHTML =ruang[j].Kode_ruangan ;
                        tr.appendChild(td = document.createElement("td"));
                        td.innerHTML =ruang[j].mac ;
                        tr.appendChild(td = document.createElement("td"));
                        btn[countBtn] = document.createElement('input');
                        btn[countBtn].type = "button";
                        btn[countBtn].id = "button"+countBtn;
                        btn[countBtn].name = "button"+countBtn;
                        btn[countBtn].className = "ui red button";
                        btn[countBtn].value = "Remove Scanner";
                        btn[countBtn].nama=data[i].nama;
                        btn[countBtn].namaruangan=ruang[j].Nama;
                        btn[countBtn].koderuangan=ruang[j].Kode_ruangan;
                        btn[countBtn].macID=ruang[j].mac;
                        td.appendChild(btn[countBtn]);
                        $("#button"+countBtn+"").click(function () {
                           removeScannerFromRuang($(this).prop("macID"));
                        });
                        count++;
                    }
                }
            };

        }
        function removeScannerFromRuang(macid) {
            $.post('<?=url('scanner/remove')?>',{ macID:macid},
                function(data) {
                    window.location.reload();
                }
            );
        };
    });


</script>

<div class="pusher" style="padding-left:5%;padding-right: 5%">
    <div class="ui secondary pointing menu" style="padding: 5px">
        <a class="item" href="{{url('/')}}">Home</a>
        <a class=" item" href="{{url('/instansi')}}">Instansi</a>
        <a class=" item" href="{{url('/ruang')}}">Ruang</a>
        <a class="active item" href="{{url('/scanner')}}" >Scanner</a>
        <a class=" item" href="{{url('/jadwal')}}" >Jadwal</a>
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
                <div class="sixteen wide column">
                    <form class="ui form" method="post" action="{{url('scanner/tambah')}}">
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
                            <label>Pilih Device Mac</label>
                            <select id="selectMac" name="selectMac">
                            </select>
                        </div>


                        <button class="ui button" type="submit" id="submit" name="submit" disabled>Submit</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <div class="thirteen wide column" >
        <table class="ui celled padded table" id="scannertabel">

        </table>

    </div>
</div>






</div>
</body>
</html>


