<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed categories
        DB::table('categories')->insertOrIgnore([
            ['id' => 1, 'name' => 'Mikrokontroler & Development Board', 'slug' => 'mikrokontroler'],
            ['id' => 2, 'name' => 'Sensor & Tranducer', 'slug' => 'sensor'],
            ['id' => 3, 'name' => 'Aktuator & Motor Driver', 'slug' => 'aktuator'],
            ['id' => 4, 'name' => 'Modul Komunikasi & IoT', 'slug' => 'iot'],
        ]);

        // Seed products
        DB::table('products')->insertOrIgnore([
            [
                'id' => 1, 'category_id' => 1, 'sku' => 'MCU-ESP32',
                'name' => 'NodeMCU ESP32-WROOM-32D Dual-Mode WiFi & Bluetooth Board',
                'description' => 'Development board berbasis ESP32 dengan konektivitas ganda WiFi dan Bluetooth 4.2. Sangat cocok untuk proyek IoT berbiaya rendah dan performa tinggi.',
                'price' => 75000, 'stock' => 48,
                'datasheet_tips' => 'Gunakan tegangan input 5V pada colokan Micro-USB atau pin VIN. Tegangan kerja internal adalah 3.3V.',
                'pinout_data' => '{"3V3":"Output Tegangan 3.3V","GND":"Ground Utama","VIN":"Input Voltase Kasar (5V)","TXD0":"UART0 Transmit","RXD0":"UART0 Receive","GPIO2":"LED Internal (Onboard)","GPIO4":"SDA (I2C Pin)","GPIO5":"SCL (I2C Pin)"}',
                'image_url' => 'https://images.unsplash.com/photo-1555664424-778a1e5e1b48?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 2, 'category_id' => 1, 'sku' => 'MCU-UNO-R3',
                'name' => 'RoboCore UNO R3 ATmega328P dengan Kabel USB',
                'description' => 'Development board terpopuler untuk pemula Arduino. Dilengkapi dengan chip ATmega328P yang tangguh dan layout pin header standar.',
                'price' => 68000, 'stock' => 25,
                'datasheet_tips' => 'Gunakan port USB tipe-B untuk memprogram langsung dari Arduino IDE Anda.',
                'pinout_data' => '{"5V":"Output Tegangan 5.0V","GND":"Ground Utama","AREF":"Analog Reference Input","A0":"Analog Input 0","A4":"SDA (I2C Bus)","A5":"SCL (I2C Bus)","D13":"LED Internal (Onboard)"}',
                'image_url' => 'https://images.unsplash.com/photo-1608564697171-2f230e151415?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 3, 'category_id' => 2, 'sku' => 'SNS-DHT22',
                'name' => 'Sensor Suhu dan Kelembapan DHT22 / AM2302 Akurasi Tinggi',
                'description' => 'Sensor pengukur suhu udara dan tingkat kelembapan relatif dengan keluaran sinyal digital terkalibrasi.',
                'price' => 45000, 'stock' => 110,
                'datasheet_tips' => 'Gunakan resistor pull-up 4.7K - 10K antara pin VCC dan Data (Out).',
                'pinout_data' => '{"VCC":"Input Daya 3V - 5.5V","DATA":"Keluaran Digital Serial","NC":"Not Connected (Kosong)","GND":"Ground"}',
                'image_url' => 'https://images.unsplash.com/photo-1517055729445-fa7d27394b48?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 4, 'category_id' => 2, 'sku' => 'SNS-HCSR04',
                'name' => 'Sensor Jarak Ultrasonik HC-SR04 rentang 2cm - 400cm',
                'description' => 'Sensor pengukur jarak non-kontak berbasis ultrasonik frekuensi 40kHz.',
                'price' => 18000, 'stock' => 85,
                'datasheet_tips' => 'Diberi catu daya 5V. Trigger pin membutuhkan pulsa high selama 10 mikrodetik.',
                'pinout_data' => '{"VCC":"Input Daya 5V","TRIG":"Trigger Input (10us pulsa)","ECHO":"Echo Output (Lebar Pulsa)","GND":"Ground"}',
                'image_url' => 'https://images.unsplash.com/photo-1581092335397-9583fe92d232?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 5, 'category_id' => 3, 'sku' => 'ACT-SG90',
                'name' => 'TowerPro SG90 Micro Servo Motor 9g 180 Derajat',
                'description' => 'Motor servo mini ukuran 9 gram yang tangguh untuk pembuatan lengan robot.',
                'price' => 22000, 'stock' => 60,
                'datasheet_tips' => 'Jangan menahan secara paksa putaran servo (stall) karena dapat merusak gigi plastik.',
                'pinout_data' => '{"PWM (Orange)":"Kabel Kontrol Sinyal","VCC (Merah)":"Power Positif 4.8V - 6V","GND (Cokelat)":"Massa / Ground"}',
                'image_url' => 'https://images.unsplash.com/photo-1504151932400-72d4384f04b3?w=500&auto=format&fit=crop&q=60',
            ],
            [
                'id' => 6, 'category_id' => 4, 'sku' => 'IOT-LORA32',
                'name' => 'Modul Transceiver LoRa SX1276 915MHz dengan Antena',
                'description' => 'Modul komunikasi nirkabel jarak jauh berdaya rendah (LoRa) frekuensi 915MHz.',
                'price' => 125000, 'stock' => 15,
                'datasheet_tips' => 'Pastikan antena spiral eksternal sudah dipasang sebelum modul LoRa dinyalakan.',
                'pinout_data' => '{"3V3":"Power Positif 3.3V","GND":"Massa / Ground","MISO":"SPI Master In Slave Out","MOSI":"SPI Master Out Slave In","SCK":"SPI Serial Clock","NSS":"SPI Chip Select"}',
                'image_url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=500&auto=format&fit=crop&q=60',
            ],
        ]);

        // Seed admin user
        DB::table('users')->insertOrIgnore([
            [
                'id' => 1,
                'name' => 'Farrel Mahendra',
                'username' => 'farrel',
                'fullname' => 'Farrel Mahendra',
                'email' => 'fmpfarrel@gmail.com',
                'password' => Hash::make('user123'),
                'phone' => '081298765432',
                'address' => 'Jalan Otista Raya No. 12, Kelurahan Kampung Melayu',
                'city' => 'Jakarta Timur',
                'zip' => '13330',
                'is_admin' => 1,
                'user_type' => 'admin',
                'email_verified_at' => now(),
            ],
        ]);
    }
}
