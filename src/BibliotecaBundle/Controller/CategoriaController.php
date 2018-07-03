<?php

namespace BibliotecaBundle\Controller;

use BibliotecaBundle\Entity\Categoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BibliotecaBundle\Form\CategoriaType;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Categorium controller.
 *
 * @Route("admin/categoria")
 */
class CategoriaController extends Controller
{
  private $session;

  public function __construct(){
    $this->session = new Session();
  }

  /**
   * @Route("/inicio", name="categoria_inicio")
   * @Method("GET")
   */
  public function inicioAction()
  {
    $em = $this->getDoctrine()->getManager();

    $categorias = $em->getRepository('BibliotecaBundle:Categoria')->findAll();

    return $this->render('@Biblioteca/categoria/inicio.html.twig', [
      'categorias' => $categorias,
    ]);
  }

  /**
   * @Route("/crear", name="categoria_crear")
   * @Method({"GET", "POST"})
   */
  public function crearAction(Request $request)
  {
    $form = $this->createForm(CategoriaType::class);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $categoria = new Categoria();

        // con getData traigo todos los datos del request y se los paso
        // al objeto categoria
        $categoria = $form->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($categoria);
        $entityManager->flush();

        $this->session->getFlashBag()->add("message", "La Categoria se creo de manera correcta.");

        return $this->redirectToRoute('categoria_inicio');
    }

    return $this->render('@Biblioteca/categoria/crear.html.twig', ['form' => $form->createView()]);
  }

  /**
   * @Route("/{id}/mostrar", name="categoria_mostrar")
   * @Method("GET")
   */
  public function mostrarAction($id)
  {
    //Digo que voy a usar el manejador de Doctrine
    $em = $this->getDoctrine()->getManager();
    //Aviso sobre que entidad voy a trabajar
    $repository = $em->getRepository('BibliotecaBundle:Categoria');
    //armo mi query
    $categoria = $repository->findOneById($id);

    $form = $this->createForm(CategoriaType::class, $categoria);

    return $this->render('@Biblioteca/categoria/mostrar.html.twig', [
      'categoria'=>$categoria,
      'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/{id}/editar", name="categoria_editar")
   * @Method({"GET", "POST"})
   */
  public function editarAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('BibliotecaBundle:Categoria');
    $categoria = $repository->findOneById($id);

    $editarForm = $this->createForm(CategoriaType::class, $categoria);
    $editarForm->handleRequest($request);

    if ($editarForm->isSubmitted() && $editarForm->isValid()) {
        $this->getDoctrine()->getManager()->flush();

        $this->session->getFlashBag()->add("message", "La Categoria se edito de manera correcta.");
        return $this->redirectToRoute('categoria_inicio');
    }

    return $this->render('@Biblioteca/categoria/editar.html.twig', [
      'categoria'=>$categoria,
      'form' => $editarForm->createView()
    ]);
  }

  /**
   * @Route("/{id}/borrar", name="categoria_borrar")
   * @Method("GET")
   */
  public function borrarAction($id)
  {
    try{
      $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('BibliotecaBundle:Categoria');
      $categoria = $repository->findOneById($id);
      $em->remove($categoria);
      $em->flush();
    }
    catch(\Doctrine\DBAL\DBALException $e) {
      $this->session->getFlashBag()->add("error", "Error al tratar de borrar la Categoria.");
      return $this->redirect($this->generateUrl('categoria_inicio'));
    }

    $this->session->getFlashBag()->add("message", "La categoria se elimino de manera correcta.");

    return $this->redirectToRoute('categoria_inicio');
  }
}
