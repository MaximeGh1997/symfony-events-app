<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Event;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // fixtures ajout de l'admin
        $adminUser = new User();

        $adminUser->setUsername('admin')
                ->setPassword($this->passwordEncoder->encodePassword($adminUser,'epse'))
                ->setRoles(['ROLE_ADMIN']);

        $manager->persist($adminUser);



        // fixtures ajout d'évents
        $faker = Factory::create('FR-fr');
        $slugify = new Slugify();
        
        for($i = 1; $i<=10; $i++){
            $event = new Event();
            $slug = $slugify->slugify($faker->md5());
            $names = [
                'DRAKE EUROPEAN TOUR 2020',
                'LES ARDENTES 2020',
                'AVANT PREMIERE BAD BOYS FOR LIFE',
                'UEFA EURO 2020: BELGIQUE-RUSSIE',
                'PABLO ANDRES: THE WORLD OF PABLO '
            ];
            $types = [
                'Concert',
                'Festival',
                'Cinéma',
                'Sport',
                'Spectacle'
            ];
            $places = [
                'ANTWERP SPORTPALEIS',
                'ESPLANADE LIEGE',
                'KINEPOLIS IMAGIBRAINE',
                'STADE ROI BAUDOUIN',
                'FOREST NATIONAL'
            ];
            $createdAt = new \DateTime();

            $event->setName($names[mt_rand(0,4)])
                ->setType($types[mt_rand(0,4)])
                ->setPlace($places[mt_rand(0,4)])
                ->setDate($faker->dateTimeBetween('+2 months', '+6 months'))
                ->setDescription($faker->paragraph())
                ->setPrice($faker->numberBetween($min=25, $max=79))
                ->setCover('http://www.placehold.it/1000x350')
                ->setSlug($slug)
                ->setCreatedAt($createdAt);
            
            $manager->persist($event);    
        }
        

        $manager->flush();


    }
}
