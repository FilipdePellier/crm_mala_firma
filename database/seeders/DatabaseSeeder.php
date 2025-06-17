<?php

namespace Database\Seeders;

// upewnij się, że te klasy są zaimportowane
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Inicjalizacja Fakera z polską lokalizacją
        $faker = Faker::create('pl_PL');

        // Wyłączenie sprawdzania kluczy obcych na czas seedowania dla bezpieczeństwa
        Schema::disableForeignKeyConstraints();

        // Czyszczenie tabel przed wypełnieniem, aby uniknąć duplikatów
        DB::table('Notatki')->truncate();
        DB::table('Aktywnosci')->truncate();
        DB::table('SzanseSprzedazy')->truncate();
        DB::table('Leady')->truncate();
        DB::table('Kontakty')->truncate();
        DB::table('Klienci')->truncate();
        DB::table('Uzytkownicy')->truncate();

        // --- 1. Użytkownicy ---
        $uzytkownicyIds = [];
        $uzytkownicyIds[] = DB::table('Uzytkownicy')->insertGetId([
            'nazwa_uzytkownika' => 'admin',
            'haslo' => Hash::make('password'),
            'imie' => 'Adam',
            'nazwisko' => 'Adminowski',
            'email' => 'admin@example.com',
            'rola' => 'Administrator',
            'jest_aktywny' => true,
        ]);
        for ($i = 0; $i < 4; $i++) {
            $uzytkownicyIds[] = DB::table('Uzytkownicy')->insertGetId([
                'nazwa_uzytkownika' => $faker->unique()->userName,
                'haslo' => Hash::make('password'),
                'imie' => $faker->firstName,
                'nazwisko' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'rola' => 'Uzytkownik',
                'jest_aktywny' => true,
            ]);
        }

        // --- 2. Klienci ---
        $klienciIds = [];
        for ($i = 0; $i < 25; $i++) {
            $klienciIds[] = DB::table('Klienci')->insertGetId([
                'imie' => $faker->firstName,
                'nazwisko' => $faker->lastName,
                'nazwa_firmy' => $faker->company,
                'email' => $faker->unique()->companyEmail,
                'telefon' => $faker->phoneNumber,
                'adres' => $faker->streetAddress,
                'miasto' => $faker->city,
                'wojewodztwo' => 'mazowieckie', // Można by zrobić listę województw
                'kod_pocztowy' => $faker->postcode,
                'kraj' => 'Polska',
            ]);
        }
        
        // --- 3. Kontakty (przypisane do Klientów) ---
        $kontaktyIds = [];
        foreach($klienciIds as $klientId) {
            // Utwórz 1-3 kontakty dla każdego klienta
            for ($i = 0; $i < rand(1, 3); $i++) {
                $kontaktyIds[] = DB::table('Kontakty')->insertGetId([
                    'id_klienta' => $klientId,
                    'imie' => $faker->firstName,
                    'nazwisko' => $faker->lastName,
                    'stanowisko' => $faker->randomElement(['Dyrektor Handlowy', 'Specjalista ds. Zakupów', 'Prezes', 'Marketing Manager']),
                    'email' => $faker->unique()->safeEmail,
                    'telefon' => $faker->phoneNumber,
                ]);
            }
        }

        // --- 4. Leady ---
        $leadyIds = [];
        $zrodla = ['Strona WWW', 'Polecenie', 'Targi branżowe', 'Telefon', 'Kampania marketingowa'];
        $statusyLeadow = ['Nowy', 'W toku', 'Skwalifikowany', 'Utracony'];
        for ($i = 0; $i < 40; $i++) {
            $leadyIds[] = DB::table('Leady')->insertGetId([
                'imie' => $faker->firstName,
                'nazwisko' => $faker->lastName,
                'nazwa_firmy' => $faker->optional(0.7)->company, // Opcjonalnie, nie każdy lead musi mieć firmę
                'email' => $faker->unique()->safeEmail,
                'telefon' => $faker->phoneNumber,
                'zrodlo' => $faker->randomElement($zrodla),
                'status' => $faker->randomElement($statusyLeadow),
                'uwagi' => $faker->optional(0.5)->sentence,
            ]);
        }

        // --- 5. Szanse Sprzedaży (przypisane do Klientów i Kontaktów) ---
        $szanseIds = [];
        $etapy = ['Kwalifikacja', 'Analiza potrzeb', 'Prezentacja oferty', 'Negocjacje', 'Zamknięta wygrana', 'Zamknięta przegrana'];
        for ($i = 0; $i < 30; $i++) {
            $losowyKontaktId = $faker->randomElement($kontaktyIds);
            $klientDanegoKontaktu = DB::table('Kontakty')->where('id_kontaktu', $losowyKontaktId)->first()->id_klienta;

            $szanseIds[] = DB::table('SzanseSprzedazy')->insertGetId([
                'id_klienta' => $klientDanegoKontaktu,
                'id_kontaktu' => $losowyKontaktId,
                'nazwa' => 'Projekt: ' . $faker->sentence(3),
                'etap' => $faker->randomElement($etapy),
                'wartosc' => $faker->randomFloat(2, 1500, 100000),
                'data_zamkniecia' => $faker->dateTimeBetween('-3 months', '+6 months'),
                'opis' => $faker->paragraph(2),
            ]);
        }

        // --- 6. Aktywności ---
        $typyAktywnosci = ['Telefon', 'Email', 'Spotkanie', 'Wideokonferencja'];
        $statusyAktywnosci = ['Zrealizowano', 'Zaplanowano'];
        for ($i = 0; $i < 150; $i++) {
            $powiazanie = $faker->randomElement(['klient', 'lead', 'szansa']);
            $daneAktywnosci = [
                'id_klienta' => null,
                'id_leada' => null,
                'id_szansy' => null,
                'typ' => $faker->randomElement($typyAktywnosci),
                'temat' => 'Omówienie ' . $faker->word . ' ' . $faker->word,
                'opis' => $faker->sentence,
                'data_aktywnosci' => $faker->dateTimeBetween('-1 year', '+1 month'),
                'status' => $faker->randomElement($statusyAktywnosci),
                'utworzono_przez' => $faker->randomElement($uzytkownicyIds),
            ];

            if ($powiazanie === 'klient' && !empty($klienciIds)) {
                $daneAktywnosci['id_klienta'] = $faker->randomElement($klienciIds);
            } elseif ($powiazanie === 'lead' && !empty($leadyIds)) {
                $daneAktywnosci['id_leada'] = $faker->randomElement($leadyIds);
            } elseif ($powiazanie === 'szansa' && !empty($szanseIds)) {
                $daneAktywnosci['id_szansy'] = $faker->randomElement($szanseIds);
            }
            DB::table('Aktywnosci')->insert($daneAktywnosci);
        }

        // --- 7. Notatki ---
        for ($i = 0; $i < 100; $i++) {
            $powiazanie = $faker->randomElement(['klient', 'lead', 'szansa', 'kontakt']);
             $daneNotatki = [
                'id_klienta' => null,
                'id_leada' => null,
                'id_szansy' => null,
                'id_kontaktu' => null,
                'tresc_notatki' => $faker->paragraph(3),
                'utworzono_przez' => $faker->randomElement($uzytkownicyIds),
            ];

            if ($powiazanie === 'klient' && !empty($klienciIds)) {
                $daneNotatki['id_klienta'] = $faker->randomElement($klienciIds);
            } elseif ($powiazanie === 'lead' && !empty($leadyIds)) {
                $daneNotatki['id_leada'] = $faker->randomElement($leadyIds);
            } elseif ($powiazanie === 'szansa' && !empty($szanseIds)) {
                $daneNotatki['id_szansy'] = $faker->randomElement($szanseIds);
            } elseif ($powiazanie === 'kontakt' && !empty($kontaktyIds)) {
                $daneNotatki['id_kontaktu'] = $faker->randomElement($kontaktyIds);
            }
             DB::table('Notatki')->insert($daneNotatki);
        }
        
        // Włączenie sprawdzania kluczy obcych po zakończeniu
        Schema::enableForeignKeyConstraints();
    }
}