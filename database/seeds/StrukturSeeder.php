<?php

use Illuminate\Database\Seeder;
use App\Modules\External\Organization\Models\OrganizationModel;

class StrukturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organization = [
            // [
            //     'nama_struktur' => 'Direktur Utama',
            //     'parent_id' => null,
            //     'kode_struktur' => 'DU'
            // ],
            // [
            //     'nama_struktur' => 'Direktur Keuangan',
            //     'parent_id' => 1,
            //     'kode_struktur' => 'DK'
            // ],
            // [
            //     'nama_struktur' => 'Direktur Operasional & Komersial',
            //     'parent_id' => 1,
            //     'kode_struktur' => 'DOK'
            // ],
            // [
            //     'nama_struktur' => 'Risk Management & QA',
            //     'parent_id' => 1,
            //     'kode_struktur' => 'RMQA'
            // ],
            // [
            //     'nama_struktur' => 'Legal',
            //     'parent_id' => 1,
            //     'kode_struktur' => 'LEGAL'
            // ],
            // [
            //     'nama_struktur' => 'Internal Audit',
            //     'parent_id' => 1,
            //     'kode_struktur' => 'IA'
            // ],
            // [
            //     'nama_struktur' => 'Coorporate Strategi & Masterplan',
            //     'parent_id' => 1,
            //     'kode_struktur' => 'CSM'
            // ],
            // [
            //     'nama_struktur' => 'ICT',
            //     'parent_id' => 1,
            //     'kode_struktur' => 'ICT'
            // ],
            // [
            //     'nama_struktur' => 'Corporate Strategi & Public Comunnication',
            //     'parent_id' => 1,
            //     'kode_struktur' => 'CSPC'
            // ],
            // [
            //     'nama_struktur' => 'Procurment',
            //     'parent_id' => 1,
            //     'kode_struktur' => 'PROCURMENT'
            // ],
            // [
            //     'nama_struktur' => 'Aerocity',
            //     'parent_id' => 1,
            //     'kode_struktur' => 'AEROCITY'
            // ],
            // [
            //     'nama_struktur' => 'Risk Management',
            //     'parent_id' => 4,
            //     'kode_struktur' => 'RM'
            // ],
            // [
            //     'nama_struktur' => 'Quality Assurance',
            //     'parent_id' => 4,
            //     'kode_struktur' => 'QA'
            // ],
            // [
            //     'nama_struktur' => 'Businnes & Procurment Legal',
            //     'parent_id' => 5,
            //     'kode_struktur' => 'BPL'
            // ],
            // [
            //     'nama_struktur' => 'Compliance ',
            //     'parent_id' => 5,
            //     'kode_struktur' => 'QA'
            // ],
            // [
            //     'nama_struktur' => 'Internal Audit',
            //     'parent_id' => 6,
            //     'kode_struktur' => 'IAA'
            // ],
            // [
            //     'nama_struktur' => 'Corporate Plan',
            //     'parent_id' => 7,
            //     'kode_struktur' => 'CP'
            // ],
            // [
            //     'nama_struktur' => 'Master Plan',
            //     'parent_id' => 7,
            //     'kode_struktur' => 'MP'
            // ]
            // [
            //     'nama_struktur' => 'ICT Businnes Management',
            //     'parent_id' => 8,
            //     'kode_struktur' => 'ICTBM'
            // ],
            // [
            //     'nama_struktur' => 'ICT Software Development',
            //     'parent_id' => 8,
            //     'kode_struktur' => 'ICTSD'
            // ],
            // [
            //     'nama_struktur' => 'ICT Area Management',
            //     'parent_id' => 8,
            //     'kode_struktur' => 'ICTAM'
            // ],
            // [
            //     'nama_struktur' => 'Corporate Comunnication',
            //     'parent_id' => 9,
            //     'kode_struktur' => 'CC'
            // ],
            // [
            //     'nama_struktur' => 'Secretary & Administrator',
            //     'parent_id' => 9,
            //     'kode_struktur' => 'SA'
            // ],
            // [
            //     'nama_struktur' => 'Vendor Management System',
            //     'parent_id' => 10,
            //     'kode_struktur' => 'VMS'
            // ],
            // [
            //     'nama_struktur' => 'Results Assessment',
            //     'parent_id' => 10,
            //     'kode_struktur' => 'RA'
            // ],
            // [
            //     'nama_struktur' => 'Aerospace Park',
            //     'parent_id' => 11,
            //     'kode_struktur' => 'AP'
            // ],
            // [
            //     'nama_struktur' => 'Multimoda Logistik Hub',
            //     'parent_id' => 11,
            //     'kode_struktur' => 'MLH'
            // ],
            // [
            //     'nama_struktur' => 'Businees Park',
            //     'parent_id' => 11,
            //     'kode_struktur' => 'BP'
            // ],
            // [
            //     'nama_struktur' => 'Residential Township',
            //     'parent_id' => 11,
            //     'kode_struktur' => 'RT'
            // ],
            // [
            //     'nama_struktur' => 'Creative Technology Center',
            //     'parent_id' => 11,
            //     'kode_struktur' => 'CTC'
            // ],
            // [
            //     'nama_struktur' => 'Energy Center',
            //     'parent_id' => 11,
            //     'kode_struktur' => 'EC'
            // ]
            // [
            //     'nama_struktur' => 'Accounting & Finance',
            //     'parent_id' => 2,
            //     'kode_struktur' => 'AF'
            // ],
            // [
            //     'nama_struktur' => 'Investor Relation',
            //     'parent_id' => 2,
            //     'kode_struktur' => 'IR'
            // ],
            // [
            //     'nama_struktur' => 'Human Capital & General Affair',
            //     'parent_id' => 2,
            //     'kode_struktur' => 'HRGA'
            // ],
            // [
            //     'nama_struktur' => 'Commercial',
            //     'parent_id' => 3,
            //     'kode_struktur' => 'COMM'
            // ],
            // [
            //     'nama_struktur' => 'Airport Operation & Service',
            //     'parent_id' => 3,
            //     'kode_struktur' => 'AOS'
            // ],
            // [
            //     'nama_struktur' => 'Airport Facility',
            //     'parent_id' => 3,
            //     'kode_struktur' => 'AF'
            // ]
        //     [
        //         'nama_struktur' => 'FINANCE',
        //         'parent_id' => 32,
        //         'kode_struktur' => 'FINANCE'
        //     ],
        //     [
        //         'nama_struktur' => 'Accounting & Asset Management',
        //         'parent_id' => 32,
        //         'kode_struktur' => 'AAM'
        //     ],
        //     [
        //         'nama_struktur' => 'CSR/PKBL',
        //         'parent_id' => 32,
        //         'kode_struktur' => 'MLH'
        //     ],
        //     [
        //         'nama_struktur' => 'Investor Relation',
        //         'parent_id' => 33,
        //         'kode_struktur' => 'IRE'
        //     ],
        //     [
        //         'nama_struktur' => 'Human Capital',
        //         'parent_id' => 34,
        //         'kode_struktur' => 'HC'
        //     ],
        //     [
        //         'nama_struktur' => 'General Affair',
        //         'parent_id' => 34,
        //         'kode_struktur' => 'GA'
        //     ],
        //     [
        //         'nama_struktur' => 'Aero Business',
        //         'parent_id' => 35,
        //         'kode_struktur' => 'ABS'
        //     ],
        //     [
        //         'nama_struktur' => 'Non Aero Business',
        //         'parent_id' => 35,
        //         'kode_struktur' => 'NAB'
        //     ],
        //     [
        //         'nama_struktur' => 'Operation & Service',
        //         'parent_id' => 36,
        //         'kode_struktur' => 'OPS'
        //     ],
        //     [
        //         'nama_struktur' => 'Rescue & Airport Security',
        //         'parent_id' => 36,
        //         'kode_struktur' => 'RAS'
        //     ],
        //     [
        //         'nama_struktur' => 'Infrasructur',
        //         'parent_id' => 37,
        //         'kode_struktur' => 'INFRA'
        //     ],
        //     [
        //         'nama_struktur' => 'Technical',
        //         'parent_id' => 37,
        //         'kode_struktur' => 'TECHNICAL'
        //     ],
        // ];
        
        // OrganizationModel::insert($organization);
    }
}
