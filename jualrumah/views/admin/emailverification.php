<head>
	<title>Pesan dari admin@jualrumah.com</title>
</head>
<body>
<style><!--
.normaltext
{
        font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
        font-size: 14px;
}
#table-normal
{
        font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
        font-size: 12px;
        width: 480px;
        text-align: left;
        border-collapse: collapse;
        background: #e8edff;
}
#table-normal th
{
        font-size: 14px;
        font-weight: normal;
        padding: 10px 8px;
        color: #039;
}
#table-normal td
{
        padding: 8px;
        color: #669;
}
#table-normal .odd
{
                border-bottom: 1px solid #fff;
}
#table-normal td
{
                border-bottom: 1px solid #fff;
}
#table-normal .leftcol
{
                width: 100px;
}
#table-normal tr:hover td
{
        background: #d0dafd;
        color: #339;
}
--></style>
<span class="normaltext">
<p>Hai <?php echo $nama;?>,<br /> <br /> Terimakasih telah memilih situs jualrumah.com. <br /> <br />
   Ini adalah kode verifikasi untuk Iklan properti anda:
</p>

<table id="table-normal">
  <tbody>
    <tr>
      <td class="leftcol">ID Properti</td>
      <td><?php echo $id;?></td>
    </tr>
    <tr class="odd">
      <td>Judul Properti</td>
      <td><?php echo $judul_listing;?></td>
    </tr>
    <tr class="odd">
      <td>Kode Verifikasi</td>
      <td><?php echo $verification_code;?></td>
    </tr>
  </tbody>
</table>

<p>Untuk dapat mengaktifkan iklan properti anda dengan klik <a title="aktivasi Listing" href="<?php echo base_url();?>member/activation/activate_listing/<?php echo $verification_code; ?>">disini</a></p>
<p>Harap tidak membalas email ke alamat ini.Terimakasih</p>

<p>Salam hangat,<br /> <a title="<?php echo base_url()?>" href="<?php echo base_url()?>"><?php echo base_url()?></a></p>
</span></p>
</body>
