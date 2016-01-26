<?php

namespace AppBundle\Form;

use Doctrine\ORM\Mapping\Builder\FieldBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\FileValidator;
use Symfony\Component\Validator\Constraints\File;

/**
 * Class CsvType
 * @package Feedify\ImportBundle\Form
 */
class ImportType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('path', FileType::class, ['label' => 'chose file', 'required' => false]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_import_csv';
    }
}
