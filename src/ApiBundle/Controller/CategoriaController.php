<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

// para poder responder en JSON
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\HttpFoundation\Request;

// para usar la clase de Entidad
use ApiBundle\Entity\Categoria;

class CategoriaController extends Controller
{

  /**
  * @Route("/api/categoria/listar", name="categorialistar")
  * @Method({"GET"})
  */
  public function categoriaListarAction(){
    //Digo que voy a usar el manejador de Doctrine
    $em = $this->getDoctrine()->getManager();
    //Aviso sobre que entidad voy a trabajar
    $repository = $em->getRepository('ApiBundle:Categoria');
    //armo mi query
    $categorias = $repository->findAll();

    //dump($categorias);
    //esto es para mostrar datos, es como el dd() de laravel
    if (!isset($categorias)){
      return new JsonResponse($this->resultadoMalo('No se encontraron categorias','Inserte alguna categoria en la DB'), 200);
    }

    $data = array();

    foreach ($categorias as $categoria) {
      array_push($data, $this->serializarCategoria($categoria));
    }
    return new JsonResponse($data, 200);
  }

  /**
  * @Route("/api/categoria/listar/{id}", name="categorialistaporid")
  * @Method({"GET"})
  */
  public function categoriaListarPorIdAction($id){
    //Digo que voy a usar el manejador de Doctrine
    $em = $this->getDoctrine()->getManager();
    //Aviso sobre que entidad voy a trabajar
    $repository = $em->getRepository('ApiBundle:Categoria');
    //armo mi query
    $categorias = $repository->findById($id);

    //dump(isset($categorias) );
    //esto es para mostrar datos, es como el dd() de laravel
    if (!isset($categorias) || count($categorias) == 0){
      return new JsonResponse($this->resultadoMalo('No se encontraron categorias','Inserte alguna categoria en la DB'), 200);
    }

    $data = array();

    foreach ($categorias as $categoria) {
      array_push($data, $this->serializarCategoria($categoria));
    }
    return new JsonResponse($data, 200);
  }

  /**
  * @Route("/api/categoria/crear", name="categoriacrear")
  * @Method({"POST"})
  */
  public function categoriaCrearAction(Request $request){
    $categoria = new Categoria();
    //$categoria->setNombre('Biografías');
    //$categoria = $request->request->all();
    $categoria->setNombre($request->request->get('nombre'));
    //$categoria->setNombre("Preuba 1");

    //dump($categoria);
    if ($categoria->getNombre() == null)
    {
        return new JsonResponse($this->resultadoMalo('Faltan completar datos para poder crear una categoria',''), 200);
    }
    // defino mi manager de doctrine, la uso para hacer los CRUD de doctrine para hacer las cosas en la DB
    $em = $this->getDoctrine()->getManager();
    $em->persist($categoria);
    $em->flush();

    $data = array();

    array_push($data, $this->serializarCategoria($categoria));

    //return echo 'hola mundo';
    return new JsonResponse($data, 200);
  }

  /**
  * @Route("/api/categoria/{id}/editar", name="categoriaeditar")
  * @Method({"POST"})
  */
  public function categoriaEditarAction($id,Request $request){
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('ApiBundle:Categoria');
    $categoria = $repository->find($id);

    if (!isset($categoria))
    {
        return new JsonResponse($this->resultadoMalo('Datos no encontrados',''), 200);
    }

    //$categoria->setNombre("lalala2233");
    //dump($request);
    $categoria->setNombre($request->request->get('nombre'));
    $em->persist($categoria);
    $em->flush();

    $data = array();

    array_push($data, $this->serializarCategoria($categoria));

    return new JsonResponse($data, 200);
  }

  private function serializarCategoria(Categoria $c){
    return array(
      'id' => $c->getId(),
      'nombre' => $c->getNombre()
    );
  }

  private function resultadoMalo($msg, $help=null){
    return array(
      'message' => $msg,
      'help' => $help
    );
  }
}
