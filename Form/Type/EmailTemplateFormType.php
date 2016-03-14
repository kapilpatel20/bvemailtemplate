<?php

namespace BviTemplateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmailTemplateFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

    	$builder->add('emailkey', 'text')
                ->add('subject', 'text')
                ->add('body', 'textarea')
        ;
    }

    public function getName() {
        return 'email_template';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BviTemplateBundle\Entity\Emailtemplate'
        ));
    }

}
