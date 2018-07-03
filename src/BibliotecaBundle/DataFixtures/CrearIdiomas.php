<?php
namespace BibliotecaBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BibliotecaBundle\Entity\Idioma;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

//class CrearIdiomas implements ORMFixtureInterface
class CrearIdiomas extends Fixture implements OrderedFixtureInterface
{
    public function load (ObjectManager $manager)
    {
        $idioma = new Idioma();
        $idioma->setNombre('Ingles');
        $manager->persist($idioma);

        $idioma = new Idioma();
        $idioma->setNombre('Portugues');
        $manager->persist($idioma);

        $idioma = new Idioma();
        $idioma->setNombre('Frances');
        $manager->persist($idioma);

        $idioma = new Idioma();
        $idioma->setNombre('Español');
        $manager->persist($idioma);

        $manager->flush();

        $this->addReference('idioma-espanol',$idioma);
    }

    public function getOrder()
    {
        return 1;
    }
}
