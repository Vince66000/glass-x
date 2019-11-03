<?php

namespace App\Form;

use App\Entity\Artwork;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description', TextareaType::class)
            ->add('longueur', IntegerType::class)
            ->add('largeur', IntegerType::class)
            ->add('annee')
            ->add('prix', MoneyType::class)
            ->add('type', ChoiceType::class, [
                'choices' => $this->getChoices()
            ])
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('disponibilite', CheckboxType::class, [
                'label' => 'Disponible',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }

    private function getChoices()
    {
        $choices = Artwork::TYPE;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }

  /*  private function getSize()
    {
        $size = 10;
        $size2 = [];
        for ($i = 1; $i <= 10; $i++ ) {

            for ($j=1; $j<=10; $j++) {

                $size2[$j] = ($size * $i);
            }
        }
        return $size2;
    }*/
}
