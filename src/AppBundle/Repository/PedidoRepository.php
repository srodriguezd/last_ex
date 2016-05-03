<?php

namespace AppBundle\Repository;

/**
 * PedidoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PedidoRepository extends \Doctrine\ORM\EntityRepository
{
    //a) Muestra todos los pedidos de un cliente según su id

    public function queryPedidoByCliente($id)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.pedido', 'pedido')
            ->andWhere('pedido.id = :id')
            ->setParameter('id', $id)
            ->addOrderBy('c.createdAt', 'DESC')
            ->getQuery();
    }

    public function PedidoByCliente($id)
    {
        return $this->queryPedidoByCliente($id)->execute();
    }







}














