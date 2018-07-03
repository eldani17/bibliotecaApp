<?php

namespace BibliotecaBundle\Controller;

use BibliotecaBundle\Entity\Idioma;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BibliotecaBundle\Form\IdiomaType;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Idioma controller.
 *
 * @Route("admin/idioma")
 */
class IdiomaController extends Controller
{
    private $session;

    public function __construct(){
      $this->session = new Session();
    }

    /**
     * @Route("/inicio", name="idioma_inicio")
     * @Method("GET")
     */
    public function inicioAction()
    {
        $em = $this->getDoctrine()->getManager();

        $idiomas = $em->getRepository('BibliotecaBundle:Idioma')->findAll();

        return $this->render('@Biblioteca/idioma/inicio.html.twig', ['idiomas' => $idiomas]);
    }

    /**
     * @Route("/crear", name="idioma_crear")
     * @Method({"GET", "POST"})
     */
    public function crearAction(Request $request)
    {
      $form = $this->createForm(IdiomaType::class);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

          $idioma = new Idioma();

          // con getData traigo todos los datos del request y se los paso
          // al objeto idioma
          $idioma = $form->getData();

          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($idioma);
          $entityManager->flush();

          $this->session->getFlashBag()->add("message", "El Idioma se Creo de manera correcta.");

          return $this->redirectToRoute('idioma_inicio');
      }

      return $this->render('@Biblioteca/idioma/crear.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Finds and displays a idioma entity.
     *
     * @Route("/{id}/mostrar", name="idioma_mostrar")
     * @Method("GET")
     */
    public function mostrarAction($id)
    {
        //Digo que voy a usar el manejador de Doctrine
        $em = $this->getDoctrine()->getManager();
        //Aviso sobre que entidad voy a trabajar
        $repository = $em->getRepository('BibliotecaBundle:Idioma');
        //armo mi query
        $idioma = $repository->findOneById($id);

        $form = $this->createForm(IdiomaType::class, $idioma);

        return $this->render('@Biblioteca/idioma/mostrar.html.twig', [
          'idioma'=>$idioma,
          'form' => $form->createView()
        ]);
    }

    /**
     * Displays a form to edit an existing idioma entity.
     *
     * @Route("/{id}/editar", name="idioma_editar")
     * @Method({"GET", "POST"})
     */
    public function editarAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('BibliotecaBundle:Idioma');
      $idioma = $repository->findOneById($id);

      $editarForm = $this->createForm(IdiomaType::class, $idioma);
      $editarForm->handleRequest($request);

      if ($editarForm->isSubmitted() && $editarForm->isValid()) {
          $this->getDoctrine()->getManager()->flush();

          $this->session->getFlashBag()->add("message", "El Idioma se Edito de manera correcta.");
          return $this->redirectToRoute('idioma_inicio');
      }

      return $this->render('@Biblioteca/idioma/editar.html.twig', [
        'idioma'=>$idioma,
        'form' => $editarForm->createView()
      ]);
    }

    /**
     * @Route("/{id}/borrar", name="idioma_borrar")
     * @Method("GET")
     */
    public function borrarAction($id)
    {
      try{
      $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('BibliotecaBundle:Idioma');
      $idioma = $repository->findOneById($id);
      $em->remove($idioma);
      $em->flush();
      }
      catch(\Doctrine\DBAL\DBALException $e) {
        $this->session->getFlashBag()->add("error", "Error al tratar de borrar el Idioma.");
        return $this->redirect($this->generateUrl('idioma_inicio'));
      }

      $this->session->getFlashBag()->add("message", "El Idioma se Elimino de manera correcta.");

      return $this->redirectToRoute('idioma_inicio');
    }
}
