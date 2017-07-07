@extends('templates.template')
@section('body')



    <div class="ui container" style="width: 100% ;height: 100%;padding-left:5%;padding-right: 5% ">
        <div class="ui secondary pointing menu" style="padding: 5px" >

            <a class="active item" href="{{url('/')}}">Home</a>
            <a class=" item" href="{{url('/instansi')}}">Instansi</a>
            <a class=" item" href="{{url('/ruang')}}">Ruang</a>
            <a class=" item" href="{{url('/scanner')}}" >Scanner</a>
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
        <a class=" item" href="{{url('/absen/jadwal')}}">Lihat Berdasarkan Jadwal</a>
        <div id="containermac" name="containermac" class="ui form">
            <label>Device</label>
        </div>
        <br>
        <div style="margin-bottom: 10px">
            <label>Filter Pencarian</label><br>
            <button class="ui primary basic button" onclick="onclick_manual()" >Manual</button>
            <button class="ui secondary basic button" onclick="onclick_perjam()">Per jam</button>

        </div>



        <div  class="ui     grid" >
            <div id="searchmanual" class="three wide column ui form" >

                <label>Pilih Tanggal</label>
                <div class="ui calendar" id="example2">
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

                <input type="hidden" name="_token" value="{{ csrf_token() }}">


                <a class="ui item">
                    <div class="ui button right" onclick="onclick_search()" style="background-color: palegreen;color: black;font-weight: lighter;">
                        Search
                        <i class="search icon"></i>
                    </div>
                </a>

            </div>
            <div id="searchperjam" class="three wide column" style="display: none">
                <td>
                    <label>Pilih Tanggal</label>
                    <div class="ui calendar" id="example3">
                        <div class="ui input left icon">
                            <i class="calendar icon"></i>
                            <input type="text" placeholder="Tanggal">
                        </div>
                    </div>
                    <br>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(05,06)" style="background:none;color: black;font-weight: lighter;">
                            05.00-06.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(06,07)" style="background:none;color: black;font-weight: lighter;">
                            06.00-07.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(07,08)" style="background:none;color: black;font-weight: lighter;">
                            07.00-08.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(08,09)" style="background:none;color: black;font-weight: lighter;">
                            08.00-09.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(09,10)" style="background:none;color: black;font-weight: lighter;">
                            09.00-10.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(10,11)" style="background:none;color: black;font-weight: lighter;">
                            10.00-11.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(11,12)" style="background:none;color: black;font-weight: lighter;">
                            11.00-12.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(12,13)" style="background:none;color: black;font-weight: lighter;">
                            12.00-13.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(13,14)" style="background:none;color: black;font-weight: lighter;">
                            13.00-14.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(14,15)" style="background:none;color: black;font-weight: lighter;">
                            14.00-15.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(15,16)" style="background:none;color: black;font-weight: lighter;">
                            15.00-16.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(16,17)" style="background:none;color: black;font-weight: lighter;">
                            16.00-17.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(17,18)" style="background:none;color: black;font-weight: lighter;">
                            17.00-18.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(18,19)" style="background:none;color: black;font-weight: lighter;">
                            18.00-19.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(19,20)" style="background:none;color: black;font-weight: lighter;">
                            19.00-20.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(20,21)" style="background:none;color: black;font-weight: lighter;">
                            20.00-21.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(21,22)" style="background:none;color: black;font-weight: lighter;">
                            21.00-22.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>
                <td>
                    <a class="ui item">
                        <div class="ui button right" onclick="searchByDefaultJam(22,23)" style="background:none;color: black;font-weight: lighter;">
                            22.00-23.00 &nbsp;
                            <i class="time icon"></i>
                        </div>
                    </a>
                </td>


            </div>
            <div class="thirteen wide column" style="padding-top: 3ch">
                <table class="ui celled padded table" id="absensitabel">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>RFID</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                    </thead>
                    <tbody id="absensitabelbody">

                    </tbody>
                </table>
                <iframe id="txtArea1" style="display:none"></iframe>
                <button id="btnExport" class="ui primary button" onclick="fnExcelReport();"> EXPORT </button>
            </div>
        </div>

        @section('js')


            $(function() {
            $.ajaxSetup({
            headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
            });
            });

            var tanggal ;
            var tanggal2 ;
            var jamawal ;
            var jamakhir ;
            var deviceid;
            var deviceidawal;


            function onclick_manual() {

            document.getElementById('searchmanual').style.display = "block";
            document.getElementById('searchperjam').style.display = "none";
            }
            function onclick_perjam() {

            document.getElementById('searchmanual').style.display = "none";
            document.getElementById('searchperjam').style.display = "block";
            }

            $('#example2').calendar({
            type: 'date',
            onChange: function (date, text) {
            tanggal = text;
            },
            });
            $('#example3').calendar({
            type: 'date',
            onChange: function (date, text) {
            tanggal2 = text;
            },
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
            jamakhir=sHours+":"+sMinutes+":00 GMT+0700"
            },
            });


            function loaddropdownmac() {
            var div = document.querySelector("#containermac"),
            frag = document.createDocumentFragment(),
            select = document.createElement("select");
            select.className="ui fluid search dropdown";
            select.setAttribute("id", "selectcontainer");
            $.get('<?=url('absensi/get_listmac')?>', function(listmac) {

            for(i=0 ; i<listmac.length ; i++){
            deviceidawal=listmac[0].mac;
            select.options.add( new Option(listmac[i].mac,listmac[i].mac) );

            }

            loaddataawal();
            });

            frag.appendChild(select);
            div.appendChild(frag);
            div.onchange=onclick_search;
            }
            loaddropdownmac();

            function onclick_search() {


            deviceid=$("#selectcontainer :selected").text();

            if(tanggal==null||jamawal==null||jamakhir==null){
            $.post('<?=url('absensi/getalllistabsenbymac')?>',{ deviceid: deviceid},
            function(data) {

            var trHTML = '';
            $('#absensitabelbody').empty();
            var count=1;
            for (i = 0; i < data.length; i++) {

            trHTML += '<tr><td>' + count + '</td><td>' + data[i].rf_id + '</td><td>'+ data[i].date + '</td><td>'+ data[i].time + '</td></tr>';

            count++;

            };
            $('#absensitabel').append(trHTML);
            }
            );



            }else{
            var starttime=new Date(tanggal+" "+jamawal).toISOString();
            var endtime=new Date(tanggal+" "+jamakhir).toISOString();

            $.post('<?=url('absensi/listabsen')?>',{ deviceid: deviceid, starttime: starttime ,endtime: endtime},
            function(data) {

            var trHTML = '';
            $('#absensitabelbody').empty();
            var count=1;
            for (i = 0; i < data.length; i++) {

            trHTML += '<tr><td>' + count + '</td><td>' + data[i].rf_id + '</td><td>'+ data[i].date + '</td><td>'+ data[i].time + '</td></tr>';

            count++;
            };
            $('#absensitabel').append(trHTML);
            }
            );
            }




            }
            function loaddataawal() {
            $.post('<?=url('absensi/getalllistabsenbymac')?>',{ deviceid: deviceidawal},
            function(data) {

            var trHTML = '';
            $('#absensitabelbody').empty();
            var count=1;
            for (i = 0; i < data.length; i++) {

            trHTML += '<tr><td>' + count + '</td><td>' + data[i].rf_id + '</td><td>'+ data[i].date + '</td><td>'+ data[i].time + '</td></tr>';

            count++;
            };
            $('#absensitabel').append(trHTML);
            }
            );
            }

            function searchByDefaultJam(hardcodejamawal,hardcodejamakhir){
            if (hardcodejamawal < 10) hardcodejamawal = "0" + hardcodejamawal;
            if (hardcodejamakhir < 10) hardcodejamakhir = "0" + hardcodejamakhir;

            hardcodejamawal=hardcodejamawal+":00:00 GMT+0700";
            hardcodejamakhir=hardcodejamakhir+":00:00 GMT+0700";
            if(tanggal2==null){
            alert("Silahkan Isi tanggal terlebih dahulu");
            }else{
            var starttime=new Date(tanggal2+" "+hardcodejamawal).toISOString();
            var endtime=new Date(tanggal2+" "+hardcodejamakhir).toISOString();
            deviceid=$("#selectcontainer :selected").text();

            }

            $.post('<?=url('absensi/listabsen')?>',{ deviceid: deviceid, starttime: starttime ,endtime: endtime},
            function(data) {
            var trHTML = '';
            $('#absensitabelbody').empty();
            var count=1;
            for (i = 0; i < data.length; i++) {

            trHTML += '<tr><td>' + count + '</td><td>' + data[i].rf_id + '</td><td>'+ data[i].date + '</td><td>'+ data[i].time + '</td></tr>';

            count++;
            };
            $('#absensitabel').append(trHTML);
            }
            );

            }


            function fnExcelReport()
            {
            var tab_text="<h3>Device ID : "+$("#selectcontainer :selected").text()+" </h3>";
            if(tanggal!=null){
            tab_text=tab_text+"<h3>Tanggal : "+tanggal+" </h3>";
            }
            if(tanggal2!=null){
            tab_text=tab_text+"<h3>Tanggal : "+tanggal2+" </h3>";
            }
            tab_text=tab_text+"<table border='2px'><tr bgcolor='#87AFC6'>";
                    var textRange; var j=0;
                    tab = document.getElementById('absensitabel'); // id of table
                    for(j = 0 ; j < tab.rows.length ; j++)
                    {

                    tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
                //tab_text=tab_text+"</tr>";
                }
                tab_text=tab_text+"</table>";
            tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
            tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
            tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");

            if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
            {
            txtArea1.document.open("txt/html","replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa=txtArea1.document.execCommand("SaveAs",true,"test.xls");
            }
            else                 //other browser not tested on IE 11
            sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

            return (sa);
            }
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
        @endsection


    </div>



@endsection
