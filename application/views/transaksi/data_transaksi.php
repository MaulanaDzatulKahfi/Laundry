<div class="container">
    <h3 class="text-center mt-3"><?= $judul; ?></h3>
    <?php if ($this->session->flashdata('pesan')) : ?>
        <div class="alert alert-success mt-3">
            <?= $this->session->flashdata('pesan'); ?>
        </div>
    <?php endif ?>
    <?php if ($this->session->flashdata('gagal')) : ?>
        <div class="alert alert-danger mt-3">
            <?= $this->session->flashdata('gagal'); ?>
        </div>
    <?php endif ?>
    <table class="table table-bordered mt-3" id="data">
        <thead class="bg-info text-white">
            <tr>
                <td>No</td>
                <td>tanggal</td>
                <td>Kode invoice</td>
                <td>Nama Pelanggan</td>
                <?php if ($this->session->userdata('level') == 'admin') : ?>
                    <td>Outlet</td>
                <?php endif ?>
                <td>Status Cucian</td>
                <td>Status Pembayaran</td>
                <td>Aksi</td>
            </tr>
        </thead>
        <?php
        $no = 1;
        foreach ($laporan as $t) :
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $t->tgl; ?></td>
                <td><?= $t->kode_invoice; ?></td>
                <td><?= $t->nama; ?></td>
                <?php if ($this->session->userdata('level') == 'admin') : ?>
                    <td><?= $t->nama_outlet; ?></td>
                <?php endif ?>
                <td><?= $t->status; ?></td>
                <td><?= $t->dibayar; ?></td>
                <td>
                    <a target="_blank" href="<?= base_url('C_Transaksi/detail/' . $t->id_transaksi) ?>" class="badge badge-primary">Detail</a>
                    <?php if ($t->status == 'proses') : ?>
                        <a href="<?= base_url('C_Transaksi/selesai/' . $t->id_transaksi) ?>" onclick="return confirm('Yakin Apakah Barang Telah selesai Dicuci')" class="badge badge-warning">Selesai</a>
                        <a href="<?= base_url('C_Transaksi/hapus/' . $t->id_transaksi) ?>" onclick="return confirm('apa anda yakin? data dihapus?')" class="badge badge-danger">Hapus</a>
                    <?php endif ?>
                    <?php if ($t->dibayar == 'dibayar' && $t->status == 'selesai') : ?>
                        <a href="<?= base_url('C_Transaksi/ambil/' . $t->id_transaksi) ?>" onclick="return confirm('apa anda yakin barang akan diambil?')" class="badge badge-secondary">Ambil</a>
                    <?php endif ?>
                    <!-- <?php if ($t->dibayar == 'dibayar' && $t->dibayar == 'belum_dibayar' && $t->status == 'proses') : ?>
                        <a href="<?= base_url('C_Transaksi/hapus/' . $t->id_transaksi) ?>" onclick="return confirm('apa anda yakin? data dihapus?')" class="badge badge-danger">Hapus</a>
                    <?php endif ?> -->
                </td>
            </tr>
        <?php endforeach;
        ?>
    </table>
</div>