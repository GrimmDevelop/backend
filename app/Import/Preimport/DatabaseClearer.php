<?php

namespace App\Import\Preimport;

use DB;

class DatabaseClearer
{

    public function clearLettersDatabase()
    {
        DB::table('letters')->delete();
        DB::table('letter_codes')->delete();
        DB::table('locations')->delete();
        DB::statement('ALTER TABLE letters AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE letter_codes AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE letter_informations AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE letter_person AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE letter_prints AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE facsimiles AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE drafts AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE locations AUTO_INCREMENT = 1');
    }

    public function clearPeopleDatabase()
    {
        DB::table('persons')->delete();
        DB::table('person_codes')->delete();
        DB::statement('ALTER TABLE persons AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE person_codes AUTO_INCREMENT = 1');
    }

    public function clearBooksDatabase()
    {
        DB::table('books')->delete();
        DB::statement('ALTER TABLE books AUTO_INCREMENT = 1');
    }
}