<?php

use Illuminate\Database\Seeder;

class TemplatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('templates')->delete();
        
        \DB::table('templates')->insert(array (
            0 => 
            array (
                'id' => 3,
                'name' => 'Template Surat Kuasa',
                'type_id' => 8,
                'template' => '<p style="text-align: center;"><strong>SURAT KUASA</strong><br /><strong>Nomor : #NOMORSURAT#</strong></p>
<p style="text-align: left;">&nbsp;</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 11.5228%; vertical-align: top;">Lampiran</td>
<td style="width: 88.4772%;">:&nbsp;</td>
</tr>
<tr>
<td style="width: 11.5228%; vertical-align: top;">Perihal</td>
<td style="width: 88.4772%;">: #SUBJECT#</td>
</tr>
</tbody>
</table>
<p><em>Dengan Hormat</em></p>
<p>Saya yang bertandatangan dibawah ini :</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 9.79695%;">Nama</td>
<td style="width: 90.203%;">:</td>
</tr>
<tr>
<td style="width: 9.79695%;">Jabatan</td>
<td style="width: 90.203%;">:</td>
</tr>
</tbody>
</table>
<p>Melalui surat ini memberikan kuasa kepada :</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 9.91736%; vertical-align: top;">Nama</td>
<td style="width: 90.0826%;">:&nbsp;</td>
</tr>
<tr>
<td style="width: 9.91736%; vertical-align: top;">Jabatan</td>
<td style="width: 90.0826%;">:&nbsp;</td>
</tr>
</tbody>
</table>
<p>Untuk..........................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................(Penjelasan surat kuasa).</p>
<p>Demikian surat tugas ini saya sampaikan, agar dapat digunakan sebagaimana mestinya.</p>
<p>Salam Penutup</p>
<p style="text-align: center;">Tempat, #TANGGALSURAT#</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 50%; text-align: center;">Pemberi Kuasa<br />Nama Jabatan<br /><br /><br /><strong>Nama Jabatan</strong></td>
<td style="width: 50%; text-align: center;">Penerima Kuasa<br />Nama Jabatan<br /><br /><br /><strong>Nama Jabatan</strong></td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<p>#TEMBUSAN#</p>',
                'status' => 1,
                'created_at' => '2020-04-19 14:01:08',
                'updated_at' => '2020-04-27 09:07:23',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 4,
                'name' => 'Template Surat Edaran',
                'type_id' => 1,
                'template' => '<p style="text-align: center;"><strong>SURAT EDARAN</strong><br /><strong>Nomor : #NOMORSURAT#</strong></p>
<p style="text-align: left;">&nbsp;</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 10.5076%;">Kepada</td>
<td style="width: 89.4924%;">:&nbsp;</td>
</tr>
<tr>
<td style="width: 10.5076%;">Dari</td>
<td style="width: 89.4924%;">:&nbsp;</td>
</tr>
<tr>
<td style="width: 10.5076%; vertical-align: top;">Perihal</td>
<td style="width: 89.4924%;">: #SUBJECT#</td>
</tr>
</tbody>
</table>
<p>Latar Belakang<br />a. ............................................<br />b. ............................................<br />c. ............................................</p>
<p>Diberitahukan :&nbsp;<br />..........................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................Isi_Surat_Edaran....................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................<br /><br /></p>
<p>Tempat, #TANGGALSURAT#<br />Nama Jabatan<br /><br /><br /><strong>Nama Jabatan</strong></p>
<p>&nbsp;</p>
<p>#TEMBUSAN#</p>',
                'status' => 1,
                'created_at' => '2020-04-25 14:43:43',
                'updated_at' => '2020-04-27 08:55:32',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 5,
                'name' => 'Template Surat Peringatan',
                'type_id' => 9,
                'template' => '<p style="text-align: center;"><strong>SURAT PERINGATAN 1/2/3</strong><br /><strong>Nomor : #NOMORSURAT#</strong></p>
<p style="text-align: left;">Diberikan kepada karyawan berikut :</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 12.4366%;"><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span>Nama</td>
<td style="width: 87.5634%;">:</td>
</tr>
<tr>
<td style="width: 12.4366%;"><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span>NIK</td>
<td style="width: 87.5634%;">:</td>
</tr>
<tr>
<td style="width: 12.4366%;"><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span>Jabatan</td>
<td style="width: 87.5634%;">:</td>
</tr>
</tbody>
</table>
<p style="text-align: justify;">Berdasarkan &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.. tentang hal-hal yang dapat di kenakan sanksi peringatan, pemotongan hak karyawan dan scorsing, maka dengan ini kami beritahukan bahwa sesuai dengan ketentuan yang berlaku, maka Saudara di beri <strong>SURAT PERINGATAN SATU/DUA/TIGA</strong> dikarenakan :</p>
<p>..................................................................................................................................ALASAN_PERINGATAN.......................................................................................................</p>
<p style="text-align: justify;">Surat peringatan ini berlaku selama 1 bulan dan apabila selama 1 bulan saudara masih melanggar maka akan di kenakan tindakan tegas. Sejak dikeluarkan dan ditetapkannya surat ini, Saudara akan menjadi perhatian khusus untuk penilaian <em>performance </em>kerja serta akan mempengaruhi untuk kenaikan atas hak karyawan dan kenaikan jabatannya.</p>
<p style="text-align: justify;">Demikian surat teguran ini kami sampaikan, untuk dapat diperhatikan dan semoga dapat memberi kebaikan bagi perusahaan ini kedepannya.</p>
<p style="text-align: justify;">Tempat, #TANGGALSURAT#<br />Nama Jabatan<br /><br /><br /><strong>Nama Jabatan</strong></p>
<p style="text-align: justify;">&nbsp;</p>
<p style="text-align: justify;">#TEMBUSAN#</p>',
                'status' => 1,
                'created_at' => '2020-04-25 15:34:37',
                'updated_at' => '2020-05-08 06:53:57',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 6,
                'name' => 'Template Surat Pengantar',
                'type_id' => 3,
                'template' => '<p style="text-align: center;"><strong>SURAT PENGANTAR</strong><br /><strong>Nomor : #NOMORSURAT#</strong></p>
<p style="text-align: left;">&nbsp;</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 12.6396%;">Kepada</td>
<td style="width: 87.3604%;">:</td>
</tr>
<tr>
<td style="width: 12.6396%;">Dari</td>
<td style="width: 87.3604%;">:</td>
</tr>
<tr>
<td style="width: 12.6396%;">Lampiran</td>
<td style="width: 87.3604%;">:</td>
</tr>
<tr>
<td style="width: 12.6396%;">Perihal</td>
<td style="width: 87.3604%;">: #SUBJECT#</td>
</tr>
</tbody>
</table>
<p><em>Dengan Hormat</em></p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 3.71901%; vertical-align: top;">1.</td>
<td style="width: 96.281%;">Latar Belakang<br />. . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .</td>
</tr>
<tr>
<td style="width: 3.71901%; vertical-align: top;">2.</td>
<td style="width: 96.281%;">Isi<br />. . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .</td>
</tr>
<tr>
<td style="width: 3.71901%; vertical-align: top;">3.</td>
<td style="width: 96.281%;">Penutup<br />. . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .</td>
</tr>
</tbody>
</table>
<p>Tempat, #TANGGALSURAT#<br />Nama Pegawai<br /><br /><br /><strong>Nama Pegawai</strong></p>
<p>&nbsp;</p>
<p>#TEMBUSAN#</p>
<p>&nbsp;</p>',
                'status' => 1,
                'created_at' => '2020-04-25 15:53:56',
                'updated_at' => '2020-04-27 07:15:18',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 7,
                'name' => 'Template Surat Pernyataan',
                'type_id' => 4,
                'template' => '<p style="text-align: center;"><strong>SURAT PERNYATAAN</strong><br /><strong>Nomor : #NOMORSURAT#</strong></p>
<p style="text-align: left;">Yang bertandatangan dibawah ini :</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 14.5685%;"><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span>Nama</td>
<td style="width: 85.4315%;">:&nbsp;</td>
</tr>
<tr>
<td style="width: 14.5685%;"><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span>NIK</td>
<td style="width: 85.4315%;">:&nbsp;</td>
</tr>
<tr>
<td style="width: 14.5685%;"><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span>Jabatan</td>
<td style="width: 85.4315%;">:&nbsp;</td>
</tr>
</tbody>
</table>
<p>Menyatakan dibawah ini <em>(penjelasan pernyataan dapat berupa deskripsi atau point)<br />...........................................................................................................................................................................................................................................................................................................................................................................................................Penjelasan_Pernyataan................................................................................................................................................................................................................................................................................................................................................................................</em></p>
<p>Demikian surat penyataan ini saya buat dengan kesadaran penuh, tidak ada unsur paksaan, dan bersedia menerima konsekuensi apabila pernyataan yang saya buat tidak benar.</p>
<p>Tempat, #TANGGALSURAT#<br />Nama Jabatan<br /><br /><br /><strong>Nama Jabatan</strong></p>
<p>&nbsp;</p>
<p>#TEMBUSAN#</p>',
                'status' => 1,
                'created_at' => '2020-04-25 16:09:18',
                'updated_at' => '2020-04-27 07:05:34',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 8,
                'name' => 'Template Surat Keterangan',
                'type_id' => 2,
                'template' => '<p style="text-align: center;"><strong>SURAT KETERANGAN</strong><br /><strong>Nomor : #NOMORSURAT#</strong></p>
<p style="text-align: left;">Yang bertanda tangan dibawah ini :&nbsp;<br /></p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 12.4365%;"><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span>Nama</td>
<td style="width: 87.5635%;">:&nbsp;</td>
</tr>
<tr>
<td style="width: 12.4365%;"><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span>Jabatan</td>
<td style="width: 87.5635%;">:&nbsp;</td>
</tr>
</tbody>
</table>
<p style="text-align: left;">Menerapkan bahwa benar yang bersangkutan dibawah ini :</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 12.6396%;"><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span>Nama</td>
<td style="width: 87.3604%;">:&nbsp;</td>
</tr>
<tr>
<td style="width: 12.6396%;"><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span>NIK</td>
<td style="width: 87.3604%;">:&nbsp;</td>
</tr>
</tbody>
</table>
<p><em>.....................................................................................................................................................................................................................................................................................................................................................................................................................Penjelasan_Keterangan..................................................................................................................................................................................................................................................................</em></p>
<p>Demikian surat keterangan ini kami sampaikan untuk dapat dipergunakan sebagaimana mestinya.</p>
<p>Tempat, #TANGGALSURAT#<br />Nama Jabatan<br /><br /><br /><strong>Nama Jabatan</strong></p>
<p>&nbsp;</p>
<p>#TEMBUSAN#</p>',
                'status' => 1,
                'created_at' => '2020-04-25 16:21:16',
                'updated_at' => '2020-04-27 06:59:53',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 9,
                'name' => 'Template Surat Teguran',
                'type_id' => 5,
                'template' => '<p style="text-align: center;"><strong>SURAT TEGURAN</strong><br /><strong>Nomor : #NOMORSURAT#</strong></p>
<p style="text-align: left;">Diberikan kepada karyawan berikut :<br /></p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 14.1625%;"><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span>Nama</td>
<td style="width: 85.8375%;">:&nbsp;</td>
</tr>
<tr>
<td style="width: 14.1625%;"><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span>NIK</td>
<td style="width: 85.8375%;">:&nbsp;</td>
</tr>
<tr>
<td style="width: 14.1625%;"><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span><span class="mce-nbsp-wrap" contenteditable="false">&nbsp;&nbsp;&nbsp;</span>Jabatan</td>
<td style="width: 85.8375%;">:&nbsp;</td>
</tr>
</tbody>
</table>
<p style="text-align: justify;">Berdasarkan &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.. tentang hal-hal yang dapat di kenakan sanksi teguran, peringatan, pemotongan hak karyawan dan scorsing, maka dengan ini kami beritahukan bahwa sesuai dengan ketentuan yang berlaku, maka Saudara di beri <strong>Surat Teguran Ketiga</strong> dikarenakan :</p>
<p style="text-align: justify;"><strong>Alasan teguran ........................................................................................................................................................................</strong></p>
<p>Surat teguran ini berlaku selama 1 bulan dan apabila selama 1 bulan saudara masih melanggar maka akan di kenakan tindakan tegas. Sejak dikeluarkan dan ditetapkannya surat ini, Saudara akan menjadi perhatian khusus untuk penilaian <em>performance </em>kerja serta akan mempengaruhi untuk kenaikan atas hak karyawan dan kenaikan jabatannya.</p>
<p>Demikian surat teguran ini kami sampaikan, untuk dapat diperhatikan dan semoga dapat memberi kebaikan bagi perusahaan ini kedepannya.</p>
<p>Tempat, #TANGGALSURAT#<br />Nama Jabatan<br /><br /><br /><strong>Nama Jabatan</strong></p>
<p>&nbsp;</p>
<p>#TEMBUSAN#</p>
<p style="text-align: left;">&nbsp;</p>',
                'status' => 1,
                'created_at' => '2020-04-25 21:39:55',
                'updated_at' => '2020-04-27 06:55:33',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 10,
                'name' => 'Template Surat Tugas',
                'type_id' => 6,
                'template' => '<p style="text-align: center;"><strong>SURAT TUGAS</strong><br /><strong>Nomor : #NOMORSURAT#</strong></p>
<p style="text-align: left;">Tempat, #TANGGALSURAT#</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 11.0152%;">Lampiran</td>
<td style="width: 88.9848%;">:</td>
</tr>
<tr>
<td style="width: 11.0152%;">Perihal</td>
<td style="width: 88.9848%;">: #SUBJECT#</td>
</tr>
</tbody>
</table>
<p style="font-family: \'Edwardian Script ITC\';"><span style="font-size: 14pt;"><em>Dengan Hormat</em></span></p>
<p>Saya yang bertanda tangan dibawah ini :</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 10.9137%;">Nama</td>
<td style="width: 89.0863%;">:</td>
</tr>
<tr>
<td style="width: 10.9137%;">Jabatan</td>
<td style="width: 89.0863%;">:</td>
</tr>
</tbody>
</table>
<p>Melalui surat ini memberikan tugas kepada :</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 10.9504%;">Nama</td>
<td style="width: 89.0496%;">:</td>
</tr>
<tr>
<td style="width: 10.9504%;">Jabatan</td>
<td style="width: 89.0496%;">:</td>
</tr>
</tbody>
</table>
<p>Untuk..........................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................penjelasan tugas yang diberikan</p>
<p>Demikian surat tugas ini saya sampaikan, agar dapat digunakan sebagaimana mestinya.</p>
<p>Nama Jabatan<br /><br /></p>
<p><strong>Nama Jabatan</strong></p>
<p>&nbsp;</p>
<p>#TEMBUSAN#</p>',
                'status' => 1,
                'created_at' => '2020-04-25 21:47:57',
                'updated_at' => '2020-08-04 20:36:06',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 11,
                'name' => 'Template Surat Resmi Lainnya',
                'type_id' => 7,
                'template' => '<p>Tempat, #TANGGALSURAT#</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 12.5381%;">Nomor</td>
<td style="width: 87.4619%;">: #NOMORSURAT#</td>
</tr>
<tr>
<td style="width: 12.5381%;">Lampiran</td>
<td style="width: 87.4619%;">:&nbsp;</td>
</tr>
<tr>
<td style="width: 12.5381%;">Perihal</td>
<td style="width: 87.4619%;">: #SUBJECT#</td>
</tr>
</tbody>
</table>
<p>Kepada Yth.<br /><strong>Nama yang dituju<br /></strong>Di<br /><strong>Tempat</strong></p>
<p><em>Dengan Hormat,<br />............................................................................................................................Alinea_Pembuka..............................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................Alinea_Isi.................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................</em></p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 18.5951%;">Pada hari, tanggal</td>
<td style="width: 81.4049%;">:&nbsp;</td>
</tr>
<tr>
<td style="width: 18.5951%;">Waktu</td>
<td style="width: 81.4049%;">:&nbsp;</td>
</tr>
<tr>
<td style="width: 18.5951%;">Tempat</td>
<td style="width: 81.4049%;">:&nbsp;</td>
</tr>
</tbody>
</table>
<p>Nama Jabatan<br /><br /><em>(Tanda tangan dan cap)<br /><br /></em><strong>Nama Jabatan</strong></p>
<p>&nbsp;</p>
<p>#TEMBUSAN#</p>
<p>&nbsp;</p>
<p>Tempat, #TANGGALSURAT#</p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 11.4669%;">Nomor</td>
<td style="width: 88.5331%;">: #NOMORSURAT#</td>
</tr>
<tr>
<td style="width: 11.4669%;">Perihal</td>
<td style="width: 88.5331%;">: #SUBJECT#</td>
</tr>
</tbody>
</table>
<p><strong>LAMPIRAN 1 (SATU)</strong><br />Kepada Yth :<br />1 .......................................<br />2 .......................................<br />3 .......................................<br /></p>',
                'status' => 1,
                'created_at' => '2020-04-25 22:02:22',
                'updated_at' => '2020-04-27 06:38:24',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 12,
                'name' => 'Template Nota Dinas',
                'type_id' => 10,
                'template' => '<p style="text-align: center;"><strong>NOTA DINAS</strong><br /><strong>Nomor : #NOMORSURAT#<br /></strong></p>
<table style="border-collapse: collapse; width: 100%;" border="0">
<tbody>
<tr>
<td style="width: 17.1066%;"><strong>Kepada Yth</strong></td>
<td style="width: 82.8934%;"><strong>:&nbsp;</strong></td>
</tr>
<tr>
<td style="width: 17.1066%;"><strong>Dari</strong></td>
<td style="width: 82.8934%;"><strong>:&nbsp;</strong></td>
</tr>
<tr>
<td style="width: 17.1066%;"><strong>Perihal</strong></td>
<td style="width: 82.8934%;"><strong>: #SUBJECT#</strong></td>
</tr>
<tr>
<td style="width: 17.1066%;"><strong>Lampiran</strong></td>
<td style="width: 82.8934%;"><strong>:&nbsp;</strong></td>
</tr>
</tbody>
</table>
<div style="padding: 25px 0px 25px 0px;"><hr /></div>
<ol>
<li>Menunjuk pada Petunjuk Teknis Nomor SOP10.3/SP/VI/2017 perihal Penyusunan Laporan PT Bandarudara Internasional Jawa Barat, Sebagai bentuk transparansi kepada <em>stakeholder </em>dan <em>shareholder </em>atas kinerja perseroan untuk tahun buku 2018 maka perlu dilakukan penyusunan Laporan Manajemen dan <em>Annual Report;</em></li>
<li>Sehubungan dengan telah terselesaikannya penyusunan laporan tahunan PT BIJB tahun buku 2018 tersebut, berikut kami lampirkan 1 (satu) berkas Annual Report PT BIJB tahun buku 2018, mohon arahan dan persetujuan agar laporan tersebut dapat dicetak dan didistribusikan kepada stakeholder, shareholder, serta informasi publik;</li>
<li>Demikian kami sampaikan, atas perhatian dan perkenannya diucapkan terima kasih.</li>
</ol>
<p>&nbsp;</p>
<p>Tempat, #TANGGALSURAT#<br />Nama Jabatan<br /><br /><br /><strong>Nama Jabatan</strong></p>
<p>&nbsp;</p>
<p>#TEMBUSAN#</p>',
                'status' => 1,
                'created_at' => '2020-04-30 19:54:57',
                'updated_at' => '2020-05-01 09:51:09',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}