<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Event;
use App\Entity\Types;
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

        // fixtures ajout des types

        $type1 = new Types();
        $type1->setTitle('Concert');
        
        $manager->persist($type1);

        $type2 = new Types();
        $type2->setTitle('Festival');

        $manager->persist($type2);

        $type3 = new Types();
        $type3->setTitle('Cinéma');

        $manager->persist($type3);

        $type4 = new Types();
        $type4->setTitle('Sport');

        $manager->persist($type4);

        $type5 = new Types();
        $type5->setTitle('Spectacle');

        $manager->persist($type5);

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
                'PABLO ANDRES: THE WORLD OF PABLO'
            ];
            $places = [
                'ANTWERP SPORTPALEIS',
                'ESPLANADE LIEGE',
                'KINEPOLIS IMAGIBRAINE',
                'STADE ROI BAUDOUIN',
                'FOREST NATIONAL'
            ];
            $createdAt = new \DateTime();
            $types = [
                $type1,
                $type2,
                $type3,
                $type4,
                $type5
            ];

            $event->setName($names[mt_rand(0,4)])
                ->setPlace($places[mt_rand(0,4)])
                ->setDate($faker->dateTimeBetween('-2 months', '+4 months'))
                ->setDescription($faker->paragraph())
                ->setPrice($faker->numberBetween($min=25, $max=79))
                ->setCover('http://www.placehold.it/1000x350')
                ->setSlug($slug)
                ->setCreatedAt($createdAt)
                ->setType($types[mt_rand(0,4)]);
            
            $manager->persist($event);    
        }

        $ultrabeach = new Event();

        $ultrabeach->setName('ULTRA BEACH 2020')
                   ->setPlace('Costa del sol, Espagne')
                   ->setDate($faker->dateTimeBetween('+49 days', '+51 days'))
                   ->setDescription($faker->paragraph())
                   ->setPrice(45)
                   ->setCover('https://media.resources.festicket.com/www/photos/2020_Costa_del_Sol_Banner_Dates_1400x800.jpg')
                   ->setSlug($slug)
                   ->setCreatedAt($faker->dateTimeBetween('+5 days', '+10 days'))
                   ->setType($type2);
        
        $manager->persist($ultrabeach);

        

        $manager->flush();


    }
}
