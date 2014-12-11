<?php $this->load->view('js_member');?>
<div id="window_container">
<div id="window_title">
	<div id="window_title_left"><?php echo lang('kalkun_sms_member');?></div>
	<div id="window_title_right">
	<a href="#" id="send_member" class="nicebutton">&#43; <?php echo lang('tni_send_message');?></a>	
	</div>
</div>
<div id="member information" style="background: #eee; padding: 5px 10px; border-bottom: 1px solid #ccc;">
	<?php $result = mysql_query("SELECT * FROM buber WHERE jns_kelamin='IKHWAN'");
		  $num_rows = mysql_num_rows($result);
		  $jmikhwan = $num_rows;
		  
		  $result2 = mysql_query("SELECT * FROM buber WHERE jns_kelamin='AKHWAT'");
		  $num_rows2 = mysql_num_rows($result2);
		  $jmakhwat = $num_rows2;
		  
		  $total = $jmikhwan+$jmakhwat;
	?>
	<?php //echo lang('kalkun_sms_total_member');?>
	<b>Total Member:</b> <?php echo "<b><font color='red'>".$total."</font></b>".' ====>'.'<b> Ikhwan: </b>'."<b><font color='blue'>".$jmikhwan."</font></b>".'&nbsp&nbsp&nbsp<b> Akhwat: </b>'."<b><font color='blue'>".$jmakhwat."</font></b>";?>
	</div>
<script LANGUAGE ="JavaScript">
document.write('<input type="button" name="print" value="Print"'+'onClick="javascript:window.print()"/>'+'this page!');
</script>
<div id="window_content">
<?php

/*if($total_member==0):
echo "<p class=\"no_content\"><span class=\"ui-icon ui-icon-alert\" style=\"float:left;\"></span><i>".lang('kalkun_sms_no_member').".</i></p>";
else:
foreach($member as $tmp_member):
	echo $tmp_member['phone_number']." - ".$tmp_member['reg_date']."<br>";
endforeach;
endif;
*/

	$baris= 1;
    echo "<table width=\"400\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\"#ffffff\">";
    echo "<tr bgcolor=\"#99CCFF\">";
    echo "<th>ID_Daftar</th>";
    echo "<th>Nama</th>";
    echo "<th>Jenis</th>";
    echo "<th>Pengirim</th>";
    echo "<th>TTD</th>";
    echo "</tr>";
	$query1 = "SELECT * FROM buber where jns_kelamin='IKHWAN' order by id_daftar asc";
	$hasil1 = mysql_query($query1);
	while ($data1 = mysql_fetch_array($hasil1))
	{	
		$nama1 = $data1['Nama'];
		$id_daf1 = $data1['id_daftar'];
		$jenis1 = $data1['jns_kelamin'];
		$pengirim1 = $data1['pengirim'];
		$TTD1 = $data1['TTD'];
		$warna= ($baris% 2 == 1) ? "#cccccc" : "#FFFFFF";
        echo "<tr bgcolor=\"".$warna."\">";
        echo "<td>".$id_daf1."</td>";
        echo "<td>".$nama1."</td>";
        echo "<td>".$jenis1."</td>";
        echo "<td>".$pengirim1."</td>";
        echo "<td>".$TTD1."</td>";
        echo "</tr>";
        $baris++;
	}
	 echo "</table>";
	 echo "<br><br>";
	$baris= 1;
    echo "<table width=\"400\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\"#ffffff\">";
    echo "<tr bgcolor=\"#99CCFF\">";
    echo "<th>ID_Daftar</th>";
    echo "<th>Nama</th>";
    echo "<th>Jenis</th>";
	echo "<th>Pengirim</th>";
    echo "<th>TTD</th>";
    echo "</tr>";
	$query = "SELECT * FROM buber where jns_kelamin='AKHWAT' order by id_daftar asc";
	$hasil = mysql_query($query);
	while ($data = mysql_fetch_array($hasil))
	{	
		$nama = $data['Nama'];
		$id_daf = $data['id_daftar'];
		$jenis = $data['jns_kelamin'];
		$pengirim = $data['pengirim'];
		$TTD = $data['TTD'];
		$warna= ($baris% 2 == 1) ? "#cccccc" : "#FFFFFF";
        echo "<tr bgcolor=\"".$warna."\">";
        echo "<td>".$id_daf."</td>";
        echo "<td>".$nama."</td>";
        echo "<td>".$jenis."</td>";
		echo "<td>".$pengirim."</td>";
        echo "<td>".$TTD."</td>";
        echo "</tr>";
        $baris++;
	}
	 echo "</table>";
?>
</div>
</div>
