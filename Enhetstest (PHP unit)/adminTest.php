<?php
include_once '../Model/domeneModell.php';
include_once '../DAL/adminDatabaseStub.php';
include_once '../BLL/adminLogikk.php';


class adminTest extends PHPUnit\Framework\TestCase 
{
    
function test_hentAlleKunderOk()
    {   
        // arrange
        $Admin= new Admin(new DBStub());
        // act
        $kunder= $Admin->hentAlleKunder();
        // assert
        $this->assertEquals("01010122344",$kunder[0]->personnummer);
        $this->assertEquals("Per",$kunder[0]->fornavn);
        $this->assertEquals("Hansen",$kunder[0]->etternavn);

        $this->assertEquals("Osloveien 82",$kunder[0]->adresse);
        $this->assertEquals("3270",$kunder[0]->postnr); 
        $this->assertEquals("12345678",$kunder[0]->telefonnr); 
        $this->assertEquals("HeiHei",$kunder[0]->passord); 
        $this->assertEquals("Asker",$kunder[0]->poststed);

        $this->assertEquals("01010110523",$kunder[1]->personnummer);
        $this->assertEquals("Lene",$kunder[1]->fornavn);
        $this->assertEquals("Jensen",$kunder[1]->etternavn);

        $this->assertEquals("Akerveien 22",$kunder[1]->adresse);
        $this->assertEquals("",$kunder[1]->postnr); 
        $this->assertEquals("22224444",$kunder[1]->telefonnr); 
        $this->assertEquals("HeiHei",$kunder[1]->passord); 
        $this->assertEquals("",$kunder[1]->poststed); 
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
        $kunde1->telefonnr = "11111111";
        $kunde1->passord = "HeiHei";
        
        $kunde2 = new kunde();
        $kunde2->fornavn = "Per";
        $kunde2->etternavn = "Testsen";
        $kunde2->personnummer = "12345678901";
        $kunde2->adresse = "Osloveien 82";
        $kunde2->postnr = "1234";
        $kunde2->poststed = "";
        $kunde2->telefonnr = "12345678";
        $kunde2->passord = "HeiHei";
         
        $Admin= new Admin(new DBStub());
        // act
        $endreKundeInfoIDBStub1 = $Admin->endreKundeInfo($kunde1);
        $endreKundeInfoIDBStub2 = $Admin->endreKundeInfo($kunde2);
        // assert
        $this->assertEquals("", $endreKundeInfoIDBStub1[0]->postnr);
        $this->assertEquals("Asker", $endreKundeInfoIDBStub1[0]->poststed);
        $this->assertEquals("Lene", $endreKundeInfoIDBStub1[0]->fornavn);
        $this->assertEquals("Jensen", $endreKundeInfoIDBStub1[0]->etternavn);
        $this->assertEquals("Askerveien 22", $endreKundeInfoIDBStub1[0]->adresse);
        $this->assertEquals("11111111", $endreKundeInfoIDBStub1[0]->telefonnr);// Kunden byttet telefonnummer.
        $this->assertEquals("HeiHei", $endreKundeInfoIDBStub1[0]->passord);
        $this->assertEquals("01010110523", $endreKundeInfoIDBStub1[0]->personnummer);
        $this->assertEquals("OK", $endreKundeInfoIDBStub1[1]);
        $this->assertEquals("1234", $endreKundeInfoIDBStub2[0]->postnr);
        $this->assertEquals("", $endreKundeInfoIDBStub2[0]->poststed);
        $this->assertEquals("Per", $endreKundeInfoIDBStub2[0]->fornavn);
        $this->assertEquals("Testsen", $endreKundeInfoIDBStub2[0]->etternavn); //Kunden byttet etternavn. 
        $this->assertEquals("Osloveien 82", $endreKundeInfoIDBStub2[0]->adresse);
        $this->assertEquals("12345678", $endreKundeInfoIDBStub2[0]->telefonnr);
        $this->assertEquals("HeiHei", $endreKundeInfoIDBStub2[0]->passord);
        $this->assertEquals("12345678901", $endreKundeInfoIDBStub2[0]->personnummer);
        $this->assertEquals("OK", $endreKundeInfoIDBStub2[1]);
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
        
        $Admin = new Admin(new DBStub());
        // act
        $registrerKundeOk = $Admin->registrerKunde($kunde);
       // assert
        $this->assertEquals("OK",$registrerKundeOk);
    }
    
    //spør læreren
    function test_registrerKunde_Feil()
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
        
        $Admin = new Admin(new DBStub());
        // act
        $registrerKundeFeil = $Admin->registrerKunde($kunde);
       // assert
        $this->assertEquals("Feil",$registrerKundeFeil);
    }
    
    function test_registrerKunde_Feil1()
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
        
        $Admin = new Admin(new DBStub());
        // act
        $registrerKundeFeil = $Admin->registrerKunde($kunde);
       // assert
        $this->assertEquals("Feil",$registrerKundeFeil);
    }
    
    function test_registrerKunde_tom()
    {
        $kunde = new kunde();
        $kunde->fornavn = "Lasae";
        $kunde->etternavn = "Jenassen";
        $kunde->personnummer = "12345690113";
        $kunde->adresse = "Askerveien 22";
        $kunde->postnr = "";
        $kunde->poststed = "";
        $kunde->telefonnr = "22224444";
        $kunde->passord = "HeiHei";
        
        $Admin = new Admin(new DBStub());
        // act
        $registrerKundeTom = $Admin->registrerKunde($kunde);
       // assert
        $this->assertEquals("Tom",$registrerKundeTom);
    }

    function test_slettKundeOK()
    {
        // arrange
        $Admin = new Admin(new DBStub());
        $personnummer= 01010122344;
        // act
        $OK = $Admin->slettKunde($personnummer);
       // assert
        $this->assertEquals("OK",$OK); 
    }
    
    function test_slettKundeFeil()
    {
        // arrange
        $Admin = new Admin(new DBStub());
        $personnummer= 06556765757;
        // act
        $OK = $Admin->slettKunde($personnummer);
       // assert
        $this->assertEquals("Feil",$OK); 
    }

    function test_registrerKontoOk()
    {
        // arrange
        $Admin = new Admin(new DBStub());
        $konto = new konto();
        $konto->kontonummer = "109010123456";
        $konto->personnummer ="12345678901";
        $konto->saldo = "656";
        $konto->type ="Lønnskonto";
        $konto->valuta = "NOK";
        // act
        $OK= $Admin->registrerKonto($konto);
        // assert
        $this->assertEquals("OK",$OK); 
    }
    
    function test_registrerKontoFeil()
    {
        $Admin = new Admin(new DBStub());
        $konto = new konto();
        $konto->kontonummer = "12345678902";
        $konto->personnummer ="12345678906";
        $konto->saldo = "576";
        $konto->type ="Lønnskonto";
        $konto->valuta = "NOK";
        // act
        $feil= $Admin->registrerKonto($konto);
        
        // assert
        $this->assertEquals("Feil personnummer",$feil); 
    }
    
    function test_registrerKontoTom (){
        // arrange
        $konto =new konto();
        
        $Admin = new Admin(new DBStub());
        // act

        $OK= $Admin->registrerKonto($konto);
        // assert
        $this->assertEquals("Feil",$OK); 
    }
    
    function test_endreKontoOk()
    {
       // arrange
        $Admin = new Admin(new DBStub());
        $konto = new konto();
        $konto->kontonummer ="435432643279";
        $konto->personnummer = "12345678901";
        $konto->saldo = "76";
        $konto->type = "Lønnskonto";
        $konto->valuta = "NOK";
        // act
        $OK = $Admin->endreKonto($konto);
       // assert
        $this->assertEquals($OK, "OK"); 
    }    
    
    function test_endreKontoFeilPersonnummer()
    {
      // arrange
        $Admin = new Admin(new DBStub());
        $konto = new konto();
        $konto->kontonummer ="232343243256";
        $konto->personnummer = "12345678901";
        $konto->saldo = "76";
        $konto->type = "Lønnskonto";
        $konto->valuta = "NOK";
        // act
        $OK = $Admin->endreKonto($konto);
       // assert
        $this->assertEquals($OK, "Feil"); 
    }    
    
    function test_endreKontoFeilKontonummer()
    {
      // arrange
        $Admin = new Admin(new DBStub());
        $konto = new konto();
        $konto->kontonummer ="435432643279";
        $konto->personnummer = "12343575345";
        $konto->saldo = "76";
        $konto->type = "Lønnskonto";
        $konto->valuta = "NOK";
        // act
        $OK = $Admin->endreKonto($konto);
       // assert
        $this->assertEquals($OK, "Feil"); 
    }    

    function test_slettKontoOk()
    {
        // arrange
        $konto= new konto();
        $konto->kontonummer= "12343432344";
        $Admin = new DBStub(new DBStub());
        // act
        $OK = $Admin->slettKonto($konto->kontonummer);
       // assert
        $this->assertEquals("OK",$OK); 
    }
    
    function test_slettKontoFeil()
    {
        // arrange
        $Admin = new Admin(new DBStub());
        $konto= new konto();
        $konto->kontonummer= "342";
        // act
        $OK = $Admin->slettKonto($konto->kontonummer);
       // assert
        $this->assertEquals("Feil",$OK); 
    }
    
    function test_hentAlleKontiOk()
    {   
        // arrange
        $Admin= new Admin(new DBStub());
        // act
        $konti= $Admin->hentAlleKonti();
        // assert
        $this->assertEquals("105010123456",$konti[0]->kontonummer);
        $this->assertEquals("01010110523",$konti[0]->personnummer);
        $this->assertEquals("720",$konti[0]->saldo); 
        $this->assertEquals("Lønnskont",$konti[0]->type); 
        $this->assertEquals("NOK",$konti[0]->valuta); 
        
        $this->assertEquals("10502012345",$konti[1]->kontonummer);
        $this->assertEquals("01010110523",$konti[1]->personnummer);
        $this->assertEquals("100500",$konti[1]->saldo); 
        $this->assertEquals("Sparekonto",$konti[1]->type); 
        $this->assertEquals("NOK",$konti[1]->valuta); 
      
        $this->assertEquals("22334412345",$konti[2]->kontonummer);
        $this->assertEquals("01010110523",$konti[2]->personnummer);
        $this->assertEquals("10234.5",$konti[2]->saldo); 
        $this->assertEquals("Brukskonto",$konti[2]->type); 
        $this->assertEquals("NOK",$konti[2]->valuta); 
    }
}