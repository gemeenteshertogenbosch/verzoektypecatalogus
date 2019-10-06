<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


use App\Entity\RequestType;
use App\Entity\Property;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	/*
    	 *  Verhuizen   	  
    	 */
    	$verhuizenNL = new RequestType();
    	$verhuizenNL->setId('2bfb3cea-b5b5-459c-b3e0-e1100089a11a');
    	$verhuizenNL->setSourceOrganisation('0000');
    	$verhuizenNL->setName('Verhuizen');
    	$verhuizenNL->setDescription('Het doorgeven van een verhuizing aan een gemeente');
    	$manager->persist($verhuizenNL);
    	
    	$property= new Property();
    	//$property->setId('');
    	$property->setTitle('Datum');
    	$property->setType('string');
    	$property->setFormat('date');
    	$property->setDescription('Waneer gaat u verhuizen?');
    	$property->setRequestType($verhuizenNL);
    	$manager->persist($property);
    	
    	$property= new Property();
    	//$property->setId('');
    	$property->setTitle('Adress');
    	$property->setType('string');
    	$property->setFormat('bag');
    	$property->setRequired(true);
    	$property->setDescription('Waar gaat u heen verhuizen?');
    	$property->setRequestType($verhuizenNL);
    	$manager->persist($property);
    	
    	$property= new Property();
    	//$property->setId('');
    	$property->setTitle('Wie');
    	$property->setType('arrays');
    	$property->setFormat('bsn');
    	$property->setRequired(true);
    	$property->setDescription('Wie gaan er verhuizen?');
    	$property->setRequestType($verhuizenNL);
    	$manager->persist($property);
    	
    	$verhuizenDenBosh = new RequestType();
    	$verhuizenDenBosh->setId('939f5d60-e5bd-40b2-9ccd-117cea8b3cbe');
    	$verhuizenDenBosh->setName('Verhuizen');
    	$verhuizenDenBosh->setDescription('Het doorgeven van een verhuizing aan de gemeente \'s-Hertogenbosch');
    	$verhuizenDenBosh->setSourceOrganisation('001709124');
    	$verhuizenDenBosh->setExtends($verhuizenNL);
    	$manager->persist($verhuizenDenBosh);
    	
    	$verhuizenEindhoven = new RequestType(); 
    	$verhuizenEindhoven->setId('2bfb3cea-b5b5-459c-b3e0-e1100089a11a');
    	$verhuizenEindhoven->setName('Verhuizen');
    	$verhuizenEindhoven->setDescription('Het doorgeven van een verhuizing aan de gemeente Eindhoven');
    	$verhuizenEindhoven->setSourceOrganisation('001902763');
    	$verhuizenEindhoven->setId('fc79c4c9-b3b3-4258-bdbb-449262f3e5d7');
    	$verhuizenEindhoven->setExtends($verhuizenNL);
    	$manager->persist($verhuizenEindhoven);
    	
    	$property = new Property();
    	//$verhuizenNL->setId('');
    	$property->setTitle('Eigenaar');
    	$property->setDescription('Bent u de eigenaar van de woning waar u heen verhuist?');
    	$property->setType('boolean');
    	$property->setFormat('boolean');
    	$property->setRequired(true);
    	$property->setRequestType($verhuizenNL);
    	$manager->persist($property);
    	
    	$property = new Property();
    	//$verhuizenNL->setId('');
    	$property->setTitle('Doorgeven gegevens');
    	$property->setDescription('Wilt u dat we uw verhuizing tevens doorgeven aan postNl?');
    	$property->setType('boolean');
    	$property->setFormat('boolean');
    	$property->setRequestType($verhuizenNL);
    	$manager->persist($property);
    	
    	/*
    	 *  Trouwen
    	 */
    	$meldingTrouwenNL= new RequestType();
    	$meldingTrouwenNL->setId('d009032d-8fdd-4d09-bf43-5000f19737a7');
    	$meldingTrouwenNL->setSourceOrganisation('0000');
    	$meldingTrouwenNL->setName('Melding voorgenomen huwelijk');
    	$meldingTrouwenNL->setDescription('Melding voorgenomen huwelijk');
    	
    	$property= new Property();
    	//$verhuizenNL->setId('');
    	$property->setTitle('Partner1');
    	$property->setType('string');
    	$property->setFormat('bsn');
    	$property->setRequired(true);
    	$property->setDescription('Wiens huwelijkmoet worden omgezet');
    	$property->setRequestType($meldingTrouwenNL);
    	$manager->persist($property);
    	
    	$property= new Property();
    	//$verhuizenNL->setId('');
    	$property->setTitle('Partner2');
    	$property->setType('string');
    	$property->setFormat('bsn');
    	$property->setRequired(true);
    	$property->setDescription('Wiens huwelijkmoet worden omgezet');
    	$property->setRequestType($meldingTrouwenNL);
    	$manager->persist($property);    	
    	
    	$omzettingNL = new RequestType();
    	$omzettingNL->setId('dc65cbe9-d608-4946-b3d4-368b5b0c4061');
    	$omzettingNL->setSourceOrganisation('0000');
    	$omzettingNL->setName('Omzetting');
    	$omzettingNL->setDescription('Het omzetten van een reeds bestaand partnerschap in een huwelijk ');
    	$manager->persist($omzettingNL);
    	
    	$property= new Property();
    	//$verhuizenNL->setId('');
    	$property->setTitle('Ingangsdatum');
    	$property->setType('string');
    	$property->setFormat('date');
    	$property->setDescription('Heeft u een omzettings trouwdatum?');
    	$property->setRequestType($verhuizenNL);
    	$manager->persist($property);
    	
    	$property= new Property();
    	//$verhuizenNL->setId('');
    	$property->setTitle('Partner1');
    	$property->setType('string');
    	$property->setFormat('bsn');
    	$property->setRequired(true);
    	$property->setDescription('Wiens huwelijkmoet worden omgezet');
    	$property->setRequestType($omzettingNL);
    	$manager->persist($property);
    	    	
    	$property= new Property();
    	//$verhuizenNL->setId('');
    	$property->setTitle('Partner 2');
    	$property->setType('string');
    	$property->setFormat('bsn');
    	$property->setRequired(true);
    	$property->setDescription('Wiens huwelijkmoet worden omgezet');
    	$property->setRequestType($omzettingNL);
    	$manager->persist($property);    	
    	
    	$trouwenNL = new RequestType();
    	$trouwenNL->setId('2a0efa35-e911-44d9-8cf1-54bea575be81');
    	$trouwenNL->setSourceOrganisation('000');
    	$trouwenNL->setName('Huwelijk / Partnerschap');
    	$trouwenNL->setDescription('Huwelijk / Partnerschap');
    	$manager->persist($trouwenNL);
    	
    	$property= new Property();
    	//$verhuizenNL->setId('');
    	$property->setTitle('Melding ');
    	$property->setType('string');
    	$property->setFormat('uri');
    	$property->setDescription('Als het goed is heeft u reeds melding gedaan van uw voorgenomen huwelijk, onder welke uri kunnen we deze terugvinden?');
    	$property->setRequestType($trouwenNL);
    	$manager->persist($property);
    	
    	$property= new Property();
    	//$property->setId('');
    	$property->setTitle('Datum');
    	$property->setType('string');
    	$property->setFormat('date');
    	$property->setDescription('Heeft u een omzettings trouwdatum?');
    	$property->setRequestType($trouwenNL);
    	$manager->persist($property);
    	
    	$property= new Property();
    	//$property->setId('');
    	$property->setTitle('Type');
    	$property->setType('string');
    	$property->setFormat('strin');
    	$property->setMaxLength('12');
    	$property->setMinLength('7');
    	$property->setEnum(['trouwen','partnerschap']);
    	$property->setRequired(true);
    	$property->setDescription('Wilt u een huwelijk of partnerschap aangaan?');
    	$property->setRequestType($trouwenNL);
    	$manager->persist($property);
    	
    	$property= new Property();
    	//$property->setId('');
    	$property->setTitle('Partner 1');
    	$property->setType('string');
    	$property->setFormat('bsn');
    	$property->setMaxLength('9');
    	$property->setMinLength('9');
    	$property->setRequired(true);
    	$property->setDescription('Wie is de eerste partner?');
    	$property->setRequestType($trouwenNL);
    	$manager->persist($property);
    	
    	$property= new Property();
    	//$property->setId('');
    	$property->setTitle('Partner 2');
    	$property->setType('string');
    	$property->setFormat('bsn');
    	$property->setMaxLength('12');
    	$property->setMinLength('7');
    	$property->setRequired(true);
    	$property->setDescription('Wie is de tweede partner?');
    	$property->setRequestType($trouwenNL);
    	$manager->persist($property);    	
    	
    	$property= new Property();
    	//$property->setId('');
    	$property->setTitle('Getuigen van partner 1');
    	$property->setType('arrays');
    	$property->setFormat('bsn');
    	$property->setMaxLength('9');
    	$property->setMinLength('9');
    	$property->setRequired(true);
    	$property->setDescription('Wie gaan er verhuizen?');
    	$property->setRequestType($trouwenNL);
    	$manager->persist($property);
    	
    	$property= new Property();
    	//$property->setId('');
    	$property->setTitle('Getuigen2');
    	$property->setType('arrays');
    	$property->setFormat('bsn');
    	$property->setMinProperties(1);
    	$property->setMaxProperties(2);
    	$property->setRequired(true);
    	$property->setDescription('Wie gaan er verhuizen?');
    	$property->setRequestType($trouwenNL);
    	$manager->persist($property);
    	
    	$trouwenUtrecht = new RequestType();
    	$trouwenUtrecht->setId('eb9bdd00-40ce-4510-8555-cc74b2db61c4');
    	$trouwenUtrecht->setExtends($trouwenNL);    	
    	$trouwenUtrecht->setSourceOrganisation('002220647');
    	$trouwenUtrecht->setName('Trouwen of Partnerschap in Utrecht');
    	$trouwenUtrecht->setDescription('Samen gaan in de leukste stad van Nederland');
    	$manager->persist($trouwenUtrecht);
    	
    	$property= new Property();
    	//$property->setId('');
    	$property->setTitle('Order');
    	$property->setType('string');
    	$property->setFormat('uri');
    	$property->setMaxLength('255');
    	$property->setRequired(true);
    	$property->setDescription('We gebruiken de order om de bestelling (bestaande uit locatie, ambtenaar en eventueele extra\'s) op te slaan');
    	$property->setRequestType($trouwenNL);
    	$manager->persist($property);
    	
        $manager->flush();
    }
}
