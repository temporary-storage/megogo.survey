<?php
namespace Megogo\Bundle\SurveyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Megogo\Bundle\SurveyBundle\Form\Type\RegistrationType;

class AdditionalDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            ->add('iceCream', 'text',['error_bubbling' => true, 'required' => false])
            ->add('superHero', 'text',['error_bubbling' => true])
            ->add('movieStar', 'text',['error_bubbling' => true])
            ->add('worldEnd', 'date',[
                'error_bubbling' => true ,
                'years' => RegistrationType::getYearsArray((new \DateTime('now'))->format('Y'),
                    (new \DateTime('now'))->format('Y')+100)
            ])
            ->add('superBowl', 'text',['error_bubbling' => true])

            ->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Megogo\Bundle\PersistenceBundle\Entity\User',
            'validation_groups' => [ 'additional_data'],

        ));
    }

    public function getName()
    {
        return 'additional_data';
    }
}