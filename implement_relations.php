<?php
/**
 * IMPLEMENTASI RELASI DATABASE DALAM CODEIGNITER
 * File ini berisi contoh implementasi relasi antar tabel
 */

// =====================================================
// 1. MODEL DENGAN RELASI
// =====================================================

/**
 * Enhanced Transaksi Model dengan Relasi
 */
class Enhanced_Transaksimodel extends CI_Model {
    
    /**
     * Get transaksi dengan semua relasi
     */
    public function getTransaksiWithRelations() {
        $this->db->select('
            t.idtransaksi,
            t.namapelanggan,
            t.noktp,
            t.nohp,
            t.alamat,
            t.tglsewa,
            t.tglkembali,
            t.selisih,
            t.total,
            t.sttransaksi,
            t.date,
            
            m.idmobil,
            m.type as mobil_type,
            m.platnomer,
            m.tarif as mobil_tarif,
            m.stmobil,
            
            mk.idmerk,
            mk.namamerk,
            
            s.idsupir,
            s.namasupir,
            s.tarif as supir_tarif,
            
            CONCAT(mk.namamerk, " - ", m.type) as mobil_lengkap,
            COALESCE(s.namasupir, "Lepas Kunci") as supir_lengkap
        ');
        
        $this->db->from('transaksi t');
        $this->db->join('mobil m', 'm.idmobil = t.idmobil', 'left');
        $this->db->join('merk mk', 'mk.idmerk = m.idmerk', 'left');
        $this->db->join('supir s', 's.idsupir = t.idsupir', 'left');
        $this->db->order_by('t.idtransaksi', 'DESC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Get transaksi by ID dengan relasi
     */
    public function getTransaksiById($id) {
        $this->db->select('
            t.*,
            m.type as mobil_type,
            m.platnomer,
            mk.namamerk,
            s.namasupir,
            CONCAT(mk.namamerk, " - ", m.type) as mobil_lengkap
        ');
        
        $this->db->from('transaksi t');
        $this->db->join('mobil m', 'm.idmobil = t.idmobil', 'left');
        $this->db->join('merk mk', 'mk.idmerk = m.idmerk', 'left');
        $this->db->join('supir s', 's.idsupir = t.idsupir', 'left');
        $this->db->where('t.idtransaksi', $id);
        
        return $this->db->get()->row();
    }
    
    /**
     * Get mobil yang tersedia dengan merk
     */
    public function getMobilTersedia() {
        $this->db->select('
            m.idmobil,
            m.type,
            m.tarif,
            m.kursi,
            mk.namamerk,
            CONCAT(mk.namamerk, " - ", m.type) as mobil_lengkap
        ');
        
        $this->db->from('mobil m');
        $this->db->join('merk mk', 'mk.idmerk = m.idmerk', 'left');
        $this->db->where('m.stmobil', 'bebas');
        $this->db->order_by('mk.namamerk', 'ASC');
        $this->db->order_by('m.type', 'ASC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Insert transaksi dengan update status mobil
     */
    public function insertTransaksiWithRelation($data) {
        // Start transaction
        $this->db->trans_start();
        
        // Insert transaksi
        $this->db->insert('transaksi', $data);
        $transaksi_id = $this->db->insert_id();
        
        // Update status mobil menjadi 'jalan'
        $this->db->where('idmobil', $data['idmobil']);
        $this->db->update('mobil', array('stmobil' => 'jalan'));
        
        // Complete transaction
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        }
        
        return $transaksi_id;
    }
    
    /**
     * Selesaikan transaksi dengan update status mobil
     */
    public function selesaikanTransaksi($id) {
        // Get transaksi data
        $transaksi = $this->db->get_where('transaksi', array('idtransaksi' => $id))->row();
        
        if (!$transaksi) {
            return FALSE;
        }
        
        // Start transaction
        $this->db->trans_start();
        
        // Update status transaksi
        $this->db->where('idtransaksi', $id);
        $this->db->update('transaksi', array('sttransaksi' => 'selesai'));
        
        // Update status mobil menjadi 'bebas'
        $this->db->where('idmobil', $transaksi->idmobil);
        $this->db->update('mobil', array('stmobil' => 'bebas'));
        
        // Complete transaction
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
}

/**
 * Enhanced Mobil Model dengan Relasi
 */
class Enhanced_Mobilmodel extends CI_Model {
    
    /**
     * Get mobil dengan merk
     */
    public function getMobilWithMerk() {
        $this->db->select('
            m.*,
            mk.namamerk,
            CONCAT(mk.namamerk, " - ", m.type) as mobil_lengkap
        ');
        
        $this->db->from('mobil m');
        $this->db->join('merk mk', 'mk.idmerk = m.idmerk', 'left');
        $this->db->order_by('mk.namamerk', 'ASC');
        $this->db->order_by('m.type', 'ASC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Get statistik mobil per merk
     */
    public function getStatistikPerMerk() {
        $this->db->select('
            mk.namamerk,
            COUNT(m.idmobil) as total_mobil,
            SUM(CASE WHEN m.stmobil = "bebas" THEN 1 ELSE 0 END) as tersedia,
            SUM(CASE WHEN m.stmobil = "jalan" THEN 1 ELSE 0 END) as sedang_jalan
        ');
        
        $this->db->from('merk mk');
        $this->db->join('mobil m', 'mk.idmerk = m.idmerk', 'left');
        $this->db->group_by('mk.idmerk, mk.namamerk');
        $this->db->order_by('mk.namamerk', 'ASC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Get history transaksi mobil
     */
    public function getHistoryTransaksi($idmobil) {
        $this->db->select('
            t.idtransaksi,
            t.namapelanggan,
            t.tglsewa,
            t.tglkembali,
            t.selisih,
            t.total,
            t.sttransaksi,
            s.namasupir
        ');
        
        $this->db->from('transaksi t');
        $this->db->join('supir s', 's.idsupir = t.idsupir', 'left');
        $this->db->where('t.idmobil', $idmobil);
        $this->db->order_by('t.tglsewa', 'DESC');
        
        return $this->db->get()->result();
    }
}

// =====================================================
// 2. CONTROLLER DENGAN RELASI
// =====================================================

/**
 * Enhanced Transaksi Controller
 */
class Enhanced_Transaksi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Enhanced_Transaksimodel', 'transaksi_model');
        $this->load->model('Enhanced_Mobilmodel', 'mobil_model');
    }
    
    /**
     * Index dengan data relasi lengkap
     */
    public function index() {
        $data['transaksi'] = $this->transaksi_model->getTransaksiWithRelations();
        $data['mobil'] = $this->transaksi_model->getMobilTersedia();
        $data['supir'] = $this->transaksi_model->getSupir();
        $data['content'] = 'transaksi/enhanced_view';
        
        $this->load->view('template/template', $data);
    }
    
    /**
     * Detail transaksi dengan relasi
     */
    public function detail($id) {
        $data['transaksi'] = $this->transaksi_model->getTransaksiById($id);
        
        if (!$data['transaksi']) {
            show_404();
        }
        
        $data['content'] = 'transaksi/detail';
        $this->load->view('template/template', $data);
    }
    
    /**
     * Laporan dengan relasi
     */
    public function laporan() {
        // Laporan transaksi per bulan
        $data['laporan_bulanan'] = $this->getLaporanBulanan();
        
        // Laporan mobil terpopuler
        $data['mobil_populer'] = $this->getMobilPopuler();
        
        // Statistik per merk
        $data['statistik_merk'] = $this->mobil_model->getStatistikPerMerk();
        
        $data['content'] = 'laporan/dashboard';
        $this->load->view('template/template', $data);
    }
    
    private function getLaporanBulanan() {
        $this->db->select('
            YEAR(t.tglsewa) as tahun,
            MONTH(t.tglsewa) as bulan,
            COUNT(t.idtransaksi) as total_transaksi,
            SUM(t.total) as total_pendapatan,
            COUNT(DISTINCT t.idmobil) as mobil_disewa
        ');
        
        $this->db->from('transaksi t');
        $this->db->where('t.tglsewa >=', date('Y-01-01'));
        $this->db->group_by('YEAR(t.tglsewa), MONTH(t.tglsewa)');
        $this->db->order_by('tahun DESC, bulan DESC');
        
        return $this->db->get()->result();
    }
    
    private function getMobilPopuler() {
        $this->db->select('
            mk.namamerk,
            m.type,
            m.platnomer,
            COUNT(t.idtransaksi) as total_sewa,
            SUM(t.total) as total_pendapatan,
            CONCAT(mk.namamerk, " - ", m.type) as mobil_lengkap
        ');
        
        $this->db->from('transaksi t');
        $this->db->join('mobil m', 'm.idmobil = t.idmobil');
        $this->db->join('merk mk', 'mk.idmerk = m.idmerk');
        $this->db->group_by('t.idmobil');
        $this->db->order_by('total_sewa', 'DESC');
        $this->db->limit(10);
        
        return $this->db->get()->result();
    }
}

// =====================================================
// 3. HELPER FUNCTIONS
// =====================================================

/**
 * Helper untuk validasi relasi
 */
class Relation_Helper {
    
    private $CI;
    
    public function __construct() {
        $this->CI =& get_instance();
    }
    
    /**
     * Cek apakah mobil bisa dihapus
     */
    public function canDeleteMobil($idmobil) {
        $this->CI->db->where('idmobil', $idmobil);
        $this->CI->db->where('sttransaksi', 'mulai');
        $count = $this->CI->db->count_all_results('transaksi');
        
        return $count == 0;
    }
    
    /**
     * Cek apakah merk bisa dihapus
     */
    public function canDeleteMerk($idmerk) {
        $this->CI->db->where('idmerk', $idmerk);
        $count = $this->CI->db->count_all_results('mobil');
        
        return $count == 0;
    }
    
    /**
     * Get referensi yang menghalangi penghapusan
     */
    public function getDeleteRestrictions($table, $id) {
        $restrictions = array();
        
        switch($table) {
            case 'merk':
                $this->CI->db->where('idmerk', $id);
                $mobil_count = $this->CI->db->count_all_results('mobil');
                if ($mobil_count > 0) {
                    $restrictions[] = "$mobil_count mobil masih menggunakan merk ini";
                }
                break;
                
            case 'mobil':
                $this->CI->db->where('idmobil', $id);
                $this->CI->db->where('sttransaksi', 'mulai');
                $transaksi_count = $this->CI->db->count_all_results('transaksi');
                if ($transaksi_count > 0) {
                    $restrictions[] = "$transaksi_count transaksi aktif menggunakan mobil ini";
                }
                break;
                
            case 'supir':
                $this->CI->db->where('idsupir', $id);
                $this->CI->db->where('sttransaksi', 'mulai');
                $transaksi_count = $this->CI->db->count_all_results('transaksi');
                if ($transaksi_count > 0) {
                    $restrictions[] = "$transaksi_count transaksi aktif menggunakan supir ini";
                }
                break;
        }
        
        return $restrictions;
    }
}

// =====================================================
// 4. MIGRATION SCRIPT
// =====================================================

/**
 * Migration untuk menambahkan foreign keys
 */
class Migration_Add_Foreign_Keys extends CI_Migration {
    
    public function up() {
        // Add foreign key: mobil.idmerk -> merk.idmerk
        $this->db->query('
            ALTER TABLE `mobil` 
            ADD CONSTRAINT `fk_mobil_merk` 
            FOREIGN KEY (`idmerk`) REFERENCES `merk`(`idmerk`) 
            ON DELETE RESTRICT ON UPDATE CASCADE
        ');
        
        // Add foreign key: transaksi.idmobil -> mobil.idmobil
        $this->db->query('
            ALTER TABLE `transaksi` 
            ADD CONSTRAINT `fk_transaksi_mobil` 
            FOREIGN KEY (`idmobil`) REFERENCES `mobil`(`idmobil`) 
            ON DELETE RESTRICT ON UPDATE CASCADE
        ');
        
        // Add foreign key: transaksi.idsupir -> supir.idsupir
        $this->db->query('
            ALTER TABLE `transaksi` 
            ADD CONSTRAINT `fk_transaksi_supir` 
            FOREIGN KEY (`idsupir`) REFERENCES `supir`(`idsupir`) 
            ON DELETE SET NULL ON UPDATE CASCADE
        ');
        
        // Add indexes for performance
        $this->db->query('CREATE INDEX `idx_mobil_idmerk` ON `mobil`(`idmerk`)');
        $this->db->query('CREATE INDEX `idx_transaksi_idmobil` ON `transaksi`(`idmobil`)');
        $this->db->query('CREATE INDEX `idx_transaksi_idsupir` ON `transaksi`(`idsupir`)');
    }
    
    public function down() {
        // Remove foreign keys
        $this->db->query('ALTER TABLE `mobil` DROP FOREIGN KEY `fk_mobil_merk`');
        $this->db->query('ALTER TABLE `transaksi` DROP FOREIGN KEY `fk_transaksi_mobil`');
        $this->db->query('ALTER TABLE `transaksi` DROP FOREIGN KEY `fk_transaksi_supir`');
        
        // Remove indexes
        $this->db->query('DROP INDEX `idx_mobil_idmerk` ON `mobil`');
        $this->db->query('DROP INDEX `idx_transaksi_idmobil` ON `transaksi`');
        $this->db->query('DROP INDEX `idx_transaksi_idsupir` ON `transaksi`');
    }
}

?>