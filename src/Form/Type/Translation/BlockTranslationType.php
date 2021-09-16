<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type\Translation;

use BitBag\SyliusCmsPlugin\Entity\BlockTranslation;
use BitBag\SyliusCmsPlugin\Form\Type\WysiwygType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\OptionsResolver\OptionsResolver;


final class BlockTranslationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.name',
                'required' => false,
            ])
            ->add('link', TextType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.link',
                'required' => false,
            ])
            ->add('content', WysiwygType::class, [
                'required' => false,
            ])
            ->add('json_content', TextareaType::class, [
                'required' => false,
            ]);
            $builder->get('json_content')
            ->addModelTransformer(new CallbackTransformer(
                function ($contentAsArray) {
                    // transform the array to a string
                    
                    if($contentAsArray) return json_encode($contentAsArray, JSON_PRETTY_PRINT);
                    return "";
                },
                function ($contentAsString) {
                    // transform the string back to an array
                    if($contentAsString) return json_decode($contentAsString, true);
                    return null;
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BlockTranslation::class,
        ]);
    }
    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_text_translation';
    }
}
