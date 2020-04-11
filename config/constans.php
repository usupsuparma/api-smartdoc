<?php 
use App\Modules\OutgoingMail\Constans\OutgoingMailStatusConstants;

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
	], 
	'error' => [
		'logout' => 'Gagal melakukan logout.',
		'created' => 'Gagal melakukan menyimpan data.',
		'updated' => 'Gagal melakukan pembaharuan data.',
		'deleted' => 'Gagal melakukan penghapusan data.',
	],
	'status-action' => [
		OutgoingMailStatusConstants::DRAFT => 'Draft',
		OutgoingMailStatusConstants::SEND_TO_REVIEW => 'Menunggu Pemeriksaan',
		OutgoingMailStatusConstants::REVIEW => 'Sedang Diperiksa Oleh',
		OutgoingMailStatusConstants::APPROVED => 'Sudah Disetujui',
		OutgoingMailStatusConstants::SIGNED => 'Sudah Ditandatangan',
		OutgoingMailStatusConstants::PUBLISH => 'Diterbitkan'
	]
];