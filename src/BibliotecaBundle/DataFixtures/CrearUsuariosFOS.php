<?php
namespace BibliotecaBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use BibliotecaBundle\Entity\User;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CrearUsuariosFOS extends Fixture implements OrderedFixtureInterface
{
    public function load (ObjectManager $manager)
    {
      // Creo un usuario y cargo los datos
      $user = new User();
      $user->setUsername('admin');
      $user->setEmail('admin@untdf.com.ar');
      $user->setPlainPassword('admin');
      //$user->setPassword('3NCRYPT3D-V3R51ON');
      $user->setEnabled(true);
      $user->setRoles(array('ROLE_ADMIN'));

      $manager->persist($user);

      $manager->flush();
    }

    public function getOrder()
    {
      return 6;
    }
}
