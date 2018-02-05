<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture {
    
    public function load(ObjectManager $manager) {
        // On crée une liste factice de 20 utilisateurs
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setUsername('user'.$i);
            $user->setEmail('user'.$i.'@mail.com');
            $user->setFirstname('User'.$i);
            $user->setLastname('Fake');
            $user->setPassword(password_hash('user'.$i, PASSWORD_BCRYPT));
            $user->setBirthdate(
                    \Datetime::createFromFormat('Y/m/d h:i:g', (2000 - $i).'/01/01 00:00:00')
                    );
            // on demande au manager d'enregistrer l'utilisateur en base de données
            $manager->persist($user);
        }
        $manager->flush(); // les INSERT INTO ne sont effectués qu'à ce moment là
    }
}
