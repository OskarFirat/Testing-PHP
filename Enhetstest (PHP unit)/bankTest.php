<?php
include_once '../Model/domeneModell.php';
include_once '../DAL/databaseStub.php';
include_once '../BLL/bankLogikk.php';

class bankTest extends PHPUnit\Framework\TestCase {
    
    public function testsjekkLoggInn_BankLogikk_FeilPersonnummer() 
    {
        // arrange
        $feilpersonnummer = 1;
        $riktigpassord = "heihei";
        $bank = new Bank(new BankDBStub());
        // act
        $hentEnKundeMedFeilPersonnummer = $bank->sjekkLoggInn($feilpersonnummer, $riktigpassord);
        // assert
        $this->assertEquals("Feil i personnummer",$hentEnKundeMedFeilPersonnummer); 
    }
    
    public function testsjekkLoggInn_BankLogikk_FeilPassord() 
    {
        // arrange
        $riktigpersonnummer = "01010110523";
        $feilpassord = "????";
        $bank = new Bank(new BankDBStub());
        // act
        $hentEnKundeMedFeilPassord = $bank->sjekkLoggInn($riktigpersonnummer, $feilpassord);
        // assert
        $this->assertEquals("Feil i passord", $hentEnKundeMedFeilPassord); 
    }
    
    public function testsjekkLoggInn_DBStubOk() 
    {
        // arrange
        $riktigpersonnummer = "01010110523";
        $riktigpassord = "heihei";
        $bank = new Bank(new BankDBStub());
        // act
        $hentEnKundeMedriktiginfoIDBStub = $bank->sjekkLoggInn($riktigpersonnummer, $riktigpassord);
        // assert
        $this->assertEquals("OK", $hentEnKundeMedriktiginfoIDBStub); 
    }
    
    public function testsjekkLoggInn_DBStubFeil() 
    {
        // arrange
        $riktigpersonnummer = "11111111111";
        $riktigpassord = "heihei";
        $bank = new Bank(new BankDBStub());
        // act
        $hentEnKundeMedfeilinfoIDBStub = $bank->sjekkLoggInn($riktigpersonnummer, $riktigpassord);
        // assert
        $this->assertEquals("Feil", $hentEnKundeMedfeilinfoIDBStub); 
    }
    
    function testhentKonti_DBStubOk()
    {
        $riktigPersonnummer = "01010110523";
        $bank = new Bank(new BankDBStub());
        $hentKontiMedRiktigDBStub = $bank->hentKonti($riktigPersonnummer);
        $this->assertEquals("105010123456",$hentKontiMedRiktigDBStub[0]->kontonummer); 
        $this->assertEquals("105020123456",$hentKontiMedRiktigDBStub[1]->kontonummer); 
        $this->assertEquals("22334412345",$hentKontiMedRiktigDBStub[2]->kontonummer); 
    }
    
    function testhentKonti_DBStubFeil()
    {
        $feilPersonnummer = "11111111111";
        $bank = new Bank(new BankDBStub());
        $hentKontiMedFeilDBStub = $bank->hentKonti($feilPersonnummer);
        $this->assertEquals("",$hentKontiMedFeilDBStub);  
    }
    
    function testhentSaldi_DBStubOK()
    {
        $riktigPersonnummer = "01010110523";
        $bank = new Bank(new BankDBStub());
        $hentSaldiMedRiktigIDBStub = $bank->hentSaldi($riktigPersonnummer);
        $this->assertEquals("01010110523",$hentSaldiMedRiktigIDBStub[0]->personnummer); 
        $this->assertEquals("105010123456",$hentSaldiMedRiktigIDBStub[0]->kontonummer); 
        $this->assertEquals("720",$hentSaldiMedRiktigIDBStub[0]->saldo); 
        $this->assertEquals("Lønnskonto",$hentSaldiMedRiktigIDBStub[0]->type); 
        $this->assertEquals("NOK",$hentSaldiMedRiktigIDBStub[0]->valuta); 
        $this->assertEquals("01010110523",$hentSaldiMedRiktigIDBStub[1]->personnummer); 
        $this->assertEquals("105020123456",$hentSaldiMedRiktigIDBStub[1]->kontonummer); 
        $this->assertEquals("100500",$hentSaldiMedRiktigIDBStub[1]->saldo); 
        $this->assertEquals("Sparekonto",$hentSaldiMedRiktigIDBStub[1]->type); 
        $this->assertEquals("NOK",$hentSaldiMedRiktigIDBStub[1]->valuta);
        $this->assertEquals("01010110523",$hentSaldiMedRiktigIDBStub[2]->personnummer); 
        $this->assertEquals("22334412345",$hentSaldiMedRiktigIDBStub[2]->kontonummer); 
        $this->assertEquals("10234.5",$hentSaldiMedRiktigIDBStub[2]->saldo); 
        $this->assertEquals("Brukskonto",$hentSaldiMedRiktigIDBStub[2]->type); 
        $this->assertEquals("NOK",$hentSaldiMedRiktigIDBStub[2]->valuta);
    }
    
    function testhentSaldi_DBStubFeil()
    {
        $feilPersonnummer = "11111111111";
        $bank = new Bank(new BankDBStub());
        $hentSaldiMedFeilIDBStub = $bank->hentSaldi($feilPersonnummer);
        $this->assertEquals("",$hentSaldiMedFeilIDBStub); 
    }
    
    public function testregistrerBetaling_DBStubOk() 
    {
        // arrange
        $konto = "105010123456";
        $transaksjon = "1";
        $bank = new Bank(new BankDBStub());
        // act
        $registrerBetalingMedriktiginfoIDBStub = $bank->registrerBetaling($konto, $transaksjon);
        // assert
        $this->assertEquals("OK", $registrerBetalingMedriktiginfoIDBStub); 
    }
    
    public function testregistrerBetaling_DBStubFeil() 
    {
        // arrange
        $konto = "1";
        $transaksjon = "11";
        $bank = new Bank(new BankDBStub());
        // act
        $registrerBetalingMedfeilinfoIDBStub = $bank->registrerBetaling($konto, $transaksjon);
        // assert
        $this->assertEquals("Feil", $registrerBetalingMedfeilinfoIDBStub); 
    }
    
    public function testhentBetalinger_DBStubOk() 
    {
        // arrange
        $riktigPersonnummer1 = "01010110523";
        $riktigPersonnummer2 = "12345678901";
        $bank = new Bank(new BankDBStub());
        // act
        $hentBetalingerMedOkinfoIDBStub1 = $bank->hentBetalinger($riktigPersonnummer1);
        $hentBetalingerMedOkinfoIDBStub2 = $bank->hentBetalinger($riktigPersonnummer2);
        // assert
        $this->assertEquals("", $hentBetalingerMedOkinfoIDBStub1); 
        $this->assertEquals("", $hentBetalingerMedOkinfoIDBStub2); 
    }
    
    public function testutforBetaling_DBStubOk() 
    {
        // arrange
        $TxID1 = "1";
        $TxID2 = "2";
        $TxID4 = "4";
        $TxID7 = "7";
        $TxID8 = "8";
        $TxID9 = "9";

        $bank = new Bank(new BankDBStub());
        // act
        $utforBetalingMedOKinfoIDBStub1 = $bank->utforBetaling($TxID1);
        $utforBetalingMedOKinfoIDBStub2 = $bank->utforBetaling($TxID2);
        $utforBetalingMedOKinfoIDBStub3 = $bank->utforBetaling($TxID4);
        $utforBetalingMedOKinfoIDBStub4 = $bank->utforBetaling($TxID7);
        $utforBetalingMedOKinfoIDBStub5 = $bank->utforBetaling($TxID8);
        $utforBetalingMedOKinfoIDBStub6 = $bank->utforBetaling($TxID9);
        //assert
        $this->assertEquals("0", $utforBetalingMedOKinfoIDBStub1[0]->avventer); 
        $this->assertEquals("-5074.2", $utforBetalingMedOKinfoIDBStub1[1]->saldo);
        $this->assertEquals("OK", $utforBetalingMedOKinfoIDBStub1[2]);
        $this->assertEquals("0", $utforBetalingMedOKinfoIDBStub2[0]->avventer); 
        $this->assertEquals("-5575.1", $utforBetalingMedOKinfoIDBStub2[1]->saldo);
        $this->assertEquals("OK", $utforBetalingMedOKinfoIDBStub2[2]);
        $this->assertEquals("0", $utforBetalingMedOKinfoIDBStub3[0]->avventer);
        $this->assertEquals("-174.2", $utforBetalingMedOKinfoIDBStub3[1]->saldo);
        $this->assertEquals("OK", $utforBetalingMedOKinfoIDBStub3[2]); 
        $this->assertEquals("0", $utforBetalingMedOKinfoIDBStub4[0]->avventer); 
        $this->assertEquals("-8174.7", $utforBetalingMedOKinfoIDBStub4[1]->saldo);
        $this->assertEquals("OK", $utforBetalingMedOKinfoIDBStub4[2]);
        $this->assertEquals("0", $utforBetalingMedOKinfoIDBStub5[0]->avventer); 
        $this->assertEquals("-5189.7", $utforBetalingMedOKinfoIDBStub5[1]->saldo);
        $this->assertEquals("OK", $utforBetalingMedOKinfoIDBStub5[2]);
        $this->assertEquals("0", $utforBetalingMedOKinfoIDBStub6[0]->avventer); 
        $this->assertEquals("-5299.7", $utforBetalingMedOKinfoIDBStub6[1]->saldo);
        $this->assertEquals("OK", $utforBetalingMedOKinfoIDBStub6[2]);
    }
    
    public function testutforBetaling_DBStubFeil() 
    {
        // arrange
        $TxID1 = Null;
        $TxID2 = "0";
        $TxID3 = "10";
        $TxID4 = "3";
        $TxID5 = "5";
        $TxID6 = "6";

        $bank = new Bank(new BankDBStub());
        // act
        $utforBetalingMedFeilinfoIDBStub1 = $bank->utforBetaling($TxID1);
        $utforBetalingMedFeilinfoIDBStub2 = $bank->utforBetaling($TxID2);
        $utforBetalingMedFeilinfoIDBStub3 = $bank->utforBetaling($TxID3);
        $utforBetalingMedFeilinfoIDBStub4 = $bank->utforBetaling($TxID4);
        $utforBetalingMedFeilinfoIDBStub5 = $bank->utforBetaling($TxID5);
        $utforBetalingMedFeilinfoIDBStub6 = $bank->utforBetaling($TxID6);
        // assert
        $this->assertEquals("Feil", $utforBetalingMedFeilinfoIDBStub1);
        $this->assertEquals("Feil", $utforBetalingMedFeilinfoIDBStub2);
        $this->assertEquals("Feil", $utforBetalingMedFeilinfoIDBStub3);
        $this->assertEquals("Feil", $utforBetalingMedFeilinfoIDBStub4[0]);
        $this->assertEquals("Feil", $utforBetalingMedFeilinfoIDBStub5[0]);
        $this->assertEquals("Feil", $utforBetalingMedFeilinfoIDBStub6[0]);
    }
   
    public function testendreKundeInfoOk()
    { 
        $kunde1 = new kunde();
        $kunde1->fornavn = "Lene";
        $kunde1->etternavn = "Jensen";
        $kunde1->personnummer = "01010110523";
        $kunde1->adresse = "Askerveien 22";
        $kunde1->postnr = "";
        $kunde1->poststed = "Asker";
        $kunde1->telefonnr = "11111111"; // Kunden ville bytte telefon nummer.
        $kunde1->passord = "HeiHei";
        
        $kunde2 = new kunde();
        $kunde2->fornavn = "Per";
        $kunde2->etternavn = "Testmannen"; // Kunden ville bytte etternavn.
        $kunde2->personnummer = "12345678901";
        $kunde2->adresse = "Osloveien 82";
        $kunde2->postnr = "1234";
        $kunde2->poststed = "";
        $kunde2->telefonnr = "12345678";
        $kunde2->passord = "HeiHei";
         
        $bank = new Bank(new BankDBStub());
        // act
        $endreKundeInfoIDBStub1 = $bank->endreKundeInfo($kunde1);
        $endreKundeInfoIDBStub2 = $bank->endreKundeInfo($kunde2);
        // assert
        $this->assertEquals("", $endreKundeInfoIDBStub1[0]->postnr);
        $this->assertEquals("Asker", $endreKundeInfoIDBStub1[0]->poststed);
        $this->assertEquals("Lene", $endreKundeInfoIDBStub1[0]->fornavn);
        $this->assertEquals("Jensen", $endreKundeInfoIDBStub1[0]->etternavn);
        $this->assertEquals("Askerveien 22", $endreKundeInfoIDBStub1[0]->adresse);
        $this->assertEquals("11111111", $endreKundeInfoIDBStub1[0]->telefonnr);
        $this->assertEquals("HeiHei", $endreKundeInfoIDBStub1[0]->passord);
        $this->assertEquals("01010110523", $endreKundeInfoIDBStub1[0]->personnummer);
        $this->assertEquals("OK", $endreKundeInfoIDBStub1[1]);
        $this->assertEquals("1234", $endreKundeInfoIDBStub2[0]->postnr);
        $this->assertEquals("", $endreKundeInfoIDBStub2[0]->poststed);
        $this->assertEquals("Per", $endreKundeInfoIDBStub2[0]->fornavn);
        $this->assertEquals("Testmannen", $endreKundeInfoIDBStub2[0]->etternavn);
        $this->assertEquals("Osloveien 82", $endreKundeInfoIDBStub2[0]->adresse);
        $this->assertEquals("12345678", $endreKundeInfoIDBStub2[0]->telefonnr);
        $this->assertEquals("HeiHei", $endreKundeInfoIDBStub2[0]->passord);
        $this->assertEquals("12345678901", $endreKundeInfoIDBStub2[0]->personnummer);
        $this->assertEquals("OK", $endreKundeInfoIDBStub2[1]);
    }
    
    public function testhentKundeInfoOk()
    {
        $kunde1 = new kunde();
        $kunde1->fornavn = "Lene";
        $kunde1->etternavn = "Jensen";
        $kunde1->personnummer = "01010110523";
        $kunde1->adresse = "Askerveien 22";
        $kunde1->postnr = "3270";
        $kunde1->poststed = "Asker";
        $kunde1->telefonnr = "22224444";
        $kunde1->passord = "HeiHei";
        
        $bank = new Bank(new BankDBStub());
        // act
        $endreKundeInfoIDBStub1 = $bank->hentKundeInfo($kunde1->personnummer);
        
        // assert
        $this->assertEquals("3270", $endreKundeInfoIDBStub1[0]->postnr);
        $this->assertEquals("Asker", $endreKundeInfoIDBStub1[0]->poststed);
        $this->assertEquals("Lene", $endreKundeInfoIDBStub1[0]->fornavn);
        $this->assertEquals("Jensen", $endreKundeInfoIDBStub1[0]->etternavn);
        $this->assertEquals("Askerveien 22", $endreKundeInfoIDBStub1[0]->adresse);
        $this->assertEquals("22224444", $endreKundeInfoIDBStub1[0]->telefonnr);
        $this->assertEquals("HeiHei", $endreKundeInfoIDBStub1[0]->passord);
        $this->assertEquals("01010110523", $endreKundeInfoIDBStub1[0]->personnummer);
    }
    
    public function testhentKundeInfoFeil()
    {
        $kunde1 = new kunde();
        $kunde1->fornavn = "Feil";
        $kunde1->etternavn = "Feilemann";
        $kunde1->personnummer = "";
        $kunde1->adresse = "Feileveien 72";
        $kunde1->postnr = "";
        $kunde1->poststed = "";
        $kunde1->telefonnr = "12345678";
        $kunde1->passord = "FeilFeil";
        $kunde2 = new kunde();
        $kunde2->fornavn = "Per";
        $kunde2->etternavn = "Hansen";
        $kunde2->personnummer = "12345678901";
        $kunde2->adresse = "Osloveien 82";
        $kunde2->postnr = "1234";
        $kunde2->poststed = "";
        $kunde2->telefonnr = "12345678";
        $kunde2->passord = "HeiHei";
        
        $bank = new Bank(new BankDBStub());
        // act
        $endreKundeInfoIDBStub1 = $bank->hentKundeInfo($kunde1->personnummer);
        $endreKundeInfoIDBStub2 = $bank->hentKundeInfo($kunde2->personnummer);
        // assert
        $this->assertEquals("Feil", $endreKundeInfoIDBStub1);
        $this->assertEquals("Feil", $endreKundeInfoIDBStub2);
    }
    
    function test_slettKundeOk()
    {
        // arrange
        $bank = new BankDBStub();
        $personnummer= 01010122344;
        // act
        $slettKundeOk = $bank->slettKunde($personnummer);
       // assert
        $this->assertEquals("OK",$slettKundeOk); 
    }
    
    function test_slettKunde_Feil()
    {
        // arrange
        $bank = new BankDBStub();
        $personnummer= 06556765757;
        // act
        $slettKundeFeil = $bank->slettKunde($personnummer);
       // assert
        $this->assertEquals("Feil",$slettKundeFeil); 
    }
    
    function test_registrerKundeOk()
    {
        $kunde = new kunde();
        $kunde->fornavn = "Lene";
        $kunde->etternavn = "Jensen";
        $kunde->personnummer = "10123456723";
        $kunde->adresse = "Askerveien 22";
        $kunde->postnr = "3270";
        $kunde->poststed = "Asker";
        $kunde->telefonnr = "22224444";
        $kunde->passord = "HeiHei";
  
        $bank = new BankDBStub();
        // act
        $registrerKundeOk = $bank->registrerKunde($kunde);
       // assert
        $this->assertEquals("OK",$registrerKundeOk);
    }
    
    function test_registrerKundeFeil()
    {
        $kunde = new kunde();
        $kunde->fornavn = "Lasae";
        $kunde->etternavn = "Jenassen";
        $kunde->personnummer = "12345678901";
        $kunde->adresse = "Askerveien 22";
        $kunde->postnr = "1";
        $kunde->poststed = "1";
        $kunde->telefonnr = "22224444";
        $kunde->passord = "HeiHei";
        
        $bank = new BankDBStub();
        // act
        $registrerKundeFeil = $bank->registrerKunde($kunde);
       // assert
        $this->assertEquals("Feil",$registrerKundeFeil);
    }
    
    function test_registrerKundeFeil1()
    {
        $kunde = new kunde();
        $kunde->fornavn = "Lasae";
        $kunde->etternavn = "Jenassen";
        $kunde->personnummer = "12345678901";
        $kunde->adresse = "Askerveien 22";
        $kunde->postnr = "3242";
        $kunde->poststed = "dgfd";
        $kunde->telefonnr = "22224444";
        $kunde->passord = "HeiHei";
        
        $bank = new BankDBStub();
        // act
        $registrerKundeFeil = $bank->registrerKunde($kunde);
       // assert
        $this->assertEquals("Feil",$registrerKundeFeil);
    }
    
    function test_registrerKundeTom()
    {
        $kunde = new kunde();
        $kunde->fornavn = "";
        $kunde->etternavn = "";
        $kunde->personnummer = "";
        $kunde->adresse = "";
        $kunde->postnr = "";
        $kunde->poststed = "";
        $kunde->telefonnr = "";
        $kunde->passord = "";
        
        $bank = new BankDBStub();
        // act
        $registrerKundeTom = $bank->registrerKunde($kunde);
       // assert
        $this->assertEquals("Tom",$registrerKundeTom);
    }
    
    function test_hentEnKunde()
    {   
        $personnummer = "12345678901";
        // arrange
        $bank = new BankDBStub();
        // act
        $hentEnKunde = $bank->hentEnKunde($personnummer);
        // assert
        $this->assertEquals("12345678901",$hentEnKunde->personnummer);
        $this->assertEquals("Per Olsen",$hentEnKunde->navn);
        $this->assertEquals("Osloveien 82, 0270 Oslo",$hentEnKunde->adresse); 
        $this->assertEquals("12345678",$hentEnKunde->telefonnr);     
    }
    
    function test_hentAlleKunderOk()
    {   
        // arrange
        $bank = new BankDBStub();
        // act
        $hentAlleKunder = $bank->hentAlleKunder();
        // assert
        $this->assertEquals("01010122344",$hentAlleKunder[0]->personnummer);
        $this->assertEquals("Per Olsen",$hentAlleKunder[0]->navn);
        $this->assertEquals("Osloveien 82 0270 Oslo",$hentAlleKunder[0]->adresse); 
        $this->assertEquals("12345678",$hentAlleKunder[0]->telefonnr); 
        $this->assertEquals("01010122344",$hentAlleKunder[1]->personnummer);
        $this->assertEquals("Line Jensen",$hentAlleKunder[1]->navn); 
        $this->assertEquals("Askerveien 100, 1379 Asker",$hentAlleKunder[1]->adresse); 
        $this->assertEquals("92876789",$hentAlleKunder[1]->telefonnr); 
        $this->assertEquals("02020233455",$hentAlleKunder[2]->personnummer);
        $this->assertEquals("Ole Olsen",$hentAlleKunder[2]->navn); 
        $this->assertEquals("Bærumsveien 23, 1234 Bærum",$hentAlleKunder[2]->adresse); 
        $this->assertEquals("99889988",$hentAlleKunder[2]->telefonnr);     
    }
    
    public function testDatoFeilTransaksjoner() 
    {
        // arrange
        $kontoNr = "10502023523";
        $fraDato = '2015-03-27';
        $tilDato = '2015-03-22';
        $bank=new Bank(new BankDBStub());
        // act
        $konto= $bank->hentTransaksjoner($kontoNr, $fraDato, $tilDato);
        // assert
        $this->assertEquals("Fra dato må være større enn tildato",$konto); 
    }
    
    public function testIngenTransaksjoner() 
    {
        // arrange
        $kontoNr = "10502023523";
        $fraDato = '2015-03-20';
        $tilDato = '2015-03-22';
        $bank=new Bank(new BankDBStub());
        // act
        $konto= $bank->hentTransaksjoner($kontoNr, $fraDato, $tilDato);
        // assert
        $this->assertEquals("010101234567",$konto->personnummer); 
        $this->assertEquals($kontoNr,$konto->kontonummer);
        $this->assertEquals("Sparekonto",$konto->type);
        $this->assertEquals(2300.34,$konto->saldo); 
        $this->assertEquals("NOK",$konto->valuta); 
        $tomtArray = array();
        $this->assertEquals($tomtArray,$konto->transaksjoner);
    }
     
    public function testEnTransaksjon() 
    {
        // arrange
        $kontoNr = "10502023523";
        $fraDato = '2015-03-26';
        $tilDato = '2015-03-26';
        $bank=new Bank(new BankDBStub());
        // act
        $konto= $bank->hentTransaksjoner($kontoNr, $fraDato, $tilDato);
        // assert
        $this->assertEquals("010101234567",$konto->personnummer); 
        $this->assertEquals($kontoNr,$konto->kontonummer);
        $this->assertEquals("Sparekonto",$konto->type);
        $this->assertEquals(2300.34,$konto->saldo); 
        $this->assertEquals("NOK",$konto->valuta); 
        $this->assertEquals('2015-03-26',$konto->transaksjoner[0]->dato);
        $this->assertEquals(134.4,$konto->transaksjoner[0]->transaksjonBelop);
        $this->assertEquals("22342344556",$konto->transaksjoner[0]->fraTilKontonummer);
        $this->assertEquals("Meny Holtet",$konto->transaksjoner[0]->melding);
    }
    
    public function testToTransaksjoner() 
    {
        // arrange
        $kontoNr = "10502023523";
        $fraDato = '2015-03-27';
        $tilDato = '2015-03-30';
        $bank=new Bank(new BankDBStub());
        // act
        $konto= $bank->hentTransaksjoner($kontoNr, $fraDato, $tilDato);
        // assert
        $this->assertEquals("010101234567",$konto->personnummer); 
        $this->assertEquals($kontoNr,$konto->kontonummer);
        $this->assertEquals("Sparekonto",$konto->type);
        $this->assertEquals(2300.34,$konto->saldo); 
        $this->assertEquals("NOK",$konto->valuta); 
        $this->assertEquals('2015-03-27',$konto->transaksjoner[0]->dato);
        $this->assertEquals(-2056.45,$konto->transaksjoner[0]->transaksjonBelop);
        $this->assertEquals("114342344556",$konto->transaksjoner[0]->fraTilKontonummer);
        $this->assertEquals("Husleie",$konto->transaksjoner[0]->melding);
        $this->assertEquals('2015-03-29',$konto->transaksjoner[1]->dato);
        $this->assertEquals(1454.45,$konto->transaksjoner[1]->transaksjonBelop);
        $this->assertEquals("114342344511",$konto->transaksjoner[1]->fraTilKontonummer);
        $this->assertEquals("Lekeland",$konto->transaksjoner[1]->melding);
    }
    
    public function testAlleTransaksjoner() 
    {
        // arrange
        $kontoNr = "10502023523";
        $fraDato = '2015-03-26';
        $tilDato = '2015-03-30';
        $bank=new Bank(new BankDBStub());
        // act
        $konto= $bank->hentTransaksjoner($kontoNr, $fraDato, $tilDato);
        // assert
        $this->assertEquals("010101234567",$konto->personnummer); 
        $this->assertEquals($kontoNr,$konto->kontonummer);
        $this->assertEquals("Sparekonto",$konto->type);
        $this->assertEquals(2300.34,$konto->saldo); 
        $this->assertEquals("NOK",$konto->valuta);
        $this->assertEquals('2015-03-26',$konto->transaksjoner[0]->dato);
        $this->assertEquals(134.4,$konto->transaksjoner[0]->transaksjonBelop);
        $this->assertEquals("22342344556",$konto->transaksjoner[0]->fraTilKontonummer);
        $this->assertEquals("Meny Holtet",$konto->transaksjoner[0]->melding);
        $this->assertEquals('2015-03-27',$konto->transaksjoner[1]->dato);
        $this->assertEquals(-2056.45,$konto->transaksjoner[1]->transaksjonBelop);
        $this->assertEquals("114342344556",$konto->transaksjoner[1]->fraTilKontonummer);
        $this->assertEquals("Husleie",$konto->transaksjoner[1]->melding);
        $this->assertEquals('2015-03-29',$konto->transaksjoner[2]->dato);
        $this->assertEquals(1454.45,$konto->transaksjoner[2]->transaksjonBelop);
        $this->assertEquals("114342344511",$konto->transaksjoner[2]->fraTilKontonummer);
        $this->assertEquals("Lekeland",$konto->transaksjoner[2]->melding);
    }
}


