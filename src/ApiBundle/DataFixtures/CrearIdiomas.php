<?php
namespace BibliotecaBundle\DataFixtures;

//use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BibliotecaBundle\Entity\Idioma;

class CrearIdiomas implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $idioma = new Idioma();

        //$manager = $this->getDoctrine()->getManager();

        $idioma->setNombre('Español');
        $manager->persist($idioma);
        $idioma->setNombre('Ingles');
        $manager->persist($idioma);
        $idioma->setNombre('Portugues');
        $manager->persist($idioma);
        $idioma->setNombre('Frances');
        $manager->persist($idioma);
        $manager->flush();
    }
}
