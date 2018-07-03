<?php
namespace BibliotecaBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BibliotecaBundle\Entity\Libro;
use BibliotecaBundle\Entity\Autor;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

//class CrearIdiomas implements ORMFixtureInterface
class CrearLibros extends Fixture implements OrderedFixtureInterface
{
    public function load (ObjectManager $manager)
    {
      $libro100 = new Libro();
      $libro100->setTitulo('Cien años de soledad');
      $libro100->setIsbn('9789871138142');
      $libro100->setEdicion('2012');
      $libro100->setDescripcion("'Muchos años después, frente al pelotón de fusilamiento, el coronel Aureliano Buendía había de recordar aquella tarde remota en que su padre lo llevó a conocer el hielo.' Con estas palabras empieza una novela legendaria, una de las aventuras literarias más fascinantes del siglo XX. La familia Buendía-Iguarán, con sus milagros, fantasías, obsesiones, tragedias, incestos, adulterios, rebeldías, descubrimientos y condenas, representa al mismo tiempo el mito y la historia, la tragedia y el amor del mundo entero.");
      $libro100->setEditorial('Debolsillo');
      $libro100->setFoto('http://content.cuspide.com/getcover.ashx?ISBN=9789871138142&size=3&coverNumber=1&id_com=1113');
      $libro100->setIdioma($this->getReference('idioma-espanol'));
      $libro100->addCategoria($this->getReference('categoria-1'));
      $libro100->addAutore($this->getReference('autor-garcia'));

      $manager->persist($libro100);
      
      $libro = new Libro();
      $libro->setTitulo('La Ciudad de los Libros Malditos');
      $libro->setIsbn('978-84-17229-05-4');
      $libro->setEdicion('2010');
      $libro->setDescripcion('Una sucesión de libros usados de contenido filosófico, inocentemente adquiridos por ciudadanos anónimos en diferentes mercadillos callejeros de Sevilla, desatará una trama macabra y brutal en la que estos se verán envueltos. Libros, firmados por pensadores de la talla de Descartes, Kant, Pascal...que ofrecen un común denominador: el haber formado parte alguna vez del Índice de libros prohibidos por la Inquisición, una relación de títulos que era necesario expurgar por ser considerados perniciosos para la Fe. Valiéndose de estos mimbres, el autor desarrolla un guion trepidante que no dejará indiferente a nadie y mantendrá en vilo al lector hasta los últimos compases de una novela que brinda, además, un sorprendente desenlace.');
      $libro->setEditorial('Almuzara');
      $libro->setFoto('http://grupoalmuzara.com/libro/9788417229054_portada.jpg');
      $libro->setIdioma($this->getReference('idioma-espanol'));
      $libro->addCategoria($this->getReference('categoria-1'));
      $libro->addAutore($this->getReference('autor-1'));
      $manager->persist($libro);

      $manager->flush();

      $this->addReference('libro-100',$libro100);
      $this->addReference('libro-1',$libro);
    }

    public function getOrder()
    {
        return 4;
    }
}
