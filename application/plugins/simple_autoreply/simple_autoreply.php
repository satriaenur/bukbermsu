<?php
/**
* Plugin Name: Simple Autoreply
* Plugin URI: http://azhari.harahap.us
* Version: 0.1
* Description: Simple a.k.a stupid autoreply, reply to all incoming message
* Author: Azhari Harahap
* Author URI: http://azhari.harahap.us
*/

/*
|--------------------------------------------------------------------------
| CONFIGURATION
|--------------------------------------------------------------------------
| 
| uid - identifier of which user sent the autoreply, uid 1 is the default value
| message - the message you want to sent
| 
*/


function simple_autoreply_initialize()
{
	$config['uid'] = '1';
	$config['message'] = "Anda Berhasil Terdaftar Buber MSU. ";
	return $config;
}

// Add hook for incoming message
add_action("message.incoming.before", "simple_autoreply", 11);

/**
* Function called when plugin first activated
* Utility function must be prefixed with the plugin name
* followed by an underscore.
* 
* Format: pluginname_activate
* 
*/
function simple_autoreply_activate()
{
    return true;
}

/**
* Function called when plugin deactivated
* Utility function must be prefixed with the plugin name
* followed by an underscore.
* 
* Format: pluginname_deactivate
* 
*/
function simple_autoreply_deactivate()
{
    return true;
}

/**
* Function called when plugin first installed into the database
* Utility function must be prefixed with the plugin name
* followed by an underscore.
* 
* Format: pluginname_install
* 
*/
function simple_autoreply_install()
{
    return true;
}

function simple_autoreply($sms)
{
	$query = "SELECT * FROM inbox where Processed = 'false'";
	$hasil = mysql_query($query);
	$query4 = "SELECT * FROM inbox where Processed = 'false'";
	$hasil4 = mysql_query($query4);
	while ($data2 = mysql_fetch_array($hasil4))
	{	
		
		$id_daf = $data2['ID'];
		$batasnya2 = $data2['ReceivingDateTime'];
		$hppengirimnya = $data2['SenderNumber'];
		$msg2 = strtoupper($data2['TextDecoded']);
		$pecah2 = explode(" ",$msg2);
		$namanya = $pecah2[1];
		$jenisnya = $pecah2[2];
		if(($pecah2[0] == "BUBER") and ((($namanya!="") and ($namanya!=" ")) and (($jenisnya!="") and ($jenisnya!=" "))) and (($jenisnya=="IKHWAN") or ($jenisnya=="AKHWAT")))
		{	
			$query7 = "SELECT Nama FROM buber WHERE Nama ='$namanya' and jns_kelamin = '$jenisnya' and pengirim = '$hppengirimnya'";
			$hasil7 = mysql_query($query7);
			if (mysql_num_rows($hasil7) == 0)
			{
				$query5 = "INSERT INTO buber(id,Nama,id_daftar,jns_kelamin,pengirim) VALUES ('','$namanya','$id_daf','$jenisnya','$hppengirimnya')";
				$hasil5 = mysql_query($query5);
			}
			
		}
		
		
	}
	
while ($data1 = mysql_fetch_array($hasil))
{
	$id = $data1['ID'];
	$batasnya = $data1['ReceivingDateTime'];

  // membaca pesan SMS dan mengubahnya menjadi kapital
  $msg = strtoupper($data1['TextDecoded']);
  // proses parsing 
 
  // memecah pesan berdasarkan karakter
  $pecah = explode(" ", $msg);
  $namapengirim = $pecah[1];
 
  // jika kata terdepan dari SMS adalah 'NILAI' maka cari nilai Kalkulus
  /*
  if ($batasnya > date('Y-m-d').'12:00:00')
  {
	$config = simple_autoreply_initialize();
    $CI =& get_instance();
    $CI->load->model('Message_model');
	$data['coding'] = 'default';
	$data['class'] = '1';
	$data['dest'] = $sms->SenderNumber;
	$data['date'] = date('Y-m-d H:i:s');
	$data['message'] = "Maaf, Pendaftaran Buber Sudah ditutup";
	$data['delivery_report'] = 'default';
	$data['uid'] = $config['uid'];	
	$CI->Message_model->send_messages($data);
	$query3 = "UPDATE inbox SET Processed = 'true' WHERE ID = '$id'";
	$hasil3 = mysql_query($query3);
  }
  */
  
  if (($pecah[0] == "BUBER"))
  {	
	if((($namanya!="") and ($namanya!=" ")) and (($jenisnya!="") and ($jenisnya!=" ")) and (($jenisnya=="IKHWAN") or ($jenisnya=="AKHWAT")))
	{
		if (mysql_num_rows($hasil7) == 0)
		{
				$config = simple_autoreply_initialize();
				$CI =& get_instance();
				$CI->load->model('Message_model');
				$data['coding'] = 'default';
				$data['class'] = '1';
				$data['dest'] = $sms->SenderNumber;
				$data['date'] = date('Y-m-d H:i:s');
				$data['message'] = $config['message']."Nomer id Daftar ".$namapengirim." adalah:".$id_daf.". Silahkan datang sebelum adzan magrib, untuk ikhwan didepan sekre LAZIZ, akhwat dibawah tangga AKHWAT";
				$data['delivery_report'] = 'default';
				$data['uid'] = $config['uid'];	
				$CI->Message_model->send_messages($data);
				$query3 = "UPDATE inbox SET Processed = 'true' WHERE ID = '$id'";
				$hasil3 = mysql_query($query3);
		}
		if(mysql_num_rows($hasil7) == 1)
		{
				$config = simple_autoreply_initialize();
				$CI =& get_instance();
				$CI->load->model('Message_model');
				$data['coding'] = 'default';
				$data['class'] = '1';
				$data['dest'] = $sms->SenderNumber;
				$data['date'] = date('Y-m-d H:i:s');
				$data['message'] = "Maaf, anda sudah terdaftar";
				$data['delivery_report'] = 'default';
				$data['uid'] = $config['uid'];	
				$CI->Message_model->send_messages($data);
				$query3 = "UPDATE inbox SET Processed = 'true' WHERE ID = '$id'";
				$hasil3 = mysql_query($query3);
		}
	}
	else
	{
		$config = simple_autoreply_initialize();
		$CI =& get_instance();
		$CI->load->model('Message_model');
		$data['coding'] = 'default';
		$data['class'] = '1';
		$data['dest'] = $sms->SenderNumber;
		$data['date'] = date('Y-m-d H:i:s');
		$data['message'] = "maaf, Format salah: Ketik BUBER(spasi)Nama(spasi)IKHWAN/AKHWAT untuk daftar";
		$data['delivery_report'] = 'default';
		$data['uid'] = $config['uid'];	
		$CI->Message_model->send_messages($data);
		$query3 = "UPDATE inbox SET Processed = 'true' WHERE ID = '$id'";
		$hasil3 = mysql_query($query3);
	}
  }
  if (($pecah[0] == "UNBUBER") and ($pecah[0] != "BUBER"))
  {
	$config = simple_autoreply_initialize();
    $CI =& get_instance();
    $CI->load->model('Message_model');
	$data['coding'] = 'default';
	$data['class'] = '1';
	$data['dest'] = $sms->SenderNumber;
	$data['date'] = date('Y-m-d H:i:s');
	$data['message'] = "Trims";
	$data['delivery_report'] = 'default';
	$data['uid'] = $config['uid'];	
	$CI->Message_model->send_messages($data);
	$query3 = "UPDATE inbox SET Processed = 'true' WHERE ID = '$id'";
	$hasil3 = mysql_query($query3);
  }
  if (($pecah[0] != "BUBER") and ($pecah[0] != "UNBUBER"))
  { 
	if(strlen($sms->SenderNumber)>=10){
		$config = simple_autoreply_initialize();
		$CI =& get_instance();
		$CI->load->model('Message_model');
		$data['coding'] = 'default';
		$data['class'] = '1';
		$data['dest'] = $sms->SenderNumber;
		$data['date'] = date('Y-m-d H:i:s');
		$data['message'] = "Maaf Keyword salah, BUBER(spasi)Nama(spasi)IKHWAN/AKHWAT untuk daftar";
		$data['delivery_report'] = 'default';
		$data['uid'] = $config['uid'];	
		$CI->Message_model->send_messages($data);
	}
	$query3 = "UPDATE inbox SET Processed = 'true' WHERE ID = '$id'";
	$hasil3 = mysql_query($query3);
  }
}
	
}

/* End of file simple_autoreply.php */
/* Location: ./application/plugins/simple_autoreply/simple_autoreply.php */