<head>
	<title>Selamat Datang</title>
</head>
<body>	
<span class="normaltext">
<p>Dengan hormat,<br /> <br /> Selamat datang di website kami. <br /> <br /> 
   Email ini tercatat digunakan untuk mendaftar sebagai anggota di website kami. 
   Harap simpan password Anda dengan baik.<br /> <br /> <b>
   Data User :</b>
</p>

<table id="table-normal">
  <tbody>
    <tr>
      <td class="leftcol">Email</td>
      <td><?php echo $email;?></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><?php echo $password ?></td>
    </tr>
    <tr>
      <td>Nama</td>
      <td><?php echo $nama_depan .' '.$nama_belakang;?></td>
    </tr>
    <tr class="odd">
      <td>Telpon</td>
      <td><?php echo $telp;?></td>
    </tr>    
  </tbody>
</table>

<p>Akun anda telah dibuat,namun anda harus melakukan verifikasi akun dengan klik <a title="aktivasi akun" href="<?php echo base_url();?>member/activation/go_activate/<?php echo $verified_code; ?>">disini</a></p>
   
<p>Salam hangat,<br /> <a title="<?php echo base_url();?>" href="<?php echo base_url();?>"><?php echo base_url();?></a></p>
</span></p>
</body>