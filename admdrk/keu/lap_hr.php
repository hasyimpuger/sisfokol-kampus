<?php
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
/////// SISFOKOL-KAMPUS         ///////
///////////////////////////////////////////////////////////
/////// Dibuat oleh :                               ///////
/////// Agus Muhajir, S.Kom                         ///////
/////// URL 	: http://sisfokol.wordpress.com     ///////
/////// E-Mail	:                                   ///////
///////     * hajirodeon@yahoo.com                  ///////
///////     * hajirodeon@gmail.com                  ///////
/////// HP/SMS	: 081-829-88-54                     ///////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////






session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admdrk.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "lap_hr.php";
$jnskd = nosql($_REQUEST['jnskd']);
$progdi = nosql($_REQUEST['progdi']);
$kelkd = nosql($_REQUEST['kelkd']);
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$s = nosql($_REQUEST['s']);
$utgl = nosql($_REQUEST['utgl']);
$ubln = nosql($_REQUEST['ubln']);
$uthn = nosql($_REQUEST['uthn']);


//ketahui jenis keuangan
$qdt = mysql_query("SELECT * FROM m_keu_jenis ".
			"WHERE kd = '$jnskd'");
$rdt = mysql_fetch_assoc($qdt);
$dt_kd = nosql($rdt['kd']);
$dt_jenis = balikin($rdt['nama']);




//judul halaman
$judul = "Lap.Harian : $dt_jenis";
$judulku = "$judul  [$drk_session : $nip1_session. $nm1_session]";
$juduli = $judul;
$ke = "$filenya?jnskd=$jnskd&progdi=$progdi&kelkd=$kelkd&tapelkd=$tapelkd&smtkd=$smtkd&uthn=$uthn&ubln=$ubln&utgl=$utgl";




//focus...
if (empty($progdi))
	{
	$diload = "document.formx.progdi.focus();isodatetime();";
	}
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();isodatetime();";
	}
else if (empty($tapelkd))
	{
	$diload = "document.formx.tapel.focus();isodatetime();";
	}
else if (empty($utgl))
	{
	$diload = "document.formx.utglx.focus();";
	}
else if (empty($ubln))
	{
	$diload = "document.formx.ublnx.focus();";
	}






//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/menu/admdrk.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Program Studi : ';
echo "<select name=\"progdi\" onChange=\"MM_jumpMenu('self',this,0)\">";
//terpilih
$qtpx = mysql_query("SELECT * FROM m_progdi ".
			"WHERE kd = '$progdi'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_nama = balikin($rowtpx['nama']);

echo '<option value="'.$tpx_kd.'" selected>'.$tpx_nama.'</option>';

$qtp = mysql_query("SELECT * FROM m_progdi ".
			"WHERE kd <> '$progdi' ".
			"ORDER BY nama ASC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpnama = balikin($rowtp['nama']);

	echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&progdi='.$tpkd.'">'.$tpnama.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>,

Jenis : ';
echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);
$btxkd = nosql($rowbtx['kd']);
$btxkelas = nosql($rowbtx['kelas']);

echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

$qbt = mysql_query("SELECT * FROM m_kelas ".
			"WHERE kd <> '$kelkd' ".
			"ORDER BY no ASC");
$rowbt = mysql_fetch_assoc($qbt);

do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = nosql($rowbt['kelas']);

	echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&progdi='.$progdi.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>,

Tahun Akademik : ';
echo "<select name=\"tapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<option value="'.$tpx_kd.'">'.$tpx_thn1.'/'.$tpx_thn2.'</option>';

$qtp = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd <> '$tapelkd' ".
						"ORDER BY tahun1 DESC");
$rowtp = mysql_fetch_assoc($qtp);

do
	{
	$tpkd = nosql($rowtp['kd']);
	$tpth1 = nosql($rowtp['tahun1']);
	$tpth2 = nosql($rowtp['tahun2']);

	echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&progdi='.$progdi.'&kelkd='.$kelkd.'&tapelkd='.$tpkd.'">'.$tpth1.'/'.$tpth2.'</option>';
	}
while ($rowtp = mysql_fetch_assoc($qtp));

echo '</select>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tanggal : ';
echo "<select name=\"utglx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$utgl.'">'.$utgl.'</option>';
for ($itgl=1;$itgl<=31;$itgl++)
	{
	echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&progdi='.$progdi.'&kelkd='.$kelkd.'&tapelkd='.$tapelkd.'&utgl='.$itgl.'">'.$itgl.'</option>';
	}
echo '</select>';

echo "<select name=\"ublnx\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$ubln.''.$uthn.'" selected>'.$arrbln[$ubln].' '.$uthn.'</option>';
for ($i=1;$i<=12;$i++)
	{
	//nilainya
	if ($i<=6) //bulan juli sampai desember
		{
		$ibln = $i + 6;

		echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&progdi='.$progdi.'&kelkd='.$kelkd.'&tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn1.'">'.$arrbln[$ibln].' '.$tpx_thn1.'</option>';
		}

	else if ($i>6) //bulan januari sampai juni
		{
		$ibln = $i - 6;

		echo '<option value="'.$filenya.'?jnskd='.$jnskd.'&progdi='.$progdi.'&kelkd='.$kelkd.'&tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ibln.'&uthn='.$tpx_thn2.'">'.$arrbln[$ibln].' '.$tpx_thn2.'</option>';
		}
	}

echo '</select>
</td>
</tr>
</table>';


//nek blm dipilih
if (empty($progdi))
	{
	echo '<p>
	<font color="#FF0000"><strong>PROGRAM PENDIDIKAN Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($kelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>JENIS Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($tapelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}
else if (empty($utgl))
	{
	echo '<p>
	<font color="#FF0000"><strong>TANGGAL Belum Dipilih...!</strong></font>
	</p>';
	}
else if (empty($ubln))
	{
	echo '<p>
	<font color="#FF0000"><strong>BULAN Belum Dipilih...!</strong></font>
	</p>';
	}
else
	{
	//query
	$qcc = mysql_query("SELECT mahasiswa_keu.*, ".
				"mahasiswa_keu.kd_mahasiswa AS swkd, ".
				"mahasiswa_keu.kd AS pkd, ".
				"m_mahasiswa.* ".
				"FROM mahasiswa_keu, m_mahasiswa ".
				"WHERE mahasiswa_keu.kd_mahasiswa = m_mahasiswa.kd ".
				"AND mahasiswa_keu.kd_jenis = '$jnskd' ".
				"AND mahasiswa_keu.nilai <> '' ".
				"AND round(DATE_FORMAT(mahasiswa_keu.tgl_bayar, '%d')) = '$utgl' ".
				"AND round(DATE_FORMAT(mahasiswa_keu.tgl_bayar, '%m')) = '$ubln' ".
				"AND round(DATE_FORMAT(mahasiswa_keu.tgl_bayar, '%Y')) = '$uthn' ".
				"ORDER BY round(m_mahasiswa.nim) ASC");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);


	//jika ada
	if ($tcc != 0)
		{
		echo '<br>
		[<a href="lap_hr_prt.php?jnskd='.$jnskd.'&progdi='.$progdi.'&kelkd='.$kelkd.'&tapelkd='.$tapelkd.'&utgl='.$utgl.'&ubln='.$ubln.'&uthn='.$uthn.'"><img src="'.$sumber.'/img/print.gif" border="0" width="16" height="16"></a>]
		<table width="600" border="1" cellspacing="0" cellpadding="3">
		<tr valign="top" bgcolor="'.$warnaheader.'">
		<td width="50"><strong><font color="'.$warnatext.'">NIM</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
		<td width="50"><strong><font color="'.$warnatext.'">Semester</font></strong></td>
		<td width="200" align="center"><strong><font color="'.$warnatext.'">Nominal</font></strong></td>
		</tr>';

		do
			{
			if ($warna_set ==0)
				{
				$warna = $warna01;
				$warna_set = 1;
				}
			else
				{
				$warna = $warna02;
				$warna_set = 0;
				}

			$i_nomer = $i_nomer + 1;
			$i_pkd = nosql($rcc['pkd']);
			$i_swkd = nosql($rcc['swkd']);
			$i_nim = nosql($rcc['nim']);
			$i_nama = balikin($rcc['nama']);




			//ketahui kode mahasiswa, dari suatu mahasiswa_kelas
			$qske = mysql_query("SELECT mahasiswa_kelas.*, m_tapel.* ".
						"FROM mahasiswa_kelas, m_tapel ".
						"WHERE mahasiswa_kelas.kd_tapel = m_tapel.kd ".
						"AND mahasiswa_kelas.kd_mahasiswa = '$i_swkd' ".
						"AND m_tapel.kd = '$tapelkd'");
			$rske = mysql_fetch_assoc($qske);
			$tske = mysql_num_rows($qske);


			//semester terakhir
			$qnil = mysql_query("SELECT * FROM mahasiswa_kelas ".
						"WHERE kd_progdi = '$progdi' ".
						"AND kd_kelas = '$kelkd' ".
						"AND kd_tapel = '$tapelkd' ".
						"AND kd_mahasiswa = '$i_swkd'");
			$rnil = mysql_fetch_assoc($qnil);
			$tnil = mysql_num_rows($qnil);
			$nil_smtkd = nosql($rnil['kd_smt']);

			//smt
			$qkelx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$nil_smtkd'");
			$rkelx = mysql_fetch_assoc($qkelx);
			$kelx_smt = balikin($rkelx['smt']);
			$kelx_no = nosql($rkelx['no']);



			//jumlah bayar
			$qjmx = mysql_query("SELECT * FROM mahasiswa_keu ".
						"WHERE nilai <> '' ".
						"AND round(DATE_FORMAT(tgl_bayar, '%d')) = '$utgl' ".
						"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
						"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn' ".
						"AND kd_jenis = '$jnskd' ".
						"AND kd_mahasiswa = '$i_swkd' ".
						"AND kd = '$i_pkd'");
			$rjmx = mysql_fetch_assoc($qjmx);
			$tjmx = mysql_num_rows($qjmx);
			$jmx_nilai = nosql($rjmx['nilai']);


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$i_nim.'</td>
			<td>'.$i_nama.'</td>
			<td>'.$kelx_smt.'</td>
			<td align="right">'.xduit2($jmx_nilai).'</td>
			</tr>';
			}
		while ($rcc = mysql_fetch_assoc($qcc));


		//ketahui jumlah uang nya...
		$qjmx1 = mysql_query("SELECT SUM(nilai) AS total ".
					"FROM mahasiswa_keu ".
					"WHERE nilai <> '' ".
					"AND kd_jenis = '$jnskd' ".
					"AND round(DATE_FORMAT(tgl_bayar, '%d')) = '$utgl' ".
					"AND round(DATE_FORMAT(tgl_bayar, '%m')) = '$ubln' ".
					"AND round(DATE_FORMAT(tgl_bayar, '%Y')) = '$uthn'");
		$rjmx1 = mysql_fetch_assoc($qjmx1);
		$tjmx1 = mysql_num_rows($qjmx1);
		$jmx1_total = nosql($rjmx1['total']);

		echo '<tr bgcolor="'.$warnaover.'">
		<td></td>
		<td></td>
		<td></td>
		<td align="right"><strong>'.xduit2($jmx1_total).'</strong></td>
		</tr>
		</table>';
		}
	else
		{
		echo '<p>
		<font color="red">
		<strong>Tidak Ada Data</strong>
		</font>
		</p>';
		}
	}

echo '</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>