<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Cliente;
use AppBundle\Form\articuloType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
class ArticuloController extends Controller{
    /**
     * indexAction
     *
     * @Route(
     *     path="/articulo_index",
     *     name="app_articulo_index"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Articulo');
        /**
         * @var Articulo $articulo
         */
        $articulo = $repository->findAll();
        return $this->render(':articulo:index.html.twig',
            [
                'articulo' => $articulo,
            ]
        );
    }
    /**
     * @Route("/articulo_insert", name="app_articulo_insert")
     */
    public function insertAction()
    {
        $articulo = new Articulo();
        $form = $this->createForm(articuloType::class, $articulo);
        return $this->render(':articulo:insert.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_articulo_do-insert')
            ]
        );
    }
    /**
     * @Route("/articulo_do-insert", name="app_articulo_do-insert")
     */
    public function doInsert(Request $request)
    {
        $articulo = new Articulo();
        $form = $this->createForm(articuloType::class, $articulo);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $m = $this->getDoctrine()->getManager();
            $m->persist($articulo);
            $m->flush();
            $this->addFlash('messages', 'añadido');
            return $this->redirectToRoute('app_articulo_index');
        }
        $this->addFlash('messages', 'Review your form data');
        return $this->render(':articulo:insert.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_articulo_do-insert')
            ]
        );
    }

    /**
     *
     * @Route("/articulo_remove/{id}", name="app_articulo_remove")
     * @ParamConverter(name="articulo", class="AppBundle:Articulo")
     */
    public function removeAction(articulo $articulo)
    {
        $m = $this->getDoctrine()->getManager();
        $m->remove($articulo);
        $m->flush();
        $this->addFlash('messages', 'Eliminado');
        return $this->redirectToRoute('app_articulo_index');
    }
}