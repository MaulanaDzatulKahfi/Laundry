<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_crud extends CI_Model
{
    public function tampildata($table)
    {
        return $this->db->get($table)->result();
    }
    public function tambahdata($table, $data)
    {
        return $this->db->insert($table, $data);
    }
    public function formeditdata($nama_table, $idkey, $id)
    {
        return $this->db->get_where($nama_table, [$idkey => $id])->row();
    }
    public function editdata($nama_table, $idkey, $id, $data)
    {
        return $this->db->where($idkey, $id)->update($nama_table, $data);
    }
    public function hapusdata($nama_table, $idkey, $id)
    {
        return $this->db->delete($nama_table, [$idkey => $id]);
    }
    public function tampiljoin($tableawal, $tablekedua, $idgabung)
    {
        // SELECT * LEFT JOIN `user` ON `transaksi`.`id_user`=`user`.`id_user` ORDER BY `id_transaksi` DESC
        $query = $this->db->select('*')
            ->from($tableawal)
            ->join($tablekedua, '' . $tablekedua . '.' . $idgabung . '=' . $tableawal . '.' . $idgabung . '', 'left')
            ->get();
        return $query->result();
    }
    public function tampiljoin_where($tableawal, $tablekedua,  $idgabung, $where)
    {
        $query = $this->db->select('*')
            ->from($tableawal)
            ->where($where)
            ->join($tablekedua, '' . $tablekedua . '.' . $idgabung . '=' . $tableawal . '.' . $idgabung . '', 'left')
            ->get();
        return $query->result();
    }
    public function join4()
    {
        $query = $this->db->select('*')
            ->from('transaksi')
            ->join('pelanggan', 'pelanggan.id_pelanggan=transaksi.id_pelanggan', 'left')
            ->join('user', 'user.id_user=transaksi.id_user', 'left')
            ->join('outlet', 'outlet.id_outlet=transaksi.id_outlet', 'left')
            ->get();
        return $query->result();
    }
    public function join4_where($where)
    {
        $query = $this->db->select('*')
            ->from('transaksi')
            ->where($where)
            ->join('pelanggan', 'pelanggan.id_pelanggan=transaksi.id_pelanggan', 'left')
            ->join('user', 'user.id_user=transaksi.id_user', 'left')
            ->join('outlet', 'outlet.id_outlet=transaksi.id_outlet', 'left')
            ->get();
        return $query->result();
    }
    public function join3($id)
    {
        $query = $this->db->select('*')
            ->from('detail_transaksi')
            ->where('detail_transaksi.id_transaksi', $id)
            ->join('paket', 'paket.id_paket=detail_transaksi.id_paket', 'left')
            ->join('transaksi', 'transaksi.id_transaksi=detail_transaksi.id_transaksi', 'left')
            ->get()->result();
        return $query;
    }
    public function ket_join3($id)
    {
        $query = $this->db->select('*')
            ->from('detail_transaksi')
            ->where('detail_transaksi.id_transaksi', $id)
            ->join('paket', 'paket.id_paket=detail_transaksi.id_paket', 'left')
            ->join('transaksi', 'transaksi.id_transaksi=detail_transaksi.id_transaksi', 'left')
            ->get()->row();
        return $query;
    }
    public function search($table, $where, $field1, $field2, $field3, $key)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $this->db->like($field1, $key);
        $this->db->or_like($field2, $key);
        $this->db->or_like($field3, $key);
        return $this->db->get()->result();
    }
    function get_invoice()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(kode_invoice,4)) AS kd_max FROM transaksi WHERE DATE(tgl)=CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return date('dmy') . $kd;
    }
}
