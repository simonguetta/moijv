<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture {

    public function load(ObjectManager $manager) {
        // On crée un admin pour accéder à notre backoffice
        $admin = new User();
        $admin->setRoles('ROLE_USER|ROLE_ADMIN');
        $admin->setUsername('root');
        $admin->setPassword(password_hash('root', PASSWORD_BCRYPT));
        $admin->setEmail('admin@noreply.com');
        $admin->setBirthdate(
                \DateTime::createFromFormat('Y/m/d h:i:s', '1996/04/12 00:00:00')
        );
        $manager->persist($admin);

        // On crée une liste factice de 20 utilisateurs
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setUsername('user' . $i);
            $user->setEmail('user' . $i . '@mail.com');
            $user->setFirstname('User' . $i);
            $user->setLastname('Fake');
            $user->setRoles('ROLE_USER');
            $user->setPassword(password_hash('user' . $i, PASSWORD_BCRYPT));
            $user->setBirthdate(
                    \Datetime::createFromFormat('Y/m/d h:i:g', (2000 - $i) . '/01/01 00:00:00')
            );
            // notre user sera référencé dans les autres fixture sous la clé
            // user0 puis user1 puis user2 etc...
            $this->addReference('user' . $i, $user);
            // on demande au manager d'enregistrer l'utilisateur en base de données
            $manager->persist($user);
        }
        $manager->flush(); // les INSERT INTO ne sont effectués qu'à ce moment là
    }

}
