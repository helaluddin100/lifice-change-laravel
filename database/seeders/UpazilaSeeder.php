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
                'Narsingdi' => ['Belabo', 'Monohardi', 'Narsingdisadar', 'Palash', 'Raipura', 'Shibpur'],
                'Gazipur' => ['Kaliganj', 'Kaliakair', 'Kapasia', 'Sadar', 'Sreepur'],
                'Shariatpur' => ['Sadar', 'Naria', 'Zajira', 'Gosairhat', 'Bhedarganj', 'Damudya'],
                'Narayanganj' => ['Araihazar', 'Bandar', 'Narayanganjsadar', 'Rupganj', 'Sonargaon'],
                'Tangail' => ['Basail', 'Bhuapur', 'Delduar', 'Ghatail', 'Gopalpur', 'Madhupur', 'Mirzapur', 'Nagarpur', 'Sakhipur', 'Tangailsadar', 'Kalihati', 'Dhanbari'],
                'Kishoreganj' => ['Itna', 'Katiadi', 'Bhairab', 'Tarail', 'Hossainpur', 'Pakundia', 'Kuliarchar', 'Kishoreganjsadar', 'Karimgonj', 'Bajitpur', 'Austagram', 'Mithamoin', 'Nikli'],
                'Manikganj' => ['Harirampur', 'Saturia', 'Sadar', 'Gior', 'Shibaloy', 'Doulatpur', 'Singiar'],
                'Dhaka' => ['Savar', 'Dhamrai', 'Keraniganj', 'Nawabganj', 'Dohar'],
                'Munshiganj' => ['Sadar', 'Sreenagar', 'Sirajdikhan', 'Louhajang', 'Gajaria', 'Tongibari'],
                'Rajbari' => ['Sadar', 'Goalanda', 'Pangsa', 'Baliakandi', 'Kalukhali'],
                'Madaripur' => ['Sadar', 'Shibchar', 'Kalkini', 'Rajoir', 'Dasar'],
                'Gopalganj' => ['Sadar', 'Kashiani', 'Tungipara', 'Kotalipara', 'Muksudpur'],
                'Faridpur' => ['Sadar', 'Alfadanga', 'Boalmari', 'Sadarpur', 'Nagarkanda', 'Bhanga', 'Charbhadrasan', 'Madhukhali', 'Saltha']
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
                    'Sadar',
                    'Sonagazi',
                    'Fulgazi',
                    'Parshuram',
                    'Daganbhuiyan'
                ],
                'Brahmanbaria' => [
                    'Sadar',
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
                    'Sadar',
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
                    'Sadar',
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
                    'Sadar',
                    'Matlabsouth',
                    'Hajiganj',
                    'Matlabnorth',
                    'Faridgonj'
                ],
                'Lakshmipur' => [
                    'Sadar',
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
                    'Karnfuli'
                ],
                'Coxsbazar' => [
                    'Sadar',
                    'Chakaria',
                    'Kutubdia',
                    'Ukhia',
                    'Maheshkhali',
                    'Pekua',
                    'Ramu',
                    'Teknaf'
                ],
                'Khagrachari' => [
                    'Sadar',
                    'Dighinala',
                    'Panchhari',
                    'Laxmichhari',
                    'Mahalchhari',
                    'Manikchhari',
                    'Ramgarh',
                    'Matiranga'
                ],
                'Bandarban' => [
                    'Sadar',
                    'Alikadam',
                    'Naikhongchhari',
                    'Rowangchhari',
                    'Lama',
                    'Ruma',
                    'Thanchi'
                ]
            ],
            'Rajshahi' =>  [
                'Sirajganj' => ['Belkuchi', 'Chauhali', 'Kamarkhand', 'Kazipur', 'Raigonj', 'Shahjadpur', 'Sirajganjsadar', 'Tarash', 'Ullapara'],
                'Pabna' => ['Sujanagar', 'Ishurdi', 'Bhangura', 'Pabnasadar', 'Bera', 'Atghoria', 'Chatmohar', 'Santhia', 'Faridpur'],
                'Bogura' => ['Kahaloo', 'Sadar', 'Shariakandi', 'Shajahanpur', 'Dupchanchia', 'Adamdighi', 'Nondigram', 'Sonatala', 'Dhunot', 'Gabtali', 'Sherpur', 'Shibganj'],
                'Rajshahi' => ['Paba', 'Durgapur', 'Mohonpur', 'Charghat', 'Puthia', 'Bagha', 'Godagari', 'Tanore', 'Bagmara'],
                'Natore' => ['Natoresadar', 'Singra', 'Baraigram', 'Bagatipara', 'Lalpur', 'Gurudaspur', 'Naldanga'],
                'Joypurhat' => ['Akkelpur', 'Kalai', 'Khetlal', 'Panchbibi', 'Joypurhatsadar'],
                'Chapainawabganj' => ['Chapainawabganjsadar', 'Gomostapur', 'Nachol', 'Bholahat', 'Shibganj'],
                'Naogaon' => ['Mohadevpur', 'Badalgachi', 'Patnitala', 'Dhamoirhat', 'Niamatpur', 'Manda', 'Atrai', 'Raninagar', 'Naogaonsadar', 'Porsha', 'Sapahar']
            ],
            'Khulna' =>   [
                'Jashore' => ['Manirampur', 'Abhaynagar', 'Bagherpara', 'Chougachha', 'Jhikargacha', 'Keshabpur', 'Sadar', 'Sharsha'],
                'Satkhira' => ['Assasuni', 'Debhata', 'Kalaroa', 'Satkhirasadar', 'Shyamnagar', 'Tala', 'Kaliganj'],
                'Meherpur' => ['Mujibnagar', 'Meherpursadar', 'Gangni'],
                'Narail' => ['Narailsadar', 'Lohagara', 'Kalia'],
                'Chuadanga' => ['Chuadangasadar', 'Alamdanga', 'Damurhuda', 'Jibannagar'],
                'Kushtia' => ['Kushtiasadar', 'Kumarkhali', 'Khoksa', 'Mirpur', 'Daulatpur', 'Bheramara'],
                'Magura' => ['Shalikha', 'Sreepur', 'Magurasadar', 'Mohammadpur'],
                'Khulna' => ['Paikgasa', 'Fultola', 'Digholia', 'Rupsha', 'Terokhada', 'Dumuria', 'Botiaghata', 'Dakop', 'Koyra'],
                'Bagerhat' => ['Fakirhat', 'Sadar', 'Mollahat', 'Sarankhola', 'Rampal', 'Morrelgonj', 'Kachua', 'Mongla', 'Chitalmari'],
                'Jhenaidah' => ['Sadar', 'Shailkupa', 'Harinakundu', 'Kaliganj', 'Kotchandpur', 'Moheshpur']
            ],
            'Barishal' => [
                'Jhalakathi' => ['Sadar', 'Kathalia', 'Nalchity', 'Rajapur'],
                'Patuakhali' => ['Bauphal', 'Sadar', 'Dumki', 'Dashmina', 'Kalapara', 'Mirzaganj', 'Galachipa', 'Rangabali'],
                'Pirojpur' => ['Sadar', 'Nazirpur', 'Kawkhali', 'Bhandaria', 'Mathbaria', 'Nesarabad', 'Indurkani'],
                'Barishal' => ['Barishalsadar', 'Bakerganj', 'Babuganj', 'Wazirpur', 'Banaripara', 'Gournadi', 'Agailjhara', 'Mehendiganj', 'Muladi', 'Hizla'],
                'Bhola' => ['Sadar', 'Borhanuddin', 'Charfesson', 'Doulatkhan', 'Monpura', 'Tazumuddin', 'Lalmohan'],
                'Barguna' => ['Amtali', 'Sadar', 'Betagi', 'Bamna', 'Pathorghata', 'Taltali']
            ],
            'Sylhet' => [
                'Sylhet' => ['Balaganj', 'Beanibazar', 'Bishwanath', 'Companiganj', 'Fenchuganj', 'Golapganj', 'Gowainghat', 'Jaintiapur', 'Kanaighat', 'Sylhetsadar', 'Zakiganj', 'Dakshinsurma', 'Osmaninagar'],
                'Moulvibazar' => ['Barlekha', 'Kamolganj', 'Kulaura', 'Moulvibazarsadar', 'Rajnagar', 'Sreemangal', 'Juri'],
                'Habiganj' => ['Nabiganj', 'Bahubal', 'Ajmiriganj', 'Baniachong', 'Lakhai', 'Chunarughat', 'Habiganjsadar', 'Madhabpur', 'Shayestaganj'],
                'Sunamganj' => ['Sadar', 'Southsunamganj', 'Bishwambarpur', 'Chhatak', 'Jagannathpur', 'Dowarabazar', 'Tahirpur', 'Dharmapasha', 'Jamalganj', 'Shalla', 'Derai', 'Madhyanagar']
            ],
            'Rangpur' => [
                'Panchagarh' => ['Panchagarhsadar', 'Debiganj', 'Boda', 'Atwari', 'Tetulia'],
                'Dinajpur' => ['Nawabganj', 'Birganj', 'Ghoraghat', 'Birampur', 'Parbatipur', 'Bochaganj', 'Kaharol', 'Fulbari', 'Dinajpursadar', 'Hakimpur', 'Khansama', 'Birol', 'Chirirbandar'],
                'Lalmonirhat' => ['Sadar', 'Kaliganj', 'Hatibandha', 'Patgram', 'Aditmari'],
                'Nilphamari' => ['Syedpur', 'Domar', 'Dimla', 'Jaldhaka', 'Kishorganj', 'Nilphamarisadar'],
                'Gaibandha' => ['Sadullapur', 'Gaibandhasadar', 'Palashbari', 'Saghata', 'Gobindaganj', 'Sundarganj', 'Phulchari'],
                'Thakurgaon' => ['Thakurgaonsadar', 'Pirganj', 'Ranisankail', 'Haripur', 'Baliadangi'],
                'Rangpur' => ['Rangpursadar', 'Gangachara', 'Taraganj', 'Badargonj', 'Mithapukur', 'Pirgonj', 'Kaunia', 'Pirgacha'],
                'Kurigram' => ['Kurigram sadar', 'Nageshwari', 'Bhurungamari', 'Phulbari', 'Rajarhat', 'Ulipur', 'Chilmari', 'Rowmari', 'Charrajibpur']
            ],
            'Mymensingh' => [
                'Sherpur' => ['Sherpursadar', 'Nalitabari', 'Sreebordi', 'Nokla', 'Jhenaigati'],
                'Mymensingh' => ['Fulbaria', 'Trishal', 'Bhaluka', 'Muktagacha', 'Mymensingsadar', 'Dhobaura', 'Phulpur', 'Haluaghat', 'Gouripur', 'Gafargaon', 'Iswarganj', 'Nandail', 'Tarakanda'],
                'Jamalpur' => ['Jamalpursadar', 'Melandah', 'Islampur', 'Dewanganj', 'Sarishabari', 'Madariganj', 'Bokshiganj'],
                'Netrokona' => ['Barhatta', 'Durgapur', 'Kendua', 'Atpara', 'Madan', 'Khaliajuri', 'Kalmakanda', 'Mohongonj', 'Purbadhala', 'Netrokonasadar']
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
