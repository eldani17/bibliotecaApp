<?php

namespace BibliotecaBundle\Controller;

use BibliotecaBundle\Entity\Libro;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BibliotecaBundle\Form\LibroType;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Libro controller.
 *
 * @Route("admin/libro")
 */
class LibroController extends Controller
{
  private $session;

  public function __construct(){
    $this->session = new Session();
  }

  /**
   * @Route("/inicio", name="libro_inicio")
   * @Method("GET")
   */
  public function inicioAction()
  {
    $em = $this->getDoctrine()->getManager();

    $libros = $em->getRepository('BibliotecaBundle:Libro')->findAll();

    return $this->render('@Biblioteca/libro/inicio.html.twig', ['libros' => $libros]);
  }

  /**
   * @Route("/crear", name="libro_crear")
   * @Method({"GET", "POST"})
   */
  public function crearAction(Request $request)
  {
    $form = $this->createForm(LibroType::class);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $libro = new Libro();

        // con getData traigo todos los datos del request y se los paso
        // al objeto libro
        $libro = $form->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($libro);
        $entityManager->flush();

        $this->session->getFlashBag()->add("message", "El Libro se creo de manera correcta.");

        return $this->redirectToRoute('libro_inicio');
    }

    return $this->render('@Biblioteca/libro/crear.html.twig', ['form' => $form->createView()]);
  }

  /**
   * @Route("/{id}/mostrar", name="libro_mostrar")
   * @Method("GET")
   */
  public function mostrarAction($id)
  {
    //Digo que voy a usar el manejador de Doctrine
    $em = $this->getDoctrine()->getManager();
    //Aviso sobre que entidad voy a trabajar
    $repository = $em->getRepository('BibliotecaBundle:Libro');
    //armo mi query
    $libro = $repository->findOneById($id);

    $form = $this->createForm(LibroType::class, $libro);

    return $this->render('@Biblioteca/libro/mostrar.html.twig', [
      'libro'=>$libro,
      'tipo' =>'',
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/{id}/editar", name="libro_editar")
   * @Method({"GET", "POST"})
   */
  public function editarAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('BibliotecaBundle:Libro');
    $libro = $repository->findOneById($id);

    $editarForm = $this->createForm(LibroType::class, $libro);
    $editarForm->handleRequest($request);

    if ($editarForm->isSubmitted() && $editarForm->isValid()) {
        $this->getDoctrine()->getManager()->flush();

        $this->session->getFlashBag()->add("message", "El Libro se edito de manera correcta.");
        return $this->redirectToRoute('libro_inicio');
    }

    return $this->render('@Biblioteca/libro/editar.html.twig', [
      'libro'=>$libro,
      'form' => $editarForm->createView()
    ]);
  }

  /**
   * @Route("/{id}/borrar", name="libro_borrar")
   * @Method("GET")
   */
  public function borrarAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('BibliotecaBundle:Libro');
    $libro = $repository->findOneById($id);
    $em->remove($libro);
    $em->flush();

    $this->session->getFlashBag()->add("message", "El Libro se Elimino de manera correcta.");

    return $this->redirectToRoute('libro_inicio');
  }
}
