<?php

namespace BibliotecaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ApiController extends Controller
{
  /**
   * @Route("biblioteca/api/libros", name="api_libros")
   * @Method("GET")
   */
  public function librosAction()
  {
    $em = $this->getDoctrine()->getManager();

    $libros = $em->getRepository('BibliotecaBundle:Libro')->findAll();

    $encoder = new JsonEncoder();
    $normalizer = new ObjectNormalizer();

    $normalizer->setCircularReferenceHandler(function ($object) {
        return $object->__toString();
    });

    $serializer = new Serializer(array($normalizer), array($encoder));
    $data = $serializer->serialize($libros, 'json');

    $response = new Response();
    $response->setContent($data);
    $response->setStatusCode(Response::HTTP_OK);
    $response->headers->set('Content-Type', 'application/json');
    $response->headers->set('Access-Control-Allow-Origin', '*');

    return $response;
  }

  /**
   * @Route("biblioteca/api/busqueda/libro/{buscar}", name="api_busqueda")
   * @Method("GET")
   */
  public function busquedaAction($buscar)
  {
    $em = $this->getDoctrine()->getManager();

    $libros = $em->getRepository('BibliotecaBundle:Libro')->createQueryBuilder('l')
       ->where('l.titulo LIKE :titulo')
       ->setParameter('titulo', '%'.$buscar.'%')
       ->getQuery()
       ->getResult();

    // busco por nombre o apellido de autor
    $query = $em->createQuery("SELECT l FROM BibliotecaBundle\Entity\Libro l JOIN l.autores a WHERE a.nombre LIKE :buscar or a.apellido LIKE :buscar");
    $query->setParameter('buscar', '%'.$buscar.'%');
    $resultado = $query->getResult();

    if (count($resultado)>0){
      foreach ($resultado as $r) {
        array_push($libros,$r);
      }
    }

    // busco por nombre de categoria
    $query = $em->createQuery("SELECT l FROM BibliotecaBundle\Entity\Libro l JOIN l.categorias c WHERE c.nombre LIKE :buscar");
    $query->setParameter('buscar', '%'.$buscar.'%');
    $resultado = $query->getResult();

    if (count($resultado)>0){
      foreach ($resultado as $r) {
        array_push($libros,$r);
      }
    }

    $encoder = new JsonEncoder();
    $normalizer = new ObjectNormalizer();

    $normalizer->setCircularReferenceHandler(function ($object) {
        return $object->__toString();
    });

    $serializer = new Serializer(array($normalizer), array($encoder));
    $data = $serializer->serialize($libros, 'json');

    $response = new Response();
    $response->setContent($data);
    $response->setStatusCode(Response::HTTP_OK);
    $response->headers->set('Content-Type', 'application/json');
    $response->headers->set('Access-Control-Allow-Origin', '*');

    return $response;
  }
}
