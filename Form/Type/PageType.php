<?php

namespace MiniCMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use MiniCMSBundle\Entity\Page;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\Required;


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
		->add('access', ChoiceType::class, array('choices' => array('Public' => Page::ACCESS_USER, 'Members only' => Page::ACCESS_MEMBER, 'Administrators only' => Page::ACCESS_ADMIN)))
		->add('content', TextareaType::class)
		->add('homepage', CheckboxType::class, array('required' => false))
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
