<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Cliente;
use AppBundle\Form\pedidoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
class PedidoController extends Controller{
    /**
     * indexAction
     *
     * @Route(
     *     path="/pedido_index",
     *     name="app_pedido_index"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Pedido');
        /**
         * @var Pedido $pedido
         */
        $pedido = $repository->findAll();
        return $this->render(':pedido:index.html.twig',
            [
                'pedido' => $pedido,
            ]
        );
    }
    /**
     * @Route("/pedido_insert", name="app_pedido_insert")
     */
    public function insertAction()
    {
        $pedido = new Cliente();
        $form = $this->createForm(cpedidoType::class, $pedido);
        return $this->render(':pedido:insert.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_pedido_do-insert')
            ]
        );
    }
    /**
     * @Route("/pedido_do-insert", name="app_pedido_do-insert")
     */
    public function doInsert(Request $request)
    {
        $pedido = new Pedido();
        $form = $this->createForm(pedidoType::class, $pedido);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $m = $this->getDoctrine()->getManager();
            $m->persist($pedido);
            $m->flush();
            $this->addFlash('messages', 'añadido');
            return $this->redirectToRoute('app_pedido_index');
        }
        $this->addFlash('messages', 'Review your form data');
        return $this->render(':pedido:insert.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_pedido_do-insert')
            ]
        );
    }

    /**
     *
     * @Route("/pedido_remove/{id}", name="app_pedido_remove")
     * @ParamConverter(name="pedido", class="AppBundle:Pedido")
     */
    public function removeAction(cliente $pedido)
    {
        $m = $this->getDoctrine()->getManager();
        $m->remove($pedido);
        $m->flush();
        $this->addFlash('messages', 'Eliminado');
        return $this->redirectToRoute('app_pedido_index');
    }
}