<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MedicalCenter;

class MedicalCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicalcenters = [
            //Hospital - Johor
            [
                'id' => 1,
                'medical_center_name' => "Hospital Enche' Besar Hajjah Kalsom",
                'state' => 'johor',
                'contact' => '07-7787000',
            ],
            [
                'id' => 2,
                'medical_center_name' => 'Hospital Kota Tinggi',
                'state' => 'johor',
                'contact' => '07-8831131/32',
            ],
            [
                'id' => 3,
                'medical_center_name' => 'Hospital Mersing',
                'state' => 'johor',
                'contact' => '07-7993333',
            ],
            [
                'id' => 4,
                'medical_center_name' => 'Hospital Sultanah Aminah',
                'state' => 'johor',
                'contact' => '07-2231666',
            ],
            [
                'id' => 5,
                'medical_center_name' => 'Hospital Permai',
                'state' => 'johor',
                'contact' => '07-2311000',
            ],
            [
                'id' => 6,
                'medical_center_name' => 'Hospital Pontian',
                'state' => 'johor',
                'contact' => '07-6873333',
            ],
            [
                'id' => 7,
                'medical_center_name' => 'Hospital Segamat',
                'state' => 'johor',
                'contact' => '07-9433333',
            ],
            [
                'id' => 8,
                'medical_center_name' => 'Hospital Sultan Ismail Johor Bahru',
                'state' => 'johor',
                'contact' => '07-3565000',
            ],
            [
                'id' => 9,
                'medical_center_name' => 'Hospital Pakar Sultanah Fatimah',
                'state' => 'johor',
                'contact' => '06-9564000',
            ],
            [
                'id' => 10,
                'medical_center_name' => 'Hospital Sultanah Nora Ismail',
                'state' => 'johor',
                'contact' => '07-4363000',
            ],
            [
                'id' => 11,
                'medical_center_name' => 'Hospital Tangkak',
                'state' => 'johor',
                'contact' => '06-9782792 / 06-9781206',
            ],
            [
                'id' => 12,
                'medical_center_name' => 'Hospital Temenggong Seri Maharaja Tun Ibrahim',
                'state' => 'johor',
                'contact' => '07-6623333',
            ],

            //Hospital - Kedah
            [
                'id' => 13,
                'medical_center_name' => 'Hospital Baling',
                'state' => 'kedah',
                'contact' => '04-4701333',
            ],
            [
                'id' => 14,
                'medical_center_name' => 'Hospital Jitra',
                'state' => 'kedah',
                'contact' => '04-9174333',
            ],
            [
                'id' => 15,
                'medical_center_name' => 'Hospital Kuala Nerang',
                'state' => 'kedah',
                'contact' => '04-7867333',
            ],
            [
                'id' => 16,
                'medical_center_name' => 'Hospital Kulim',
                'state' => 'kedah',
                'contact' => '04-4272733',
            ],
            [
                'id' => 17,
                'medical_center_name' => 'Hospital Langkawi',
                'state' => 'kedah',
                'contact' => '04-9663333',
            ],
            [
                'id' => 18,
                'medical_center_name' => 'Hospital Sik',
                'state' => 'kedah',
                'contact' => '04-4695333',
            ],
            [
                'id' => 19,
                'medical_center_name' => 'Hospital Sultan Abdul Halim',
                'state' => 'kedah',
                'contact' => '04-4457333',
            ],
            [
                'id' => 20,
                'medical_center_name' => 'Hospital Sultanah Bahiyah',
                'state' => 'kedah',
                'contact' => '04-7406233',
            ],
            [
                'id' => 21,
                'medical_center_name' => 'Hospital Yan',
                'state' => 'kedah',
                'contact' => '04-4655333',
            ],
            [
                'id' => 22,
                'medical_center_name' => 'Hospital Pendang',
                'state' => 'kedah',
                'contact' => '04-7251000',
            ],

            //Hospital - Kelantan
            [
                'id' => 23,
                'medical_center_name' => 'Hospital Gua Musang',
                'state' => 'kelantan',
                'contact' => '09-9121133',
            ],
            [
                'id' => 24,
                'medical_center_name' => 'Hospital Jeli',
                'state' => 'kelantan',
                'contact' => '09-9440092',
            ],
            [
                'id' => 25,
                'medical_center_name' => 'Hospital Machang',
                'state' => 'kelantan',
                'contact' => '09-9741300/301',
            ],
            [
                'id' => 26,
                'medical_center_name' => 'Hospital Pasir Mas',
                'state' => 'kelantan',
                'contact' => '09-7932300',
            ],
            [
                'id' => 27,
                'medical_center_name' => 'Hospital Raja Perempuan Zainab II',
                'state' => 'kelantan',
                'contact' => '09-7452000',
            ],
            [
                'id' => 28,
                'medical_center_name' => 'Hospital Sultan Ismail Petra',
                'state' => 'kelantan',
                'contact' => '09-9611300',
            ],
            [
                'id' => 29,
                'medical_center_name' => 'Hospital Tanah Merah',
                'state' => 'kelantan',
                'contact' => '09-9545000',
            ],
            [
                'id' => 30,
                'medical_center_name' => 'Hospital Tengku Anis',
                'state' => 'kelantan',
                'contact' => '09-7843333',
            ],
            [
                'id' => 31,
                'medical_center_name' => 'Hospital Tumpat',
                'state' => 'kelantan',
                'contact' => '09-7263000',
            ],

            //Hospital - Melaka
            [
                'id' => 32,
                'medical_center_name' => 'Hospital Alor Gajah',
                'state' => 'melaka',
                'contact' => '06-5562333',
            ],
            [
                'id' => 33,
                'medical_center_name' => 'Hospital Jasin',
                'state' => 'melaka',
                'contact' => '06-5294262',
            ],
            [
                'id' => 34,
                'medical_center_name' => 'Hospital Melaka',
                'state' => 'melaka',
                'contact' => '06-2892344',
            ],

            //Hospital - Negeri Sembilan
            [
                'id' => 35,
                'medical_center_name' => 'Hospital Jelebu',
                'state' => 'negeri_sembilan',
                'contact' => '06-6136355',
            ],
            [
                'id' => 36,
                'medical_center_name' => 'Hospital Jempol',
                'state' => 'negeri_sembilan',
                'contact' => '06-4592000',
            ],
            [
                'id' => 37,
                'medical_center_name' => 'Hospital Port Dickson',
                'state' => 'negeri_sembilan',
                'contact' => '06-6487333',
            ],
            [
                'id' => 38,
                'medical_center_name' => 'Hospital Rembau',
                'state' => 'negeri_sembilan',
                'contact' => '06-6860600',
            ],
            [
                'id' => 39,
                'medical_center_name' => 'Hospital Tampin',
                'state' => 'negeri_sembilan',
                'contact' => '06-4411511 /06-4411512',
            ],
            [
                'id' => 40,
                'medical_center_name' => 'Hospital Tuanku Ampuan Najihah',
                'state' => 'negeri_sembilan',
                'contact' => '06-4818001',
            ],
            [
                'id' => 41,
                'medical_center_name' => "Hospital Tuanku Ja'afar",
                'state' => 'negeri_sembilan',
                'contact' => '06-7684000',
            ],

            //Hospital - Pahang
            [
                'id' => 42,
                'medical_center_name' => "Hospital Bentong",
                'state' => 'pahang',
                'contact' => '09-2223333',
            ],
            [
                'id' => 43,
                'medical_center_name' => "Hospital Bera",
                'state' => 'pahang',
                'contact' => '09-2509323',
            ],
            [
                'id' => 44,
                'medical_center_name' => "Hospital Jengka",
                'state' => 'pahang',
                'contact' => '09-4662333',
            ],
            [
                'id' => 45,
                'medical_center_name' => "Hospital Jerantut",
                'state' => 'pahang',
                'contact' => '09-2663333',
            ],
            [
                'id' => 46,
                'medical_center_name' => "Hospital Kuala Lipis",
                'state' => 'pahang',
                'contact' => '09-3123333',
            ],
            [
                'id' => 47,
                'medical_center_name' => "Hospital Muadzam Shah",
                'state' => 'pahang',
                'contact' => '09-4523333',
            ],
            [
                'id' => 48,
                'medical_center_name' => "Hospital Pekan",
                'state' => 'pahang',
                'contact' => '09-4223333',
            ],
            [
                'id' => 49,
                'medical_center_name' => "Hospital Raub",
                'state' => 'pahang',
                'contact' => '09-3553333',
            ],
            [
                'id' => 50,
                'medical_center_name' => "Hospital Rompin",
                'state' => 'pahang',
                'contact' => '09-4141543',
            ],
            [
                'id' => 51,
                'medical_center_name' => "Hospital Sultan Hj Ahmad Shah",
                'state' => 'pahang',
                'contact' => '09-2955333',
            ],
            [
                'id' => 52,
                'medical_center_name' => "Hospital Sultanah Hajjah Kalsom",
                'state' => 'pahang',
                'contact' => '05-4913333',
            ],
            [
                'id' => 53,
                'medical_center_name' => "Hospital Tengku Ampuan Afzan",
                'state' => 'pahang',
                'contact' => '09-5133333',
            ],

            //Hospital - Pulau Pinang
            [
                'id' => 54,
                'medical_center_name' => "Hospital Balik Pulau",
                'state' => 'pulau_pinang',
                'contact' => '04-8669333',
            ],
            [
                'id' => 55,
                'medical_center_name' => "Hospital Bukit Mertajam",
                'state' => 'pulau_pinang',
                'contact' => '04-5497333',
            ],
            [
                'id' => 56,
                'medical_center_name' => "Hospital Kepala Batas",
                'state' => 'pulau_pinang',
                'contact' => '04-5793333',
            ],
            [
                'id' => 57,
                'medical_center_name' => "Hospital Pulau Pinang",
                'state' => 'pulau_pinang',
                'contact' => '04-2225333',
            ],
            [
                'id' => 58,
                'medical_center_name' => "Hospital Seberang Jaya",
                'state' => 'pulau_pinang',
                'contact' => '04-3827333',
            ],
            [
                'id' => 59,
                'medical_center_name' => "Hospital Sungai Bakap",
                'state' => 'pulau_pinang',
                'contact' => '04-5824333',
            ],

            //Hospital - Perak
            [
                'id' => 60,
                'medical_center_name' => "Hospital Bahagia Ulu Kinta",
                'state' => 'perak',
                'contact' => '05-5332333',
            ],
            [
                'id' => 61,
                'medical_center_name' => "Hospital Batu Gajah",
                'state' => 'perak',
                'contact' => '05-3663333',
            ],
            [
                'id' => 62,
                'medical_center_name' => "Hospital Changkat Melintang",
                'state' => 'perak',
                'contact' => '05-3761333',
            ],
            [
                'id' => 63,
                'medical_center_name' => "Hospital Gerik",
                'state' => 'perak',
                'contact' => '05-7911333',
            ],
            [
                'id' => 64,
                'medical_center_name' => "Hospital Kampar",
                'state' => 'perak',
                'contact' => '05-4653333',
            ],
            [
                'id' => 65,
                'medical_center_name' => "Hospital Kuala Kangsar",
                'state' => 'perak',
                'contact' => '05-7763333',
            ],
            [
                'id' => 66,
                'medical_center_name' => "Hospital Parit Buntar",
                'state' => 'perak',
                'contact' => '05-7163333',
            ],
            [
                'id' => 67,
                'medical_center_name' => "Hospital Raja Permaisuri Bainun",
                'state' => 'perak',
                'contact' => '05-2533333',
            ],
            [
                'id' => 68,
                'medical_center_name' => "Hospital Selama",
                'state' => 'perak',
                'contact' => '05-8394233',
            ],
            [
                'id' => 69,
                'medical_center_name' => "Hospital Seri Manjung",
                'state' => 'perak',
                'contact' => '05-6896600',
            ],
            [
                'id' => 70,
                'medical_center_name' => "Hospital Slim River",
                'state' => 'perak',
                'contact' => '05-4508000',
            ],
            [
                'id' => 71,
                'medical_center_name' => "Hospital Sungai Siput",
                'state' => 'perak',
                'contact' => '05-5983333',
            ],
            [
                'id' => 72,
                'medical_center_name' => "Hospital Taiping",
                'state' => 'perak',
                'contact' => '05-8083333',
            ],
            [
                'id' => 73,
                'medical_center_name' => "Hospital Tapah",
                'state' => 'perak',
                'contact' => '05-4011333',
            ],
            [
                'id' => 74,
                'medical_center_name' => "Hospital Teluk Intan",
                'state' => 'perak',
                'contact' => '05-6213333',
            ],

            //Hospital - Perlis
            [
                'id' => 75,
                'medical_center_name' => "Hospital Tuanku Fauziah",
                'state' => 'perlis',
                'contact' => '04-9738000',
            ],

            //Hospital - Sabah
            [
                'id' => 76,
                'medical_center_name' => "Hospital Beaufort",
                'state' => 'sabah',
                'contact' => '087-212333',
            ],
            [
                'id' => 77,
                'medical_center_name' => "Hospital Beluran",
                'state' => 'sabah',
                'contact' => '089-511233/333',
            ],
            [
                'id' => 78,
                'medical_center_name' => "Hospital Duchess Of Kent",
                'state' => 'sabah',
                'contact' => '089-248 600',
            ],
            [
                'id' => 79,
                'medical_center_name' => "Hospital Keningau",
                'state' => 'sabah',
                'contact' => '087-313000',
            ],
            [
                'id' => 80,
                'medical_center_name' => "Hospital Kinabatangan",
                'state' => 'sabah',
                'contact' => '089-561857',
            ],
            [
                'id' => 81,
                'medical_center_name' => "Hospital Kota Belud",
                'state' => 'sabah',
                'contact' => 'Due to technical issue: use 011-56535292',
            ],
            [
                'id' => 82,
                'medical_center_name' => "Hospital Kota Marudu",
                'state' => 'sabah',
                'contact' => '088-663286',
            ],
            [
                'id' => 83,
                'medical_center_name' => "Hospital Kuala Penyu",
                'state' => 'sabah',
                'contact' => '087-853100',
            ],
            [
                'id' => 84,
                'medical_center_name' => "Hospital Kudat",
                'state' => 'sabah',
                'contact' => '088-613333',
            ],
            [
                'id' => 85,
                'medical_center_name' => "Hospital Kunak",
                'state' => 'sabah',
                'contact' => '089-894100',
            ],
            [
                'id' => 86,
                'medical_center_name' => "Hospital Lahad Datu",
                'state' => 'sabah',
                'contact' => '089-895111',
            ],
            [
                'id' => 87,
                'medical_center_name' => "Hospital Mesra Bukit Padang",
                'state' => 'sabah',
                'contact' => '088-240984',
            ],
            [
                'id' => 88,
                'medical_center_name' => "Hospital Papar",
                'state' => 'sabah',
                'contact' => '088-913333',
            ],
            [
                'id' => 89,
                'medical_center_name' => "Hospital Pitas",
                'state' => 'sabah',
                'contact' => '088-676100',
            ],
            [
                'id' => 90,
                'medical_center_name' => "Hospital Queen Elizabeth",
                'state' => 'sabah',
                'contact' => '088-517555',
            ],
            [
                'id' => 91,
                'medical_center_name' => "Hospital Queen Elizabeth II",
                'state' => 'sabah',
                'contact' => '088-324600',
            ],
            [
                'id' => 92,
                'medical_center_name' => "Hospital Ranau",
                'state' => 'sabah',
                'contact' => '088-875266',
            ],
            [
                'id' => 93,
                'medical_center_name' => "Hospital Semporna",
                'state' => 'sabah',
                'contact' => '011-36627599',
            ],
            [
                'id' => 94,
                'medical_center_name' => "Hospital Sipitang",
                'state' => 'sabah',
                'contact' => '087-822 296',
            ],
            [
                'id' => 95,
                'medical_center_name' => "Hospital Tambunan",
                'state' => 'sabah',
                'contact' => '087-774 333',
            ],
            [
                'id' => 96,
                'medical_center_name' => "Hospital Tawau",
                'state' => 'sabah',
                'contact' => '089-773533',
            ],
            [
                'id' => 97,
                'medical_center_name' => "Hospital Tenom",
                'state' => 'sabah',
                'contact' => '087-735 577',
            ],
            [
                'id' => 98,
                'medical_center_name' => "Hospital Tuaran",
                'state' => 'sabah',
                'contact' => '088-788317',
            ],
            [
                'id' => 99,
                'medical_center_name' => "Hospital Wanita dan Kanak - Kanak",
                'state' => 'sabah',
                'contact' => '088-522600',
            ],

            //Hospital - Sarawak
            [
                'id' => 100,
                'medical_center_name' => "Hospital Bau",
                'state' => 'sarawak',
                'contact' => '082-763711',
            ],
            [
                'id' => 101,
                'medical_center_name' => "Hospital Betong",
                'state' => 'sarawak',
                'contact' => '083-472821',
            ],
            [
                'id' => 102,
                'medical_center_name' => "Hospital Bintulu",
                'state' => 'sarawak',
                'contact' => '086-255899',
            ],
            [
                'id' => 103,
                'medical_center_name' => "Hospital Dalat",
                'state' => 'sarawak',
                'contact' => '084-863213',
            ],
            [
                'id' => 104,
                'medical_center_name' => "Hospital Daro",
                'state' => 'sarawak',
                'contact' => '084-823620',
            ],
            [
                'id' => 105,
                'medical_center_name' => "Hospital Kanowit",
                'state' => 'sarawak',
                'contact' => '084-752333',
            ],
            [
                'id' => 106,
                'medical_center_name' => "Hospital Kapit",
                'state' => 'sarawak',
                'contact' => '084-796333',
            ],
            [
                'id' => 107,
                'medical_center_name' => "Hospital Lawas",
                'state' => 'sarawak',
                'contact' => '085-283781',
            ],
            [
                'id' => 108,
                'medical_center_name' => "Hospital Limbang",
                'state' => 'sarawak',
                'contact' => '085-211200',
            ],
            [
                'id' => 109,
                'medical_center_name' => "Hospital Lundu",
                'state' => 'sarawak',
                'contact' => '082-735311',
            ],
            [
                'id' => 110,
                'medical_center_name' => "Hospital Marudi",
                'state' => 'sarawak',
                'contact' => '085-755511',
            ],
            [
                'id' => 111,
                'medical_center_name' => "Hospital Miri",
                'state' => 'sarawak',
                'contact' => '085-420033',
            ],
            [
                'id' => 112,
                'medical_center_name' => "Hospital Mukah",
                'state' => 'sarawak',
                'contact' => '084-871333',
            ],
            [
                'id' => 113,
                'medical_center_name' => "Hospital Rajah Charles Brooke Memorial",
                'state' => 'sarawak',
                'contact' => '082-611123',
            ],
            [
                'id' => 114,
                'medical_center_name' => "Hospital Saratok",
                'state' => 'sarawak',
                'contact' => '083-436311',
            ],
            [
                'id' => 115,
                'medical_center_name' => "Hospital Sarikei",
                'state' => 'sarawak',
                'contact' => '084-653333',
            ],
            [
                'id' => 116,
                'medical_center_name' => "Hospital Sentosa",
                'state' => 'sarawak',
                'contact' => '082-612321',
            ],
            [
                'id' => 117,
                'medical_center_name' => "Hospital Serian",
                'state' => 'sarawak',
                'contact' => '082-874311',
            ],
            [
                'id' => 118,
                'medical_center_name' => "Hospital Sibu",
                'state' => 'sarawak',
                'contact' => '084-343333',
            ],
            [
                'id' => 119,
                'medical_center_name' => "Hospital Simunjan",
                'state' => 'sarawak',
                'contact' => '082-803982',
            ],
            [
                'id' => 120,
                'medical_center_name' => "Hospital Sri Aman",
                'state' => 'sarawak',
                'contact' => '083-322151',
            ],
            [
                'id' => 121,
                'medical_center_name' => "Hospital Umum Sarawak",
                'state' => 'sarawak',
                'contact' => '082-276666',
            ],
            
            //Hospital - Selangor
            [
                'id' => 122,
                'medical_center_name' => "Hospital Ampang",
                'state' => 'selangor',
                'contact' => '03-42896000',
            ],
            [
                'id' => 123,
                'medical_center_name' => "Hospital Banting",
                'state' => 'selangor',
                'contact' => '03-31871333',
            ],
            [
                'id' => 124,
                'medical_center_name' => "Hospital Cyberjaya",
                'state' => 'selangor',
                'contact' => '03-88733500',
            ],
            [
                'id' => 125,
                'medical_center_name' => "Hospital Kajang",
                'state' => 'selangor',
                'contact' => '03-87343333',
            ],
            [
                'id' => 126,
                'medical_center_name' => "Hospital Kuala Kubu Bharu",
                'state' => 'selangor',
                'contact' => '03-60641333',
            ],
            [
                'id' => 127,
                'medical_center_name' => "Hospital Orang Asli Gombak",
                'state' => 'selangor',
                'contact' => '03-61892122',
            ],
            [
                'id' => 128,
                'medical_center_name' => "Hospital Selayang",
                'state' => 'selangor',
                'contact' => '03-61263333',
            ],
            [
                'id' => 129,
                'medical_center_name' => "Hospital Serdang",
                'state' => 'selangor',
                'contact' => '03-89475555',
            ],
            [
                'id' => 130,
                'medical_center_name' => "Hospital Shah Alam",
                'state' => 'selangor',
                'contact' => '03-55263000',
            ],
            [
                'id' => 131,
                'medical_center_name' => "Hospital Sungai Buloh",
                'state' => 'selangor',
                'contact' => '03-61454333',
            ],
            [
                'id' => 132,
                'medical_center_name' => "Hospital Tanjung Karang",
                'state' => 'selangor',
                'contact' => '03-32682000',
            ],
            [
                'id' => 133,
                'medical_center_name' => "Hospital Tengku Ampuan Jemaah",
                'state' => 'selangor',
                'contact' => '03-32163333',
            ],
            [
                'id' => 134,
                'medical_center_name' => "Hospital Tengku Ampuan Rahimah",
                'state' => 'selangor',
                'contact' => '03-33757000',
            ],

            //Hospital Terengganu
            [
                'id' => 135,
                'medical_center_name' => "Hospital Besut",
                'state' => 'terengganu',
                'contact' => '09-6971130',
            ],
            [
                'id' => 136,
                'medical_center_name' => "Hospital Dungun",
                'state' => 'terengganu',
                'contact' => '09-8483333',
            ],
            [
                'id' => 137,
                'medical_center_name' => "Hospital Hulu Terengganu",
                'state' => 'terengganu',
                'contact' => '09-681 3333',
            ],
            [
                'id' => 138,
                'medical_center_name' => "Hospital Kemaman",
                'state' => 'terengganu',
                'contact' => '09-8513333',
            ],
            [
                'id' => 139,
                'medical_center_name' => "Hospital Setiu",
                'state' => 'terengganu',
                'contact' => '09-6090333',
            ],
            [
                'id' => 140,
                'medical_center_name' => "Hospital Sultanah Nur Zahirah",
                'state' => 'terengganu',
                'contact' => '09-6212121',
            ],

            //Hospital - WP KL
            [
                'id' => 141,
                'medical_center_name' => "Hospital Kuala Lumpur",
                'state' => 'kuala_lumpur',
                'contact' => '03-26155555',
            ],
            [
                'id' => 142,
                'medical_center_name' => "Hospital Rehabilitasi Cheras",
                'state' => 'kuala_lumpur',
                'contact' => '03-91453400',
            ],
            [
                'id' => 143,
                'medical_center_name' => "Hospital Tunku Azizah (Wanita Dan Kanak-Kanak)",
                'state' => 'kuala_lumpur',
                'contact' => '03-26003000',
            ],

            //Hospital - WP Labuan
            [
                'id' => 144,
                'medical_center_name' => "Hospital Labuan",
                'state' => 'labuan',
                'contact' => '087-596888',
            ],

            //Hospital - Putrajaya
            [
                'id' => 145,
                'medical_center_name' => "Hospital Putrajaya",
                'state' => 'labuan',
                'contact' => '03-83124200',
            ],
        ];

        foreach($medicalcenters as $medicalcenter){
            MedicalCenter::firstOrCreate($medicalcenter);
        }
    }
}
