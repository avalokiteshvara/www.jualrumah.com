                <div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                        <li class= "<?php echo ($active_menu == 'dashboard') ? 'active' : ''  ?>">
                            <a href="<?php echo base_url()?>admin/dashboard"><i class="icon-chevron-right"></i> Dashboard</a>
                        </li>

                        <li class= "<?php echo ($active_menu == 'members') ? 'active' : ''  ?>">
                            <a href="<?php echo base_url()?>admin/members"><i class="icon-chevron-right"></i> Members</a>
                        </li>

                        <li class= "<?php echo ($active_menu == 'listings') ? 'active' : ''  ?>">
                            <a href="<?php echo base_url()?>admin/listings"><i class="icon-chevron-right"></i> Properti</a>
                        </li>

                        <li class= "<?php echo ($active_menu == 'pesan') ? 'active' : ''  ?>">
                            <a href="<?php echo base_url()?>admin/pesan"><i class="icon-chevron-right"></i> Pesan</a>
                        </li>

                        <li class= "<?php echo ($active_menu == 'laporan-bulanan') ? 'active' : ''  ?>">
                            <a href="<?php echo base_url()?>admin/laporan/bulanan"><i class="icon-chevron-right"></i> Laporan Bulanan</a>
                        </li>

                    </ul>
                </div>
