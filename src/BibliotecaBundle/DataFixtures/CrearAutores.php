<?php
namespace BibliotecaBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BibliotecaBundle\Entity\Autor;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

//class CrearIdiomas implements ORMFixtureInterface
class CrearAutores extends Fixture implements OrderedFixtureInterface
{
    public function load (ObjectManager $manager)
    {
      $autores = new Autor();
      $autores->setNombre('Gabriel José de la Concordia');
      $autores->setApellido('García Márquez');
      $autores->setDescripcion("La notoriedad mundial de García Márquez comenzó cuando Cien años de soledad se publicó en junio de 1967 y en una semana vendió 8000 ejemplares. De allí en adelante, el éxito fue asegurado y la novela vendió una nueva edición cada semana, pasando a vender medio millón de copias en tres años. Fue traducido a más de veinticinco idiomas y ganó seis premios internacionales. El éxito había llegado por fin y el escritor tenía 40 años cuando el mundo aprendió su nombre. Por la correspondencia de admiradores, los premios, entrevistas y las comparecencias era obvio que su vida había cambiado. En 1969, la novela ganó el Chianciano Aprecian en Italia y fue denominado el «Mejor Libro Extranjero» en Francia. En 1970, fue publicado en inglés y fue escogido como uno de los mejores 12 libros del año en Estados Unidos. Dos años después le fue concedido el Premio Rómulo Gallegos y el Premio Neustadt y en 1971, Mario Vargas Llosa publicó un libro acerca de su vida y obra. Para contradecir toda esta exhibición, García Márquez regresó simplemente a la escritura. Decidido a escribir acerca de un dictador, se trasladó con su familia a Barcelona (España) que pasaba sus últimos años bajo el régimen de Francisco Franco.11​");
      $autores->setWeb('https://es.wikipedia.org/wiki/Gabriel_Garc%C3%ADa_M%C3%A1rquez');
      $autores->setFoto('https://gcdn.emol.cl/literatura-contemporanea/files/2012/07/garcia-marquez-.jpg');
      $manager->persist($autores);
      $manager->flush();

      $this->addReference('autor-garcia',$autores);

      $autores = new Autor();
      $autores->setNombre('Luis Felipe');
      $autores->setApellido('Campuzano');
      $autores->setDescripcion("Luis Felipe Campuzano (Sevilla 1963). Tras licenciarse en derecho por la Universidad Hispalense,
      marcha a Barcelona donde cursa un postgrado en alta dirección de empresas en ESADE. Su vida profesional se desarrolla en
      el mundo empresarial, habiendo ocupado puestos de alta dirección en diversas compañías multinacionales europeas. En otoño
      de 2005 publica su primera novela, Réquiem por un marrano (Editorial Almuzara), ambientada en la Sevilla del siglo XV. El
      músico de Stalin (Almuzara) es su segunda novela y supone una nueva incursión en el terreno de la narrativa histórica de
      intriga. Completa su obra la orden de las 12 Cruces (Jirones de azul). En el mundo del cómic ha sido guionista de Big in
      Japan, un éxito de ventas que recoge la participación de la selección española de baloncesto en el Mundial de Japón,
      ¡Ole mi Sevilla! sobre la historia centenaria del Sevilla F.C., Mucho Betis sobre la historia centenaria del Real Betis
       Balompié y Sueños de vida sobre el mundo de la inmigración.");
      $autores->setWeb('https://www.todostuslibros.com/autor/luis-felipe-campuzano');
      $autores->setFoto('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRd8mvSdcPNB6NGyAhXJ-3FIAQzNJR3UQJCDQPYIR4qrIwNIDhQxQ');
      $manager->persist($autores);

      $manager->flush();

      $this->addReference('autor-1',$autores);
    }

    public function getOrder()
    {
        return 3;
    }
}
