<script type="text/javascript">

    function delete_compare(id) {
        $.ajax({
            url: '<?php echo base_url() . 'compare/delete/id';?>' + id,
            type: "POST",
            async: false,
            cache: false,
            success: function (msg) {
                window.location.href = "<?php echo base_url().'compare/show' ?>";
            }
        })
    }

    function clear_text() {
        document.getElementById('nama').value = "";
        document.getElementById('telp').value = "";
        document.getElementById('email').value = "";
        document.getElementById('pesan').value = "";
    }

    var myVal;
    function set_value(val) {
        myVal = val;
        clear_text();
    }

    function send_msg() {
        $.ajax({
            url: '<?php echo base_url() . 'member/message/send/';?>' + myVal,
            type: "POST",
            data: $('form').serialize(),
            async: false,
            cache: false,
            success: function (msg) {

                if (msg.indexOf("#error") != 0) {

                    clear_text();
                    alert(msg);
                    $('#myModal').modal('hide');

                } else {
                    alert(msg);
                }
            }
        })
    }

</script>


<div class="row">
    <div class="span12">

        <?php if ($compare_num == 0): ?>
            <div class="alert alert-error">
                <a class="close" data-dismiss="alert" href="#">x</a>Belum ada item properti yang dibandingkan.
            </div>

            <?php for ($i = 0; $i < 15; $i++) {
                echo '<br>';
            }?>

        <?php else: ?>
            <h1>Compare properties</h1><br/>

            <table class="table table-bordered table-striped product_comparison">
                <thead>
                <tr>
                    <th style="width: 200px">&nbsp;</th>
                    <?php foreach ($q_compare as $r_compare) { ?>
                        <th>


                            <div class="center">
                                <a href="<?php echo base_url() . 'property/show/' . $r_compare->id_listing; ?>">
                                    <h3><?php echo substr($r_compare->judul, 0, 20); ?></h3>
                                    <h6><?php echo $r_compare->lokasi; ?></h6></a><br/>
                                <a href="<?php echo base_url() . 'property/show/' . $r_compare->id_listing; ?>"
                                   class="span3"><img width="150" height="150" alt=""
                                                      src="<?php echo image(base_url() . "media/" . $r_compare->file_name, 'thumb') ?>"
                                                      height="130" width="130"/></a><br/><br/>

                                <p>Harga: Rp.<?php echo $r_compare->harga; ?></p>
                                <!-- <p>Telp <?php echo $r_compare->telp; ?></p> -->
                                <p><a href="#myModal" data-toggle="modal" class="btn btn-primary"
                                      onclick="set_value('<?php echo $r_compare->id_member . '/' . $r_compare->id_listing; ?>')">Contact
                                        agent</a></p>
                            </div>
                        </th>
                    <?php } ?>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>Deskripsi</td>
                    <?php foreach ($q_compare as $r_compare) { ?>
                        <td><?php echo $r_compare->deskripsi; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Tipe Properti</td>
                    <?php foreach ($q_compare as $r_compare) { ?>
                        <td><?php echo $r_compare->tipe_properti; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Kamar Tidur</td>
                    <?php foreach ($q_compare as $r_compare) { ?>
                        <td><?php echo $r_compare->jml_kmr_tdr; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Kamar Mandi</td>
                    <?php foreach ($q_compare as $r_compare) { ?>
                        <td><?php echo $r_compare->jml_kmr_mandi; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Jual/Sewa ?</td>
                    <?php foreach ($q_compare as $r_compare) { ?>
                        <td><?php echo $r_compare->tipe_listing; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Jumlah Lantai</td>
                    <?php foreach ($q_compare as $r_compare) { ?>
                        <td><?php echo $r_compare->jml_lantai; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Luas Tanah</td>
                    <?php foreach ($q_compare as $r_compare) { ?>
                        <td><?php echo $r_compare->luas_tanah; ?> <?php isset($r_compare->dimensi_tanah) ? ' (' . $r_compare->dimensi_tanah . ')' : ''; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Luas Bangunan</td>
                    <?php foreach ($q_compare as $r_compare) { ?>
                        <td><?php echo $r_compare->luas_bangunan; ?> <?php isset($r_compare->dimensi_bangunan) ? ' (' . $r_compare->dimensi_bangunan . ')' : ''; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Tahun Pembangunan</td>
                    <?php foreach ($q_compare as $r_compare) { ?>
                        <td><?php echo $r_compare->thn_pembangunan; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Kontak</td>
                    <?php foreach ($q_compare as $r_compare) { ?>
                        <td><?php echo $r_compare->nama_kontak; ?> <?php echo isset($r_compare->tlp_kontak) ? ' (' . $r_compare->tlp_kontak . ')' : ''; ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Hapus</td>
                    <?php foreach ($q_compare as $r_compare) { ?>
                        <td>
                            <div class="center"><p><a class="btn btn-primary"
                                                      onclick="delete_compare(<?php echo $r_compare->id_listing; ?>)">Hapus</a>
                                </p></div>
                        </td>
                    <?php } ?>
                </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<style type="text/css">

    .modal {
        width: 700px;
        left: 45%;
    }

    .input-xlarge {
        width: 330px;
    }

</style>


<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Kirim Pesan</h3>
    </div>

    <form class="well span8">
        <div class="row">
            <div class="span3">
                <label>Nama</label>
                <input name="nama" id="nama" type="text" class="span3" placeholder="Nama">
                <label>Email</label>
                <input name="email" id="email" type="text" class="span3" placeholder="Alamat Email">
                <label>No.Telp</label>
                <input name="telp" id="telp" type="text" class="span3" placeholder="Nomor Telp">
            </div>
            <div class="span5">
                <label>Message</label>
                <textarea name="pesan" id="pesan" class="input-xlarge span5" rows="10"></textarea>
            </div>

            <button type="submit" class="btn btn-primary pull-right" onclick="send_msg();return false;">Kirim</button>
        </div>
    </form>
</div>