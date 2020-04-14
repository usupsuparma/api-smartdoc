<?php 
use App\Modules\OutgoingMail\Constans\OutgoingMailStatusConstants;
use App\Constants\EmailConstants;

return [
	'success' => [
		'created' => 'Data berhasil disimpan.',
		'updated' => 'Data berhasil diperbarui.',
		'deleted' => 'Data berhasil dihapus.',
		'approve' => 'Data berhasil disetujui.',
		'disposition' => 'Berhasil melakukan disposisi surat.',
		'decline' => 'Data yang diajukan berhasil dikembalikan.',
		'login' => 'Berhasil login.',
		'logout' => 'Berhasil logout.',
		'ordering' => 'Berhasil melakukan penyusunan menu.',
		'download' => 'Berhasil melakukan download file.',
		'generate' => 'Berhasil membuat sertifikat file.',
	], 
	'error' => [
		'logout' => 'Gagal melakukan logout.',
		'created' => 'Gagal melakukan menyimpan data.',
		'updated' => 'Gagal melakukan pembaharuan data.',
		'deleted' => 'Gagal melakukan penghapusan data.',
		'generate' => 'Kunci Rahasia yang anda masukan salah. ',
	],
	'status-action' => [
		OutgoingMailStatusConstants::DRAFT => 'Draft',
		OutgoingMailStatusConstants::SEND_TO_REVIEW => 'Menunggu Pemeriksaan',
		OutgoingMailStatusConstants::REVIEW => 'Sedang Diperiksa Oleh',
		OutgoingMailStatusConstants::APPROVED => 'Sudah Disetujui',
		OutgoingMailStatusConstants::SIGNED => 'Sudah Ditandatangan',
		OutgoingMailStatusConstants::PUBLISH => 'Diterbitkan'
	],
	'email' => [
		EmailConstants::REVIEW => 'Permintaan untuk proses pemeriksaan #category# (#subject#). Jika anda akan melakukan proses pemeriksaan, klik tombol di bawah ini. ',
		EmailConstants::APPROVED => '#category# (#subject#) telah disetujui. ',
		EmailConstants::REJECT => '#category# (#subject#) Telah ditolak / dikembalikan . harap periksa kembali surat tersebut.',
		EmailConstants::SIGNED => '#category# (#subject#) membutuhkan tanda tangan digital. Jika anda akan memberikan tanda tangan , klik link dibawah ini. ',
		EmailConstants::PUBLISH => '#category# (#subject#) sudah diterbitkan.',
	],
	'notif-email' => [
		EmailConstants::REVIEW => 'Pemeriksaan Surat',
		EmailConstants::APPROVED => 'Persetujuan Surat',
		EmailConstants::SIGNED => 'Tanda Tangan Digital Surat',
		EmailConstants::PUBLISH => 'Penerbitan Surat',
		EmailConstants::REJECT => 'Surat Ditolak' 
	]
];