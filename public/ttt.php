<?php

include "../recplayer/inc/session.php";   //## Session ?곌껐
$conn=mysql_connect("58.229.253.100","root","sql@zio!tes");
mysql_select_db("asteriskcdrdb", $conn);

//## php 踰꾩쟾 ?댁쑀濡?蹂??紐산?? ?щ븣 ?ъ슜
extract($_POST) ;
extract($_GET) ;
extract($_SERVER) ;
extract($_FILES) ;
extract($_ENV) ;
extract($_COOKIE) ;
extract($_SESSION) ;


?>

<BR><BR><BR>
<?php
echo "<META HTTP-EQUIV=Refresh CONTENT=\"300\">"; #refresh page every 9 seconds

$pagesize=15; //?섏씠吏??湲??
$gopagesize=10; //?섏씠吏?대룞???ш린
if($gopage=="") $gopage=1; //?섏씠吏踰덊샇媛 ?놁쑝硫??섏씠吏踰덊샇 1


$start=($gopage-1)*$pagesize; // ?쒖옉?섏씠吏???섏씠吏踰덊샇


$searchStartdate = $_GET['searchStartdate']?$_GET['searchStartdate']:date('Y-m-d');  //## ?명뭼諛뺤뒪?먯꽌 Get 諛⑹떇?쇰줈 媛믪쓣 諛쏆븘? 蹂?섏뿉 ?쎌엯
$searchEnddate = $_GET['searchEnddate']?$_GET['searchEnddate']:date('Y-m-d');
$searchSrc = trim($_GET['searchSrc']);
$searchClid = trim($_GET['searchClid']);
$searchDst = trim($_GET['searchDst']);
$search_chk = trim($_GET['search_chk']);
$disposition = trim($_GET['disposition']);
$dstchannel = trim($_GET['dstchannel']);
$dst = trim($_GET['dst']);
$uniqueid = trim($_GET['uniqueid']);



if($user_id == 'smi' || $user_id == 'admin'){
    $add_query_Dst .= " and (dstchannel like  'SIP/SMI%') AND LENGTH(dst) != '4' ";
}


//$query = "select clid, src, dst, dstchannel, disposition, duration, calldate from cdr where calldate >= '$searchStartdate 00:00' and calldate <= '$searchEnddate 23:59:59'";  //## ?쒖옉??怨?留덉?留됱씪 蹂?섏뿉 ?쒓컙 異붽?
$query = "select * from cdr where calldate >= '$searchStartdate 00:00' and calldate <= '$searchEnddate 23:59:59'";  //## ?쒖옉??怨?留덉?留됱씪 蹂?섏뿉 ?쒓컙 異붽?
$query .= $add_query_Src;
$query .= $add_query_Clid;
$query .= $add_query_Dst;
$query .= " order by calldate desc limit $start ,$pagesize";

//echo $query;

$query_excel =  "select * from cdr where calldate >= '$searchStartdate 00:00:00' and calldate <= '$searchEnddate 23:59:59'  ";
$query_excel .= $add_query_Src;
$query_excel .= $add_query_Clid;
$query_excel .= " and (dstchannel like  'SIP/SMI%')";

//## 荑쇰━ ?ㅽ뻾 ?쒓컙 泥댄겕 ?묒뀡
function get_mtime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}
//## 荑쇰━ ?ㅽ뻾 ?쒓컙 泥댄겕 ?묒뀡
$result = mysql_query($query, $conn);
$total_row = $result_row[0];
//寃곌낵??泥ル쾲吏??댁씠 count(*) ??寃곌낵??


//## 荑쇰━?ㅽ뻾?곷떒 ?먯꽌 ?쒓컙湲곕줉
$stime = get_mtime();
//## 荑쇰━?ㅽ뻾?곷떒 ?먯꽌 ?쒓컙湲곕줉
$num=mysql_fetch_array(mysql_query("select count(*) from cdr where calldate >= '$searchStartdate 00:00' and calldate <= '$searchEnddate 23:59:59'" .$add_query_Src .$add_query_Clid .$add_query_Dst));
$no = $num['count(*)'];

$total_page=ceil($no/$pagesize); //?꾩껜?섏씠吏??
$p_start=(ceil($gopage/$gopagesize)-1)*$gopagesize+1; //?쒖옉?섏씠吏??
$p_last=ceil($gopage/$gopagesize)*$gopagesize; //留덉?留됲럹?댁?


if($p_last>$total_page)$p_last=$total_page; //留덉?留됲럹?댁?媛 ?꾩껜蹂대떎?щ㈃ 留덉?留됲럹?댁?瑜??꾩껜?섏씠吏?섎줈
$p_next=$p_start+$gopagesize; //?ㅼ쓬?섏씠吏???섏씠吏踰덊샇
$p_prev=$p_start-$gopagesize; //?댁쟾?섏씠吏???섏씠吏踰덊샇
if($p_next>=$total_page)$p_next=$total_page; //?ㅼ쓬?섏씠吏踰덊샇媛 ?꾩껜蹂대떎 ?щ㈃ ?꾩껜?섏씠吏?섎줈
if($p_prev<=0)$p_prev=1; //?댁쟾?섏씠吏踰덊샇媛 0蹂대떎 ?묒쑝硫?1濡쒖뀑??
$today = date("Y-m-d");
$sql = "Select * from user_extension where uid = $_GET[uid] ";
$sql = "select * from cdr where calldate >= '2015-07-01 00:00' and calldate <= '$today 23:59:59'";  //## ?쒖옉??怨?留덉?留됱씪 蹂?섏뿉 ?쒓컙 異붽?
$sql .= $add_query_Src;
$sql .= $add_query_Clid;
$sql .= $add_query_Dst;
$sql .= " order by calldate";
$result1 = mysql_query($sql,$conn);
if(! $result1){
    die('Could not get data: ' . mysql_error());
}


?>

<!-- ?щ젰?뚯뒪 ?쒖옉 -->

<!DOCTYPE html>
<meta charset="utf-8" />
<meta content="initial-scale=1.0; width=device-width, maximum-scale=1.0; minimum-scale=1.0; user-scalable=no;" name="viewport" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<head>
    <title>ZioTes Server</title>
    <style>
        <!--
        td { font-size : 9pt; }
        A:link { font : 9pt; color : black; text-decoration : none; font-family : 援대┝; font-size : 9pt; }
        A:visited { text-decoration : none; color : black; font-size : 9pt; }
        A:hover { text-decoration : underline; color : black; font-size : 9pt; }

        -->
    </style>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script>
        $(function() {
            $( "#datepicker1, #datepicker2,#datepicker3" ).datepicker({
                dateFormat: 'yy-mm-dd',
                prevText: '?댁쟾 ??,
                nextText: '?ㅼ쓬 ??,
                monthNames: ['1??,'2??,'3??,'4??,'5??,'6??,'7??,'8??,'9??,'10??,'11??,'12??],
                monthNamesShort: ['1??,'2??,'3??,'4??,'5??,'6??,'7??,'8??,'9??,'10??,'11??,'12??],
                dayNames: ['??,'??,'??,'??,'紐?,'湲?,'??],
                    dayNamesShort: ['??,'??,'??,'??,'紐?,'湲?,'??],
                dayNamesMin: ['??,'??,'??,'??,'紐?,'湲?,'??],
                showMonthAfterYear: true,
                yearSuffix: '??
        });
        });

    </script>

    <style>
        .ui-datepicker{ font-size: 10px; width: 160px; }
        .ui-datepicker select.ui-datepicker-month{ width:30%; font-size: 11px; }
        .ui-datepicker select.ui-datepicker-year{ width:40%; font-size: 11px; }
    </style>
    <!-- ?섑뵆諛뺤뒪 <p>議고쉶湲곌컙: <input type="text" id="datepicker1"> ~ <input type="text" id="datepicker2"></p> -->

    <!-- ?щ젰?뚯뒪 ??-->

    <script type="text/javascript">
        <!--
        function play(row_num, link) {
            var i = 0;
            var playbackId = "CURRENT_MSG";
            var cmTable = document.getElementById('b_table');
            // Only one playback row is allowed to be open at a time.
            // If one is already open, close it.
            for (i = 0; i < cmTable.rows.length; i++) {
                if (cmTable.rows[i].id == playbackId) {
                    // Delete the row; it's a Playback control row.
                    cmTable.deleteRow(cmTable.rows[i].rowIndex);
                }
            }
            // Make our Playback row.
            var bs={
                versions:function(){
                    var u = navigator.userAgent, app = navigator.appVersion;
                    return {//燁삣뒯瀯덄ク役뤺쭏?①뎵?т에??
                        trident: u.indexOf('Trident') > -1, //IE?끾졇
                        presto: u.indexOf('Presto') > -1, //opera?끾졇
                        webKit: u.indexOf('AppleWebKit') > -1, //?방옖?곮갬閭뚦냵??
                        gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //?ョ땺?끾졇
                        mobile: !!u.match(/AppleWebKit.*Mobile.*/)||!!u.match(/AppleWebKit/), //??맔訝븀㎉?①퍑塋?
                        ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios瀯덄ク
                        android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android瀯덄ク?뽬꿼c役뤺쭏??
                        iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //??맔訝튷Phone?뽬꿗QHD役뤺쭏??
                        iPad: u.indexOf('iPad') > -1, //??맔iPad
                        webApp: u.indexOf('Safari') == -1 //??맔web佯붻?葉뗥틣竊뚧깹?됧ㅄ?ⓧ툗佯뺡깿
                    };
                }(),
                language:(navigator.browserLanguage || navigator.language).toLowerCase()
            }
            if(bs.versions.mobile){
                if(bs.versions.android||bs.versions.iPhone||bs.versions.iPad||bs.versions.ios){
                    playback_src = "<iframe width='100%' height='35px' marginheight='0' marginwidth='0' frameborder='0' scrolling='no' src=" + link + "></iframe>";
                }else{
                    playback_src = "<iframe width='100%' height='25px' marginheight='0' marginwidth='0' frameborder='0' scrolling='no' src=" + link + "></iframe>";
                }
            }else{
                playback_src = "<iframe width='100%' height='25px' marginheight='0' marginwidth='0' frameborder='0' scrolling='no' src=" + link + "></iframe>";
            }

            newRow = cmTable.insertRow(row_num);
            newRow.id = playbackId;
            cell_left = newRow.insertCell(0);
            cell_left.colSpan = 10;
            cell_left.innerHTML = playback_src;
        }

        //-->
    </script>
</head>
<!-- ?ш린遺???곷떒 硫붾돱 -->
<form name="form" method = "get">
    <input type="hidden" name="dstchannel" value="">

    <table align="center" width="800" border="1" cellspacing="0" cellpadding="1" bordercolorlight=#BBBABA bordercolordark=#ffffff>
        <TR>
            <td height ="25" align = "center" colspan = "5" bgcolor="f0f0f0"><span style="height:30px;line-height:30px;float:left;text-align:center;width:90%;display:block;"><b><?php echo "$user_name"?> ?섏쓽 ?붽툑 愿由??섏씠吏</b></span>
                <span style="float:right;display:block;"><!--<a href="/ziotes/login.php?PType=LogOut" onfocus="this.blur()">[logout]</a>-->
	<input type="button" class="btn" value="logout" onclick="location.href='../'">
	</span></td>
        </tr>
        <TR>
            <TD height ="10" align = "center">議고쉶?좎쭨</TD>
            <TD colspan="3">&nbsp;&nbsp;<span style="float:left;height:30px;line-height:30px;padding-left:8px;"><input id="datepicker1" name="searchStartdate" style="width:100px;height:18px;border:1 solid #7F9DB9 ;" size="10"value='<?=$searchStartdate?>'>&nbsp;&nbsp;~&nbsp;&nbsp;
					<input id="datepicker2" name="searchEnddate" style="width:100px;height:18px; border:1 solid #7F9DB9 ;" size="10" value='<?=$searchEnddate?>'>
					<input type="button" id="call_all" class="btn<?=$dstchannel=='1'||!$dstchannel?' on':''?>" value="寃?? onclick="Call_View('1')">
					<input type="button" class="btn" value="Export Excel" onclick="location.href = '../recplayer/Excel.php?query=<?=base64_encode($query_excel)?>&user_id=<?=$_GET['dst']?>'">
					</span>

            </TD>

    </TABLE>
</form>

<? if($user_name == 'Admin'){ ?>
    <table align="center" width="800" border="0" cellspacing="0"  >
        <tr>
            <td>
                <form action="list.php" method="POST" >
                    Deposit: <input type="text" name="amount" placeholder="Amount" required/>
                    <input type="submit" value="ADD" class="btn" name="save_deposit" />
                </form>
            </td>
        </tr>
    </table>

<? } ?>

<!-- ?ш린源뚯? ?곷떒 硫붾돱 -->

<body topmargin=0 leftmargin=0 text=#464646>
<center>



    <!-- 寃뚯떆臾?由ъ뒪?몃? 蹂댁씠湲??꾪븳 ?뚯씠釉?-->
    <table width=800 border=0 cellpadding=2 cellspacing=1 bgcolor=#777777 id="b_table">
        <!-- 由ъ뒪????댄? 遺遺?-->
        <tr height=20 bgcolor=#999999>
            <td align=center>
                <font color=white>No.</font>
            </td>
            <td align=center>
                <font color=white>諛쒖떊踰덊샇</font>
            </td>
            <td align=center>
                <font color=white>李⑹떊踰덊샇</font>
            </td>
            <td align=center>
                <font color=white>?듯솕寃곌낵</font>
            </td>
            <td align=center>
                <font color=white>?듯솕?쒓컙</font>
            </td>
            <td align=center>
                <font color=white>諛쒖떊?쒓컙</font>
            </td>
            <td align=center>
                <font color=white>?듯솕?좎쭨</font>
            </td>
            <td align=center>
                <font color=white>billsec</font>
            </td>
            <td align=center>
                <font color=white>?꾩닔</font>
            </td>
            <td align=center>
                <font color=white>?붽툑</font>
            </td>
        </tr>
        <!-- 由ъ뒪????댄? ??-->
        <!-- 由ъ뒪??遺遺??쒖옉 -->
        <?
        $tr_row = 1;
        $page_total = 0;
        while($row=mysql_fetch_array($result))
        {

            ?>

            <!-- ???쒖옉 -->
            <tr>
                <!-- 踰덊샇 -->
                <td align=center height=20 bgcolor=white>
                    <font color=black><? echo $no - ++$start +1 ?></font><!-- 珥앷컻?쒕Ъ?먯꽌 ?ㅽ???踰덊샇 類?+1 ? 0遺???쒖옉?대씪 -->
                </td>
                <?
                $src_tit = substr(str_replace('SIP/','',$row[dstchannel]),0,4);

                if(strlen($row[dst]) == 4){
                    $brand_num = $src_tit;
                }else{
                    $brand_num =  $row[dst];
                }
                ?>
                <!-- 諛쒖떊踰덊샇 -->
                <td align=center height=20 bgcolor=white>
                    <font color=black><?=$row[src]?></font>
                </td>
                <!-- 李⑹떊踰덊샇 -->
                <td align=center height=20 bgcolor=white>
                    <font color=black><?=$brand_num;?></font>
                </td>
                <!-- ?듯솕寃곌낵 -->
                <td align=center height=20 bgcolor=white>
                    <font color=black><?=$row[disposition]?></font>
                </td>
                <!-- ?듯솕?쒓컙 -->
                <td align=center height=20 bgcolor=white>
                    <font color=black><?=$row[duration]?></font>
                </td>
                <!-- 諛쒖떊?쒓컙 -->
                <td align=center height=20 bgcolor=white>
                    <font color=black><?=substr($row[calldate],11,8)?></font>
                </td>
                <!-- ?듯솕?좎쭨 -->
                <td align=center height=20 bgcolor=white>
                    <font color=black><?=substr($row[calldate],0,10)?></font>
                </td>
                <!-- billsec -->
                <td align=center height=20 bgcolor=white>
                    <font color=black><?=$row[billsec]?></font>
                </td>
                <!-- ?꾩닔 -->
                <td align=center height=20 bgcolor=white>
                    <font color=black>
                        <?
                        if(substr($brand_num,0,2) == '01' ){
                            echo ceil($row[billsec]/10);
                        }
                        if(substr($brand_num,0,2) == '86' ){
                            echo ceil($row[billsec]/60);
                        }
                        if((substr($brand_num,0,2) != '01' ) && (substr($brand_num,0,2) != '86' )){
                            echo ceil($row[billsec]/180);
                        }
                        ?>
                    </font>
                </td>
                <!-- ?붽툑 -->
                <td align=center height=20 bgcolor=white>
                    <font color=black>

                        <?

                        if(substr($brand_num,0,2) == '01' ){
                            echo ((ceil($row[billsec]/10))*6.8);
                            $page_total = $page_total + ((ceil($row[billsec]/10))*6.8);
                        }
                        if(substr($brand_num,0,2) == '86' ){
                            echo ((ceil($row[billsec]/60))*22);
                            $page_total = $page_total + ((ceil($row[billsec]/60))*22);
                        }
                        if((substr($brand_num,0,2) != '01' ) && (substr($brand_num,0,2) != '86' )){
                            echo ((ceil($row[billsec]/180))*32);
                            $page_total = $page_total + ((ceil($row[billsec]/180))*32);
                        }
                        ?>

                    </font>
                </td>
            </tr>


            <!-- ????-->
            <?php
        } // end While

        //?곗씠?곕쿋?댁뒪????곌껐???앸뒗??
        mysql_close($conn);

        ?>
    </table>
    <!-- 寃뚯떆臾?由ъ뒪?몃? 蹂댁씠湲??꾪븳 ?뚯씠釉???->

    <!-- 寃뚯떆臾쇱씠 ?놁쑝硫?臾몄옣?쒖떆 ?쒖옉 -->
    <?php

    if ($no==0) {
        echo "<br>";
        echo '?깅줉??寃뚯떆臾쇱씠 ?놁뒿?덈떎. ?ㅼ떆 寃?됲빐 二쇱떆湲?諛붾엻?덈떎.';
        echo "<br>";}
    $querytime = get_mtime() - $stime;  //##湲곕줉?섏떆媛꾩?먯꽌 寃곌낵湲곕줈 鍮쇨린
    ?>
    <BR>
    <!-- <?
    echo '寃?됱냼?붿떆媛?: ' .$querytime;
    ?> -->
    <!-- 寃뚯떆臾쇱씠 ?놁쑝硫?臾몄옣?쒖떆 ??-->
    <!-- ?섏씠吏瑜??쒖떆?섍린 ?꾪븳 ?뚯씠釉?-->
    <table border=0>
        <tr>
            <td width=600 height=20 align=center rowspan=4>
                <font color=gray>
                    <?
                    foreach($_GET as $key => $value){
                        if($key!='gopage'){
                            $page_href .= $key."=".$value."&";
                        }
                    }
                    ?>

                    <A HREF="list.php?<?=$page_href?>gopage=1"><FONT COLOR="626262">[泥섏쓬]</FONT></A>

                    <?if($p_start>1){?><A HREF="list.php?<?=$page_href?>gopage=<?=$p_prev?>"><?}?><font color="626262">[?댁쟾<?=$gopagesize?>媛? <- </font></A>
                    <?for($i=$p_start;$i<=$p_last;$i++){?><?if($gopage!=$i){?><A HREF="list.php?<?=$page_href?>gopage=<?=$i?>"><?}?>
                        <font color="<?if($gopage==$i){echo "red";}else{echo "626262";}?>"><?=$i?></font></A> <?if($i!=$p_last){?>| <?}?><?}?>
                    <?if($p_last<$total_page){?><A HREF="list.php?<?=$page_href?>gopage=<?=$p_next?>"><?}?><font color="626262">-> [?ㅼ쓬<?=$gopagesize?>媛?</font></A>
                    <A HREF="list.php?<?=$page_href?>gopage=<?=$total_page?>"><FONT COLOR="626262">[留⑤걹]</FONT></A>




                </font>
            </td>
        </tr>
    </table>

    <?php
    $totals = 0;
    while($row1 = mysql_fetch_array($result1,MYSQL_ASSOC)){
        $src_tit1 = substr(str_replace('SIP/','',$row1[dstchannel]),0,4);

        if(strlen($row1[dst]) == 4){
            $brand_num1 = $src_tit1;
        }else{
            $brand_num1 =  $row1[dst];
        }

        if(substr($brand_num1,0,2) == '01' ){
            //echo ((ceil($row1[billsec]/10))*6.8);
            $totals = $totals + ((ceil($row1[billsec]/10))*6.8);
        }
        if(substr($brand_num1,0,2) == '86' ){
            //echo ((ceil($row[billsec]/60))*22);
            $totals = $totals + ((ceil($row1[billsec]/60))*22);
        }
        if((substr($brand_num1,0,2) != '01' ) && (substr($brand_num1,0,2) != '86' )){
            //echo ((ceil($row[billsec]/180))*32);
            $totals = $totals + ((ceil($row1[billsec]/180))*32);
        }




    }

    ?>

    <?php

    mysql_close($conn);

    $conn2=mysql_connect("localhost","root","sql@zio!tes");
    mysql_select_db("smi", $conn2);

    if(isset($_POST['save_deposit']))
    {
        $amount = $_POST['amount'];
        $date_deposit = date('y-m-d');

        $sql_ins="INSERT INTO client_deposit(amount,date) 
					VALUES
					('$amount',
					 '$date_deposit'
					 )";
        $result_ins=mysql_query($sql_ins);


        echo "<script>
		window.location.replace('list.php');
		 alert('deposit added');
	  </script>";
        // window.location='test.php';
    }

    ?>

    <?
    $deposit = 0;
    $compute_query = "Select * from client_deposit";
    $result_deposit = mysql_query($compute_query,$conn2);
    while($row_dep = mysql_fetch_array($result_deposit,MYSQL_ASSOC))
    {
        $deposit = $deposit + $row_dep['amount'];
        //echo $deposit;

    }
    $deposit = $deposit;
    $less=$deposit - $totals;
    if
    ($less <= 0 ) {
        //$output = shell_exec('asterisk -rx "database put cidname 07088888888 test"');
        //echo "<pre>$output</pre>";
    }
    if
    ($less > 0){
        //$output = shell_exec('asterisk -rx "database del cidname 07088888888"');
        //echo "<pre>$output</pre>";
    }

    ?>

    <BR><BR>

    <font color=red> ?⑥? ?붿븸  : <?=number_format($less)?> ??</font>



</center>
</form>
<style>
    .btn{border:1px solid #aed0ea;background:#e3f1fa;color:#2779bd;padding:5px 10px;font-size:12px;cursor:pointer;}
    .on{border:1px solid #2694e8;background:#62bbe8;color:#FFFFFF;padding:5px 10px;font-size:12px;}
</style>
<script type="text/javascript">
    <!--
        function Call_View(val){
            var frm = document.form;
            frm.dstchannel.value = val;
            frm.submit();
        }
    $(document).ready(function() {

        $('.btn').hover(function() {
            $('.btn').removeClass("on");
            $(this).addClass("on");
        }, function(){
            $(this).removeClass("on");
            switch('<?=$dstchannel?>'){
                case "1":
                    $('#call_all').addClass("on");
                    break;
                case "2":
                    $('#call_send').addClass("on");
                    break;
                case "3":
                    $('#call_to').addClass("on");
                    break;
                default:
                    $('#call_all').addClass("on");
            }
        });
    });

</script>

</body>
</html>