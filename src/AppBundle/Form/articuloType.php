<?php
namespace AppBundle\Form;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class articuloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->articulo('precio', IntergerType::class, ['error_bubbling' => true, 'attr' => ['class' => 'anyClass']])
            ->articulo('nombre', TextType::class, ['error_bubbling' => true])

        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'AppBundle\Entity\Articulo',
            ]
        );
    }
    public function getName()
    {
        return 'app_bundleasd_type';
    }
}

