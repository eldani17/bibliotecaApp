<?php

namespace BibliotecaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use BibliotecaBundle\Entity\Libro;
use BibliotecaBundle\Form\LibroType;
use BibliotecaBundle\Form\AutorType;

class FrontendController extends Controller
{
    /**
     * @Route("/", name="inicio")
     */
    public function inicioAction(Request $request)
    {
      $opcion = $request->request->get('optradio');
      $texto = $request->request->get('texto');

      $em = $this->getDoctrine()->getManager();

      $libros = $em->getRepository('BibliotecaBundle:Libro')->findAll();

      switch ($opcion) {
        case "titulo":
        $libros = $em->getRepository('BibliotecaBundle:Libro')->createQueryBuilder('l')
           ->where('l.titulo LIKE :titulo')
           ->setParameter('titulo', '%'.$texto.'%')
           ->getQuery()
           ->getResult();
          break;
        case "autor":
          $query = $em->createQuery("SELECT l FROM BibliotecaBundle\Entity\Libro l JOIN l.autores a WHERE a.nombre LIKE :texto");
          $query->setParameter('texto', '%'.$texto.'%');
          $libros = $query->getResult();
          break;
        case "categoria":
          $query = $em->createQuery("SELECT l FROM BibliotecaBundle\Entity\Libro l JOIN l.categorias c WHERE c.nombre LIKE :texto");
          $query->setParameter('texto', '%'.$texto.'%');
          $libros = $query->getResult();
          break;
      }
      return $this->render('@Biblioteca/frontend/inicio.html.twig', ['libros' => $libros]);
    }

    /**
     * @Route("/{id}/detalle", name="libro_detalle_frontend")
     * @Method("GET")
     */
    public function detallelibroAction($id)
    {
      //Digo que voy a usar el manejador de Doctrine
      $em = $this->getDoctrine()->getManager();
      //Aviso sobre que entidad voy a trabajar
      $repository = $em->getRepository('BibliotecaBundle:Libro');
      //armo mi query
      $libro = $repository->findOneById($id);

      $form = $this->createForm(LibroType::class, $libro);

      return $this->render('@Biblioteca/frontend/detalle-libro.html.twig', [
        'libro'=>$libro,
        'form' => $form->createView()
      ]);
    }

    /**
     * @Route("/{id}/detalleautor", name="autor_detalle_frontend")
     * @Method("GET")
     */
    public function detalleautorAction($id)
    {
      //Digo que voy a usar el manejador de Doctrine
      $em = $this->getDoctrine()->getManager();
      //Aviso sobre que entidad voy a trabajar
      $repository = $em->getRepository('BibliotecaBundle:Autor');
      //armo mi query
      $autor = $repository->findOneById($id);

      $form = $this->createForm(AutorType::class, $autor);

      return $this->render('@Biblioteca/frontend/detalle-autor.html.twig', [
        'autor'=>$autor,
        'form' => $form->createView()
      ]);
    }
}
