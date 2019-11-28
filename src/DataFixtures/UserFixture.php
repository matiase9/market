<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        /* Admin */
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword(
            $this->encoder->encodePassword($user,'admin123')
        );
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        /* Customer */
        $user = new User();
        $user->setUsername('customer');
        $user->setPassword(
            $this->encoder->encodePassword($user,'customer123')
        );
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $manager->flush();
    }
}
