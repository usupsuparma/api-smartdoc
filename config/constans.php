<?php 
use App\Modules\OutgoingMail\Constans\OutgoingMailStatusConstants;
use App\Modules\IncomingMail\Constans\IncomingMailStatusConstans;
use App\Constants\EmailConstants;
use App\Constants\EmailInConstants;
use App\Constants\StatusApprovalConstants;
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
		'reject' => 'Data berhasil dikembalikan.',
		'publish' => 'Data berhasil diterbitkan.',
		'signed' => 'Berhasil melakukan tanda tangan.',
		'follow-up' => 'Berhasil melakukan tindak lanjut surat.',
		'sync' => 'Berhasil melakukan Sinkronisasi',
	], 
	'error' => [
		'logout' => 'Gagal melakukan logout.',
		'created' => 'Gagal melakukan menyimpan data.',
		'updated' => 'Gagal melakukan pembaharuan data.',
		'deleted' => 'Gagal melakukan penghapusan data.',
		'approve' => 'Gagal melakukan persetujuan data.',
		'generate' => 'Kunci Rahasia yang anda masukan salah. ',
		'publish' => 'Gagal melakukan penerbitan data. ',
	],
	'status-action' => [
		OutgoingMailStatusConstants::DRAFT => 'Draft',
		OutgoingMailStatusConstants::SEND_TO_REVIEW => 'Menunggu Pemeriksaan',
		OutgoingMailStatusConstants::REVIEW => 'Menunggu Diperiksa',
		OutgoingMailStatusConstants::APPROVED => 'Menunggu Ditandatangani',
		OutgoingMailStatusConstants::SIGNED => 'Menunggu Diterbitkan',
		OutgoingMailStatusConstants::PUBLISH => 'Diterbitkan'
	],
	'email' => [
		EmailConstants::REVIEW => 'Permintaan untuk proses pemeriksaan #category# (#subject#). Jika anda akan melakukan proses pemeriksaan, klik tombol di bawah ini. ',
		EmailConstants::APPROVED => '#category# (#subject#) telah disetujui. ',
		EmailConstants::REJECT => '#category# (#subject#) Telah ditolak / dikembalikan . harap periksa kembali surat tersebut.',
		EmailConstants::SIGNED => '#category# (#subject#) membutuhkan tanda tangan digital. Jika anda akan memberikan tanda tangan , klik link dibawah ini. ',
		EmailConstants::PUBLISH => '#category# (#subject#) sudah diterbitkan.',
		EmailConstants::PRE_PUBLISH => '#category# (#subject#) sudah ditandatangani dan siap diterbitkan.',
		EmailConstants::FOLLOW_UP => '#category# (#subject#) memerlukan tindak lanjut anda. ',
	],
	'notif-email' => [
		EmailConstants::REVIEW => 'Pemeriksaan Surat',
		EmailConstants::APPROVED => 'Persetujuan Surat',
		EmailConstants::SIGNED => 'Tanda Tangan Digital Surat',
		EmailConstants::PRE_PUBLISH => 'Persiapan Penerbitan Surat',
		EmailConstants::PUBLISH => 'Penerbitan Surat',
		EmailConstants::REJECT => 'Surat Ditolak',
		EmailConstants::FOLLOW_UP => 'Tindak Lanjut Surat',
	],
	'status-action-in' => [
		IncomingMailStatusConstans::DRAFT => 'Draft',
		IncomingMailStatusConstans::SEND => 'Menunggu Tindak Lanjut',
		IncomingMailStatusConstans::DISPOSITION => 'Disposisi',
		IncomingMailStatusConstans::FOLLOW_UP => 'Menunggu Tindak Lanjut',
		IncomingMailStatusConstans::DONE => 'Selesai'
	],
	'email-in' => [
		EmailInConstants::SEND => 'Permintaan untuk proses tindak lanjut #category# (#subject#). Jika anda akan melakukan proses tindak lanjut, klik tombol di bawah ini. ',
	],
	'notif-email-in' => [
		EmailInConstants::SEND => 'Tindak Lanjut Surat Disposisi'
	],
	'status-approval' => [
		StatusApprovalConstants::REJECT => 'Reject',
		StatusApprovalConstants::APPROVED => 'Approve'
	],
	'action-status' => [
		OutgoingMailStatusConstants::REVIEW => 'Review',
		OutgoingMailStatusConstants::APPROVED => 'Approved',
		OutgoingMailStatusConstants::SIGNED => 'Signed',
		OutgoingMailStatusConstants::PUBLISH => 'Publish'
	],
	'action-status-disposition' => [
		IncomingMailStatusConstans::DISPOSITION => 'In Progress',
		IncomingMailStatusConstans::DONE => 'Done'
	],
	'source-outgoing' => [
		OutgoingMailStatusConstants::INTERNAL => 'Internal',
		OutgoingMailStatusConstants::EXTERNAL => 'External'
	],
	'source-incoming' => [
		IncomingMailStatusConstans::INTERNAL => 'Internal',
		IncomingMailStatusConstans::EXTERNAL => 'External'
	],
];