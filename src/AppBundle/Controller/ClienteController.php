<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Cliente;
use AppBundle\Form\clienteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
class ClienteController extends Controller{
    /**
     * indexAction
     *
     * @Route(
     *     path="/cliente_index",
     *     name="app_cliente_index"
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Cliente');
        /**
         * @var Cliente $cliente
         */
        $cliente = $repository->findAll();
        return $this->render(':cliente:index.html.twig',
            [
                'cliente' => $cliente,
            ]
        );
    }
    /**
     * @Route("/cliente_insert", name="app_cliente_insert")
     */
    public function insertAction()
    {
        $cliente = new Cliente();
        $form = $this->createForm(clienteType::class, $cliente);
        return $this->render(':cliente:insert.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_cliente_do-insert')
            ]
        );
    }
    /**
     * @Route("/cliente_do-insert", name="app_cliente_do-insert")
     */
    public function doInsert(Request $request)
    {
        $cliente = new Cliente();
        $form = $this->createForm(clienteType::class, $cliente);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $m = $this->getDoctrine()->getManager();
            $m->persist($cliente);
            $m->flush();
            $this->addFlash('messages', 'añadido');
            return $this->redirectToRoute('app_cliente_index');
        }
        $this->addFlash('messages', 'Review your form data');
        return $this->render(':cliente:insert.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_cliente_do-insert')
            ]
        );
    }

    /**
     *
     * @Route("/cliente_remove/{id}", name="app_cliente_remove")
     * @ParamConverter(name="cliente", class="AppBundle:Cliente")
     */
    public function removeAction(cliente $cliente)
    {
        $m = $this->getDoctrine()->getManager();
        $m->remove($cliente);
        $m->flush();
        $this->addFlash('messages', 'Eliminado');
        return $this->redirectToRoute('app_cliente_index');
    }
}