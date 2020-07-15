<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Company Name',
                'code' => 'COMPANY_NAME',
            'value' => 'PT Bandarudara Internasional Jawa Barat (PERSERODA)',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-21 09:30:41',
                'updated_at' => '2020-03-21 09:30:41',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Surat Masuk',
                'code' => 'SURAT_MASUK',
                'value' => 'IM',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-21 09:38:43',
                'updated_at' => '2020-03-21 09:38:43',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Surat Keluar',
                'code' => 'SURAT_KELUAR',
                'value' => 'OM',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-21 09:39:00',
                'updated_at' => '2020-03-21 09:39:00',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Disposisi',
                'code' => 'DISPOSISI',
                'value' => 'DISPO',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-21 09:39:36',
                'updated_at' => '2020-03-21 09:39:36',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Default Select Type',
                'code' => 'SELECT_TYPE',
                'value' => 'Pilih Jenis Surat',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-21 21:27:37',
                'updated_at' => '2020-03-21 21:27:37',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Available Digital Signature',
                'code' => 'AVAILABLE_SIGNATURE',
                'value' => 'true',
                'description' => 'SETUP Digital SIgnature',
                'status' => 1,
                'created_at' => '2020-03-26 10:53:29',
                'updated_at' => '2020-03-26 10:53:29',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Draft',
                'code' => 'STATUS_LETTER',
                'value' => '0',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-26 10:56:31',
                'updated_at' => '2020-03-26 10:56:31',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Review',
                'code' => 'STATUS_LETTER',
                'value' => '1',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-26 10:56:39',
                'updated_at' => '2020-03-26 10:56:39',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Approved',
                'code' => 'STATUS_LETTER',
                'value' => '2',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-26 10:56:52',
                'updated_at' => '2020-03-26 10:56:52',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Publish',
                'code' => 'STATUS_LETTER',
                'value' => '3',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-26 10:57:13',
                'updated_at' => '2020-03-26 10:57:13',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Nama Pengirim Email',
                'code' => 'MAIL_FROM_NAME',
                'value' => 'BIJB Smart Document',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-27 11:15:52',
                'updated_at' => '2020-03-27 11:15:52',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Pengirim Email',
                'code' => 'MAIL_FROM_EMAIL',
                'value' => 'smartdoct@bijb.co.id',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-27 11:16:55',
                'updated_at' => '2020-03-27 11:16:55',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Alamat Perusahaan 1',
                'code' => 'COMPANY_ADDRESS_1',
            'value' => 'Lantai 2 Terminal Domestik (Area Perkantoran)',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-27 11:19:24',
                'updated_at' => '2020-03-27 11:19:24',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Alamat Perusahaan 2',
                'code' => 'COMPANY_ADDRESS_2',
                'value' => 'Bandara Internasional Jawa Barat Kertajati',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-27 11:19:50',
                'updated_at' => '2020-03-27 11:19:50',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Alamat Perusahaan 3',
                'code' => 'COMPANY_ADDRESS_3',
                'value' => 'Kertajati, Majalengka, Jawa Barat, 45457',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-27 11:20:08',
                'updated_at' => '2020-03-27 11:20:08',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Kontak Perusahaan',
                'code' => 'COMPANY_CONTACT',
            'value' => '(0231) 3000301 | info@bijb.co.id | bijb.co.id',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-27 11:21:10',
                'updated_at' => '2020-03-27 11:21:10',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Path FTP Digital Signature',
                'code' => 'PATH_DIGITAL_SIGNATURE',
                'value' => '/digital_signature/',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-31 11:25:26',
                'updated_at' => '2020-03-31 11:25:26',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Path FTP Surat Keluar',
                'code' => 'PATH_DIGITAL_OUTGOING_MAIL',
                'value' => '/outgoing_mail/',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-31 11:27:10',
                'updated_at' => '2020-03-31 11:27:10',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Path FTP Surat Masuk',
                'code' => 'PATH_DIGITAL_INCOMING_MAIL',
                'value' => '/incoming_mail/',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-03-31 11:27:41',
                'updated_at' => '2020-03-31 11:27:41',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'FTP Directory Root',
                'code' => 'FTP_DIRECTORY_ROOT',
                'value' => 'ftp/smartdoc',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-04-01 01:37:39',
                'updated_at' => '2020-04-01 01:37:39',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'PATH QR Code',
                'code' => 'PATH_QR_CODE',
                'value' => '/qr_code/',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-04-05 14:18:54',
                'updated_at' => '2020-04-05 14:18:54',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'BASE URL FRONT END SMARTDOC',
                'code' => 'BASE_URL_FRONT_END',
                'value' => '103.195.30.154:8002',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-04-09 00:04:38',
                'updated_at' => '2020-05-01 08:39:49',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'ALLOW ROLE POSITION USER',
                'code' => 'ALLOW_ROLE_POSITION_USER',
                'value' => 'a:4:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"4";i:3;s:1:"5";}',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-04-12 21:56:29',
                'updated_at' => '2020-04-12 21:56:29',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'DIREKSI LEVEL STRUCTURE',
                'code' => 'DIREKSI_LEVEL_STRUCTURE',
                'value' => 'a:2:{i:0;s:3:"DKU";i:1;s:4:"DOPB";}',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-04-13 13:53:57',
                'updated_at' => '2020-04-13 13:53:57',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'FRONT END APPROVAL OM',
                'code' => 'URL_APPROVAL_OUTGOING_MAIL',
                'value' => 'http://103.195.30.154:8002/#/outgoing-mails-approval',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-04-17 14:10:45',
                'updated_at' => '2020-07-15 22:07:49',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'EMAIL FRONT END SIGNED OM',
                'code' => 'URL_SIGNED_OUTGOING_MAIL',
                'value' => 'http://103.195.30.154:8002/#/outgoing-mails',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-04-17 14:11:11',
                'updated_at' => '2020-05-01 08:38:59',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'EMAIL FRONT END OM',
                'code' => 'URL_OUTGOING_MAIL',
                'value' => 'http://103.195.30.154:8002/#/outgoing-mails',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-04-17 14:11:26',
                'updated_at' => '2020-05-01 08:38:46',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'EMAIL FRONT END PUBLISH OM',
                'code' => 'URL_PUBLISH_OUTGOING_MAIL',
                'value' => 'http://103.195.30.154:8002/#/outgoing-mails-admin',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-04-19 18:40:39',
                'updated_at' => '2020-07-15 22:09:12',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'EMAIL FRONT END VERIFY OM',
                'code' => 'URL_VERIFY_OUTGOING_MAIL',
                'value' => 'http://103.195.30.154:8002/verify',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-04-20 11:07:54',
                'updated_at' => '2020-05-01 08:38:12',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'EMAIL FRONT END SEND IM',
                'code' => 'URL_SEND_INCOMING_MAIL',
                'value' => 'http://103.195.30.154:8002/#/incoming-mails',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-04-25 00:01:14',
                'updated_at' => '2020-05-01 08:37:13',
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'PATH FTP DISPOSITION',
                'code' => 'PATH_DIGITAL_DISPOSITION',
                'value' => '/disposition/',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-04-29 13:54:37',
                'updated_at' => '2020-04-29 13:54:37',
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'FRONT END URL INCOMING MAIL',
                'code' => 'URL_INCOMING_MAIL',
                'value' => 'http://103.195.30.154:8002/#/incoming-mails',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-05-03 13:42:13',
                'updated_at' => '2020-05-03 13:42:13',
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'FRONT END URL DISPOSITION FOLLOW',
                'code' => 'URL_DISPOSITION_FOLLOW',
                'value' => 'http://103.195.30.154:8002/#/dispositions-follow',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-05-03 13:44:46',
                'updated_at' => '2020-05-03 13:44:46',
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'EMAIL FRONT END PRE PUBLISH OM',
                'code' => 'URL_PRE_PUBLISH_OUTGOING_MAIL',
                'value' => 'http://103.195.30.154:8004/#/outgoing-mails-signed',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-07-01 12:29:13',
                'updated_at' => '2020-07-13 15:15:04',
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'EMAIL FRONT END DISPOSITION',
                'code' => 'URL_DISPOSITION',
                'value' => 'http://103.195.30.154:8004/#/incoming-mails-disposition',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-07-01 15:45:41',
                'updated_at' => '2020-07-01 15:45:41',
                'deleted_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'DIREKTUR LEVEL STRUCTURE',
                'code' => 'DIREKTUR_LEVEL_STRUCTURE',
                'value' => 'a:1:{i:0;s:2:"DU";}',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-07-03 22:51:13',
                'updated_at' => '2020-07-03 22:51:13',
                'deleted_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'FRONT END URL OUTGOING FOLLOW',
                'code' => 'URL_OUTGOING_FOLLOW',
                'value' => 'http://103.195.30.154:8004/#/outgoing-mails-follow',
                'description' => '',
                'status' => 1,
                'created_at' => '2020-07-10 19:39:39',
                'updated_at' => '2020-07-13 15:14:40',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}