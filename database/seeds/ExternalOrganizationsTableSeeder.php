<?php

use Illuminate\Database\Seeder;

class ExternalOrganizationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('external_organizations')->delete();
        
        \DB::table('external_organizations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'kode_struktur' => 'DU',
                'nama_struktur' => 'DIREKTUR UTAMA',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 1,
                'kode_struktur' => 'DKU',
                'nama_struktur' => 'DIREKTUR KEUANGAN',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-09-02 00:14:35',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 1,
                'kode_struktur' => 'DOPB',
                'nama_struktur' => 'DIREKTUR OPERASI DAN PENGEMBANGAN BISNIS',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-09-02 00:14:35',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 1,
                'kode_struktur' => 'RMQA',
                'nama_struktur' => 'SAFETY RISK & MANAGEMENT',
                'order' => 3,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-09-02 00:14:35',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 1,
                'kode_struktur' => 'LEGAL',
                'nama_struktur' => 'LEGAL',
                'order' => 4,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-09-02 00:14:35',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 1,
                'kode_struktur' => 'IA',
                'nama_struktur' => 'INTERNAL AUDIT',
                'order' => 5,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-09-02 00:14:35',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 1,
                'kode_struktur' => 'CSM',
                'nama_struktur' => 'COORPORATE STRATEGY AND MASTERPLAN',
                'order' => 6,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-09-02 00:14:35',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 1,
                'kode_struktur' => 'ICT',
                'nama_struktur' => 'ICT',
                'order' => 7,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-09-02 00:14:35',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 1,
                'kode_struktur' => 'CSPC',
                'nama_struktur' => 'CORPORATE SECRETARY AND PUBLIC COMMUNICATION',
                'order' => 8,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-09-02 00:14:35',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 1,
                'kode_struktur' => 'PROCURMENT',
                'nama_struktur' => 'PROCUREMENT',
                'order' => 9,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-09-02 00:14:35',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 1,
                'kode_struktur' => 'AEROCITY',
                'nama_struktur' => 'AEROCITY',
                'order' => 10,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-09-02 00:14:35',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 4,
                'kode_struktur' => 'RM',
                'nama_struktur' => 'Risk Management',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 4,
                'kode_struktur' => 'QA',
                'nama_struktur' => 'Safety & Quality Assurance',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 5,
                'kode_struktur' => 'BPL',
                'nama_struktur' => 'Businnes & Procurement Legal',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 5,
                'kode_struktur' => 'QC',
                'nama_struktur' => 'Compliance & Litigation ',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => 6,
                'kode_struktur' => 'IAA',
                'nama_struktur' => 'Internal Audit',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => 7,
                'kode_struktur' => 'CP',
                'nama_struktur' => 'Corporate Plan',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'parent_id' => 7,
                'kode_struktur' => 'MP',
                'nama_struktur' => 'Master Plan',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'parent_id' => 8,
                'kode_struktur' => 'ICTBM',
                'nama_struktur' => 'ICT Businnes Management',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'parent_id' => 8,
                'kode_struktur' => 'ICTSD',
                'nama_struktur' => 'System Development',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'parent_id' => 8,
                'kode_struktur' => 'ICTAM',
                'nama_struktur' => 'ICT Area Management',
                'order' => 3,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'parent_id' => 9,
                'kode_struktur' => 'CC',
                'nama_struktur' => 'Corporate Comunnication',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'parent_id' => 9,
                'kode_struktur' => 'SA',
                'nama_struktur' => 'Secretary & Administration',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'parent_id' => 10,
                'kode_struktur' => 'VMS',
                'nama_struktur' => 'Vendor Management System',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'parent_id' => 10,
                'kode_struktur' => 'RA',
                'nama_struktur' => 'Results Assessment',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'parent_id' => 11,
                'kode_struktur' => 'AP',
                'nama_struktur' => 'Aerospace Park',
                'order' => 5,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'parent_id' => 11,
                'kode_struktur' => 'MLH',
                'nama_struktur' => 'Multimoda Logistik Hub',
                'order' => 6,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:42:10',
                'deleted_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'parent_id' => 11,
                'kode_struktur' => 'BP',
                'nama_struktur' => 'Businees Park',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'parent_id' => 11,
                'kode_struktur' => 'RT',
                'nama_struktur' => 'Residential Township',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'parent_id' => 11,
                'kode_struktur' => 'CTC',
                'nama_struktur' => 'Creative Technology Center',
                'order' => 3,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'parent_id' => 11,
                'kode_struktur' => 'EC',
                'nama_struktur' => 'Energy Center',
                'order' => 4,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'parent_id' => 2,
                'kode_struktur' => 'AF',
                'nama_struktur' => 'FINANCE & ACCOUNTING',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'parent_id' => 2,
                'kode_struktur' => 'IR',
                'nama_struktur' => 'INVESTOR RELATIONS',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'parent_id' => 2,
                'kode_struktur' => 'HRGA',
                'nama_struktur' => 'HUMAN CAPITAL & GENERAL AFFAIR',
                'order' => 3,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'parent_id' => 3,
                'kode_struktur' => 'COMM',
                'nama_struktur' => 'COMMERCIAL',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'parent_id' => 3,
                'kode_struktur' => 'AOS',
                'nama_struktur' => 'AIRPORT OPERATION & SERVICE',
                'order' => 3,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'parent_id' => 3,
                'kode_struktur' => 'AFAC',
                'nama_struktur' => 'AIRPORT FACILITY',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'parent_id' => 32,
                'kode_struktur' => 'AFF',
                'nama_struktur' => 'Finance Test Ubah',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'parent_id' => 32,
                'kode_struktur' => 'AAM',
                'nama_struktur' => 'Accounting & Asset Management',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'parent_id' => 32,
                'kode_struktur' => 'CSR',
                'nama_struktur' => 'CSR/PKBL',
                'order' => 3,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'parent_id' => 33,
                'kode_struktur' => 'IRE',
                'nama_struktur' => 'Investor Relations',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'parent_id' => 34,
                'kode_struktur' => 'HC',
                'nama_struktur' => 'Human Capital',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'parent_id' => 34,
                'kode_struktur' => 'GA',
                'nama_struktur' => 'General Affair',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'parent_id' => 35,
                'kode_struktur' => 'ABS',
                'nama_struktur' => 'Aero Business',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            44 => 
            array (
                'id' => 45,
                'parent_id' => 35,
                'kode_struktur' => 'NAB',
                'nama_struktur' => 'Non Aero Business',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            45 => 
            array (
                'id' => 46,
                'parent_id' => 36,
                'kode_struktur' => 'OPS',
                'nama_struktur' => 'Operation & Service',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            46 => 
            array (
                'id' => 47,
                'parent_id' => 36,
                'kode_struktur' => 'RAS',
                'nama_struktur' => 'Rescue & Airport Security',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            47 => 
            array (
                'id' => 48,
                'parent_id' => 37,
                'kode_struktur' => 'INFRA',
                'nama_struktur' => 'Infrasructur',
                'order' => 1,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
            48 => 
            array (
                'id' => 49,
                'parent_id' => 37,
                'kode_struktur' => 'TECHNICAL',
                'nama_struktur' => 'Technical',
                'order' => 2,
                'status' => 1,
                'created_at' => '2020-09-02 00:14:35',
                'updated_at' => '2020-10-04 11:41:52',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}