<?php

namespace BibliotecaBundle\Controller;

use BibliotecaBundle\Entity\Autor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BibliotecaBundle\Form\AutorType;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Autor controller.
 *
 * @Route("admin/autor")
 */
class AutorController extends Controller
{
  private $session;

  public function __construct(){
    $this->session = new Session();
  }

  /**
   * Lists all autor entities.
   *
   * @Route("/inicio", name="autor_inicio")
   * @Method("GET")
   */
  public function inicioAction()
  {
    $em = $this->getDoctrine()->getManager();

    $autores = $em->getRepository('BibliotecaBundle:Autor')->findAll();

    return $this->render('@Biblioteca/autor/inicio.html.twig', [
      'autores' => $autores
    ]);
  }

  /**
   * @Route("/crear", name="autor_crear")
   * @Method({"GET", "POST"})
   */
  public function crearAction(Request $request)
  {
    $form = $this->createForm(AutorType::class);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $autor = new Autor();

        // con getData traigo todos los datos del request y se los paso
        // al objeto autor
        $autor = $form->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($autor);
        $entityManager->flush();

        $this->session->getFlashBag()->add("message", "El Autor se creo de manera correcta.");

        return $this->redirectToRoute('autor_inicio');
    }

    return $this->render('@Biblioteca/autor/crear.html.twig', ['form' => $form->createView()]);
  }

  /**
   * @Route("/{id}/mostrar", name="autor_mostrar")
   * @Method("GET")
   */
  public function mostrarAction($id)
  {
    //Digo que voy a usar el manejador de Doctrine
    $em = $this->getDoctrine()->getManager();
    //Aviso sobre que entidad voy a trabajar
    $repository = $em->getRepository('BibliotecaBundle:Autor');
    //armo mi query
    $autor = $repository->findOneById($id);

    $form = $this->createForm(AutorType::class, $autor);

    return $this->render('@Biblioteca/autor/mostrar.html.twig', [
      'autor'=>$autor,
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/{id}/editar", name="autor_editar")
   * @Method({"GET", "POST"})
   */
  public function editarAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('BibliotecaBundle:Autor');
    $autor = $repository->findOneById($id);

    $editarForm = $this->createForm(AutorType::class, $autor);
    $editarForm->handleRequest($request);

    if ($editarForm->isSubmitted() && $editarForm->isValid()) {
        $this->getDoctrine()->getManager()->flush();

        $this->session->getFlashBag()->add("message", "El Autor se edito de manera correcta.");
        return $this->redirectToRoute('autor_inicio');
    }

    return $this->render('@Biblioteca/autor/editar.html.twig', [
      'autor'=>$autor,
      'form' => $editarForm->createView()
    ]);
  }

  /**
   * @Route("/{id}/borrar", name="autor_borrar")
   * @Method("GET")
   */
  public function borrarAction($id)
  {
    try{
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('BibliotecaBundle:Autor');
    $autor = $repository->findOneById($id);
    $em->remove($autor);
    $em->flush();
    }
    catch(\Doctrine\DBAL\DBALException $e) {
      $this->session->getFlashBag()->add("error", "Error al tratar de borrar el Autor.");
      return $this->redirect($this->generateUrl('autor_inicio'));
    }

    $this->session->getFlashBag()->add("message", "El Autor se elimino de manera correcta.");

    return $this->redirectToRoute('autor_inicio');
  }
}
