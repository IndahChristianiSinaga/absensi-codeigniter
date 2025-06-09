<?php

use App\Libraries\enums\TipeUser;

switch ($type) {
   case TipeUser::Siswa:
?>
      <h3 class="text-success">Absen <?= $waktu; ?> berhasil</h3>
      <div class="row w-100">
         <div class="col">
            <p>Nama : <b><?= $data['nama_siswa']; ?></b></p>
            <p>NIS : <b><?= $data['nis']; ?></b></p>
            <p>Kelas : <b><?= $data['kelas']  . ' ' . $data['jurusan']; ?></b></p>
         </div>
         <div class="col">
            <?= jam($presensi, $waktu); ?>
         </div>
      </div>
   <?php break;

   case TipeUser::Guru:
   ?>
      <h3 class="text-success">Absen <?= $waktu; ?> berhasil</h3>
      <div class="row w-100">
         <div class="col">
            <p>Nama : <b><?= $data['nama_guru']; ?></b></p>
            <p>NUPTK : <b><?= $data['nuptk']; ?></b></p>
            <p>No HP : <b><?= $data['no_hp']; ?></b></p>
         </div>
         <div class="col">
            <?= jam($presensi, $waktu); ?>
         </div>
      </div>
   <?php break;

   default:
   ?>
      <h3 class="text-danger">Tipe tidak valid</h3>
   <?php
      break;
}

function jam($presensi, $waktu)
{
   $jamMasuk  = $presensi['jam_masuk'] ?? null;
   $jamPulang = $presensi['jam_keluar'] ?? null;
   $jamIdeal  = "07:00:00";

   $status = "-";

   if ($waktu === 'masuk' && $jamMasuk) {
      $masuk = strtotime($jamMasuk);
      $ideal = strtotime($jamIdeal);
      if ($masuk > $ideal) {
         $selisihMenit = round(($masuk - $ideal) / 60);
         $status = "Terlambat {$selisihMenit} menit";
      } else {
         $status = "Tepat Waktu";
      }
   }

   // Mulai tangkap output ke dalam variabel
   ob_start();
   ?>
   <p>Jam masuk : <b class="text-info"><?= $jamMasuk ?? '-' ?></b></p>
   <p>Jam pulang : <b class="text-info"><?= $jamPulang ?? '-' ?></b></p>
   <?php if ($waktu === 'masuk'): ?>
      <p>Status masuk :
         <b class="<?= ($status === 'Tepat Waktu') ? 'text-success' : 'text-danger' ?>">
            <?= $status ?>
         </b>
      </p>
   <?php endif; ?>
   <?php
   // Ambil isi output dan kembalikan sebagai string
   return ob_get_clean();
}
?>
