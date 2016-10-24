<?php

namespace MiniCMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


/**
 * This class provides form scheme to add page entity in database
 *
 * @author Tanguy Reviller
 */
class PageType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('title', TextType::class)
		->add('category', EntityType::class, array('class' => 'MiniCMSBundle:Category', 'choice_label' => 'name'))
		->add('content', TextareaType::class)
		->add('save', SubmitType::class);
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
				'data_class' => 'MiniCMSBundle\Entity\Page'
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'minicmsbundle_page';
	}


}
