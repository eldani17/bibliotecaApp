<?php
namespace BibliotecaBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BibliotecaBundle\Entity\Categoria;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

//class CrearIdiomas implements ORMFixtureInterface
class CrearCategorias extends Fixture implements OrderedFixtureInterface
{
    public function load (ObjectManager $manager)
    {
        $categoria = new Categoria();
        $categoria->setNombre('Bibliografia');
        $manager->persist($categoria);

        $categoria = new Categoria();
        $categoria->setNombre('Terror');
        $manager->persist($categoria);

        $categoria = new Categoria();
        $categoria->setNombre('Ficción');
        $manager->persist($categoria);

        $categoria = new Categoria();
        $categoria->setNombre('Novela');
        $manager->persist($categoria);

        $manager->flush();

        $this->addReference('categoria-1',$categoria);
    }

    public function getOrder()
    {
        return 2;
    }
}
