<?php
namespace Megogo\Bundle\SurveyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('email', 'email', ['error_bubbling' => true, 'required' => false])
            ->add('firstName', 'text',['error_bubbling' => true, 'required' => false])
            ->add('lastName', 'text',['error_bubbling' => true])
            ->add('birthdayDate', 'date',[
                'error_bubbling' => true ,
                'years' => self::getYearsArray((new \DateTime('now'))->format('Y')-100,
                    (new \DateTime('now'))->format('Y'))
            ])
            ->add('shoeSize', 'text',['error_bubbling' => true])
            ->add('save', 'submit');
    }
    public static function getYearsArray($min, $max){
        $result = [];
        for($i = $min; $i <= $max; $i++){
            $result[] = $i;
        }
        return $result;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
                'data_class' => 'Megogo\Bundle\PersistenceBundle\Entity\User',
                'validation_groups' => [ 'registration'],
            ]
        );
    }

    public function getName()
    {
        return 'user';
    }

}