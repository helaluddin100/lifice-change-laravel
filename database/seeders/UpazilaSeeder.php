<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpazilaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get Bangladesh's country_id
        $countryId = DB::table('countries')->where('name', 'Bangladesh')->value('id');

        if (!$countryId) {
            echo "Error: Bangladesh not found in countries table. Run CountrySeeder first.\n";
            return;
        }

        // Get division IDs dynamically
        $divisions = DB::table('divisions')->where('country_id', $countryId)->pluck('id', 'name');

        // Get district IDs dynamically
        $districts = DB::table('districts')->where('country_id', $countryId)->pluck('id', 'name');

        // Upazila data structured correctly
        $upazilas = [
            'Dhaka' => [
                'Narsingdi' => ['Belabo', 'Monohardi', 'Narsingdi Sadar', 'Palash', 'Raipura', 'Shibpur'],
                'Gazipur' => ['Kaliganj', 'Kaliakair', 'Kapasia', 'Gazipur Sadar', 'Tongi', 'Sadar', 'Sreepur'],
                'Shariatpur' => ['Shariatpur Sadar', 'Naria', 'Zajira', 'Gosairhat', 'Bhedarganj', 'Damudya'],
                'Narayanganj' => ['Araihazar', 'Bandar', 'Narayanganjsadar', 'Rupganj', 'Sonargaon'],
                'Tangail' => ['Basail', 'Bhuapur', 'Delduar', 'Ghatail', 'Gopalpur', 'Madhupur', 'Mirzapur', 'Nagarpur', 'Sakhipur', 'Tangailsadar', 'Kalihati', 'Dhanbari'],
                'Kishoreganj' => ['Itna', 'Katiadi', 'Bhairab', 'Tarail', 'Hossainpur', 'Pakundia', 'Kuliarchar', 'Kishoreganj Sadar', 'Karimgonj', 'Bajitpur', 'Austagram', 'Mithamoin', 'Nikli'],
                'Manikganj' => ['Harirampur', 'Saturia', 'Manikganj Sadar', 'Gior', 'Shibaloy', 'Doulatpur', 'Singiar'],

                'Dhaka' => ['Savar', 'Dhamrai', 'Keraniganj', 'Nawabganj', 'Dohar', 'Kotwali', 'Mohammadpur', 'Lalbagh', 'Sutrapur', 'Motijheel', 'Demra', 'Sabujbagh', 'Mirpur', 'Gulshan', 'Uttara', 'Pallabi', 'Cantonment', 'Dhanmondi', 'Tejgaon', 'Ramna', 'Adabar', 'Badda', 'Bangsal', 'Airport', 'Banani', 'Chawkbazar', 'Dhakshinkhan', 'Darus Salam', 'Bhashantek', 'Vatara', 'Gendaria', 'Hazaribagh', 'Jatrabari', 'Kafrul', 'Kadamtali', 'Kalabagan', 'Kamrangirchar', 'Khilgaon', 'Khilkhet', 'Mugda', 'New Market', 'Paltan', 'Rampura', 'Rupnagar', 'Shahjahanpur', 'Shah Ali', 'Shahbagh', 'Shyampur', 'Sher-E-Bangla Nagar', 'Turag', 'Uttarkhan', 'Wari'],

                'Munshiganj' => [' Munshiganj Sadar', 'Sreenagar', 'Sirajdikhan', 'Louhajang', 'Gajaria', 'Tongibari'],
                'Rajbari' => ['Rajbari Sadar', 'Goalanda', 'Pangsa', 'Baliakandi', 'Kalukhali'],
                'Madaripur' => [' Madaripur Sadar', 'Shibchar', 'Kalkini', 'Rajoir', 'Dasar'],
                'Gopalganj' => ['Gopalganj Sadar', 'Kashiani', 'Tungipara', 'Kotalipara', 'Muksudpur'],
                'Faridpur' => ['Faridpur Sadar', 'Alfadanga', 'Boalmari', 'Sadarpur', 'Nagarkanda', 'Bhanga', 'Charbhadrasan', 'Madhukhali', 'Saltha']
            ],

            'Chattogram' => [
                'Cumilla' => [
                    'Debidwar',
                    'Barura',
                    'Brahmanpara',
                    'Chandina',
                    'Chauddagram',
                    'Daudkandi',
                    'Homna',
                    'Laksam',
                    'Muradnagar',
                    'Nangalkot',
                    'Cumillasadar',
                    'Meghna',
                    'Monohargonj',
                    'Sadarsouth',
                    'Titas',
                    'Burichang',
                    'Lalmai'
                ],
                'Feni' => [
                    'Chhagalnaiya',
                    'Feni Sadar',
                    'Sonagazi',
                    'Fulgazi',
                    'Parshuram',
                    'Daganbhuiyan'
                ],
                'Brahmanbaria' => [
                    'Brahmanbaria Sadar',
                    'Kasba',
                    'Nasirnagar',
                    'Sarail',
                    'Ashuganj',
                    'Akhaura',
                    'Nabinagar',
                    'Bancharampur',
                    'Bijoynagar'
                ],
                'Rangamati' => [
                    'Rangamati Sadar',
                    'Kaptai',
                    'Kawkhali',
                    'Baghaichhari',
                    'Barkal',
                    'Langadu',
                    'Rajasthali',
                    'Belaichhari',
                    'Juraichhari',
                    'Naniarchar'
                ],
                'Noakhali' => [
                    'Noakhali Sadar',
                    'Companiganj',
                    'Begumganj',
                    'Hatita',
                    'Subarnachar',
                    'Kabirhat',
                    'Senbug',
                    'Chatkhil',
                    'Sonaimuri'
                ],
                'Chandpur' => [
                    'Haimchar',
                    'Kachua',
                    'Shahrasti',
                    'Chandpur Sadar',
                    'Matlabsouth',
                    'Hajiganj',
                    'Matlabnorth',
                    'Faridgonj'
                ],
                'Lakshmipur' => [
                    'Lakshmipur Sadar',
                    'Kamalnagar',
                    'Raipur',
                    'Ramgati',
                    'Ramganj'
                ],
                'Chattogram' => [
                    'Rangunia',
                    'Sitakunda',
                    'Mirsharai',
                    'Patiya',
                    'Sandwip',
                    'Banshkhali',
                    'Boalkhali',
                    'Anwara',
                    'Chandanaish',
                    'Satkania',
                    'Lohagara',
                    'Hathazari',
                    'Fatikchhari',
                    'Raozan',
                    'Karnfuli',
                    'Kotwali',
                    'Panchlaish',
                    'Chandgaon',
                    'Bandar',
                    'Pahartoli',
                    'Double Muring',
                    'Bayejid Bostami',
                    'Bakalia',
                    'Halishahar',
                    'Khulshi',
                    'Patenga'

                ],
                'Coxsbazar' => [
                    'Coxsbazar Sadar',
                    'Chakaria',
                    'Kutubdia',
                    'Ukhia',
                    'Maheshkhali',
                    'Pekua',
                    'Ramu',
                    'Teknaf',
                    'Eidgaon'
                ],
                'Khagrachari' => [
                    'Khagrachari Sadar',
                    'Dighinala',
                    'Panchhari',
                    'Laxmichhari',
                    'Mahalchhari',
                    'Manikchhari',
                    'Ramgarh',
                    'Matiranga',
                    'Guimara'
                ],
                'Bandarban' => [
                    'Bandarban Sadar',
                    'Alikadam',
                    'Naikhongchhari',
                    'Rowangchhari',
                    'Lama',
                    'Ruma',
                    'Thanchi'
                ]
            ],



            'Rajshahi' =>  [
                'Sirajganj' => ['Belkuchi', 'Chauhali', 'Kamarkhand', 'Kazipur', 'Raigonj', 'Shahjadpur', 'Sirajganj Sadar', 'Tarash', 'Ullapara'],
                'Pabna' => ['Sujanagar', 'Ishurdi', 'Bhangura', 'Pabna Sadar', 'Bera', 'Atghoria', 'Chatmohar', 'Santhia', 'Faridpur'],
                'Bogura' => ['Kahaloo', ' Bogura Sadar', 'Shariakandi', 'Shajahanpur', 'Dupchanchia', 'Adamdighi', 'Nondigram', 'Sonatala', 'Dhunot', 'Gabtali', 'Sherpur', 'Shibganj'],
                'Rajshahi' => ['Paba', 'Durgapur', 'Mohonpur', 'Charghat', 'Puthia', 'Bagha', 'Godagari', 'Tanore', 'Bagmara', 'Boalia', 'Rajpara', 'Matihar', 'Shahmokhdum'],
                'Natore' => ['Natore Sadar', 'Singra', 'Baraigram', 'Bagatipara', 'Lalpur', 'Gurudaspur', 'Naldanga'],
                'Joypurhat' => ['Akkelpur', 'Kalai', 'Khetlal', 'Panchbibi', 'Joypurhat Sadar'],
                'Chapainawabganj' => ['Chapainawabganj Sadar', 'Gomostapur', 'Nachol', 'Bholahat', 'Shibganj'],
                'Naogaon' => ['Mohadevpur', 'Badalgachi', 'Patnitala', 'Dhamoirhat', 'Niamatpur', 'Manda', 'Atrai', 'Raninagar', 'Naogaon Sadar', 'Porsha', 'Sapahar']
            ],
            'Khulna' =>   [
                'Jashore' => ['Manirampur', 'Abhaynagar', 'Bagherpara', 'Chougachha', 'Jhikargacha', 'Keshabpur', 'Jashore Sadar', 'Sharsha'],
                'Satkhira' => ['Assasuni', 'Debhata', 'Kalaroa', 'Satkhira Sadar', 'Shyamnagar', 'Tala', 'Kaliganj'],
                'Meherpur' => ['Mujibnagar', 'Meherpur Sadar', 'Gangni'],
                'Narail' => ['Narail Sadar', 'Lohagara', 'Kalia'],
                'Chuadanga' => ['Chuadanga Sadar', 'Alamdanga', 'Damurhuda', 'Jibannagar'],
                'Kushtia' => ['Kushtia Sadar', 'Kumarkhali', 'Khoksa', 'Mirpur', 'Daulatpur', 'Bheramara'],
                'Magura' => ['Shalikha', 'Sreepur', 'Magura Sadar', 'Mohammadpur'],
                'Khulna' => ['Paikgasa', 'Fultola', 'Digholia', 'Rupsha', 'Terokhada', 'Dumuria', 'Botiaghata', 'Dakop', 'Koyra', 'Khulna Sadar', 'Sonadanga', 'Daulatpur', 'Khanjahan Ali'],
                'Bagerhat' => ['Fakirhat', 'Bagerhat Sadar', 'Mollahat', 'Sarankhola', 'Rampal', 'Morrelgonj', 'Kachua', 'Mongla', 'Chitalmari'],
                'Jhenaidah' => ['Jhenaidah Sadar', 'Shailkupa', 'Harinakundu', 'Kaliganj', 'Kotchandpur', 'Moheshpur']
            ],
            'Barishal' => [
                'Jhalakathi' => ['Jhalakathi Sadar', 'Kathalia', 'Nalchity', 'Rajapur'],
                'Patuakhali' => ['Bauphal', 'Patuakhali Sadar', 'Dumki', 'Dashmina', 'Kalapara', 'Mirzaganj', 'Galachipa', 'Rangabali'],
                'Pirojpur' => ['Pirojpur Sadar', 'Nazirpur', 'Kawkhali', 'Bhandaria', 'Mathbaria', 'Nesarabad', 'Zianagar'],
                'Barishal' => ['Barishal Sadar', 'Bakerganj', 'Babuganj', 'Wazirpur', 'Banaripara', 'Gournadi', 'Agailjhara', 'Mehendiganj', 'Muladi', 'Hizla'],
                'Bhola' => ['Bhola Sadar', 'Borhanuddin', 'Charfesson', 'Doulatkhan', 'Monpura', 'Tazumuddin', 'Lalmohan'],
                'Barguna' => ['Amtali', 'Barguna Sadar', 'Betagi', 'Bamna', 'Pathorghata', 'Taltali']
            ],
            'Sylhet' => [
                'Sylhet' => ['Balaganj', 'Beanibazar', 'Bishwanath', 'Companiganj', 'Fenchuganj', 'Golapganj', 'Gowainghat', 'Jaintiapur', 'Kanaighat', 'Sylhet Sadar', 'Zakiganj', 'Dakshinsurma', 'Osmaninagar'],

                'Moulvibazar' => ['Barlekha', 'Kamolganj', 'Kulaura', 'Moulvibazar Sadar', 'Rajnagar', 'Sreemangal', 'Juri'],
                'Habiganj' => ['Nabiganj', 'Bahubal', 'Ajmiriganj', 'Baniachong', 'Lakhai', 'Chunarughat', 'Habiganj Sadar', 'Madhabpur', 'Shayestaganj'],
                'Sunamganj' => ['Sunamganj Sadar', 'Southsunamganj', 'Bishwambarpur', 'Chhatak', 'Jagannathpur', 'Dowarabazar', 'Tahirpur', 'Dharmapasha', 'Jamalganj', 'Shalla', 'Derai', 'Madhyanagar']
            ],
            'Rangpur' => [
                'Panchagarh' => ['Panchagarh Sadar', 'Debiganj', 'Boda', 'Atwari', 'Tetulia'],
                'Dinajpur' => ['Nawabganj', 'Birganj', 'Ghoraghat', 'Birampur', 'Parbatipur', 'Bochaganj', 'Kaharol', 'Fulbari', 'Dinajpur Sadar', 'Hakimpur', 'Khansama', 'Birol', 'Chirirbandar'],
                'Lalmonirhat' => ['Lalmonirhat Sadar', 'Kaliganj', 'Hatibandha', 'Patgram', 'Aditmari'],
                'Nilphamari' => ['Syedpur', 'Domar', 'Dimla', 'Jaldhaka', 'Kishorganj', 'Nilphamari Sadar'],
                'Gaibandha' => ['Sadullapur', 'Gaibandha Sadar', 'Palashbari', 'Saghata', 'Gobindaganj', 'Sundarganj', 'Phulchari'],
                'Thakurgaon' => ['Thakurgaon Sadar', 'Pirganj', 'Ranisankail', 'Haripur', 'Baliadangi'],
                'Rangpur' => ['Rangpur Sadar', 'Gangachara', 'Taraganj', 'Badargonj', 'Mithapukur', 'Pirgonj', 'Kaunia', 'Pirgacha'],
                'Kurigram' => ['Kurigram Sadar', 'Nageshwari', 'Bhurungamari', 'Phulbari', 'Rajarhat', 'Ulipur', 'Chilmari', 'Rowmari', 'Charrajibpur']
            ],
            'Mymensingh' => [
                'Sherpur' => ['Sherpur Sadar', 'Nalitabari', 'Sreebordi', 'Nokla', 'Jhenaigati'],
                'Mymensingh' => ['Fulbaria', 'Trishal', 'Bhaluka', 'Muktagacha', 'Mymensing Sadar', 'Dhobaura', 'Phulpur', 'Haluaghat', 'Gouripur', 'Gafargaon', 'Iswarganj', 'Nandail', 'Tarakanda'],
                'Jamalpur' => ['Jamalpur Sadar', 'Melandah', 'Islampur', 'Dewanganj', 'Sarishabari', 'Madariganj', 'Bokshiganj'],
                'Netrokona' => ['Barhatta', 'Durgapur', 'Kendua', 'Atpara', 'Madan', 'Khaliajuri', 'Kalmakanda', 'Mohongonj', 'Purbadhala', 'Netrokona Sadar']
            ],



        ];

        foreach ($upazilas as $divisionName => $districtsData) {
            // Get the division ID
            $divisionId = $divisions[$divisionName] ?? null;
            if (!$divisionId) {
                echo "Warning: Division '$divisionName' not found.\n";
                continue;
            }

            foreach ($districtsData as $districtName => $upazilaNames) {
                // Get the district ID
                $districtId = $districts[$districtName] ?? null;
                if (!$districtId) {
                    echo "Warning: District '$districtName' not found in '$divisionName'.\n";
                    continue;
                }

                foreach ($upazilaNames as $upazilaName) {
                    DB::table('upazilas')->updateOrInsert([
                        'name' => $upazilaName,
                        'country_id' => $countryId,
                        'division_id' => $divisionId,
                        'district_id' => $districtId,
                    ], [
                        'status' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
