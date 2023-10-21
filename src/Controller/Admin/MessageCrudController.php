<?php

namespace App\Controller\Admin;

use App\Entity\Message;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Message::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ->setEntityLabelInSingular('Conference Comment')
            // ->setEntityLabelInPlural('Conference Comments')
            // ->setSearchFields(['author', 'text', 'email'])
            ->setDefaultSort(['createdAt' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('user'))
            ->add(EntityFilter::new('topic'))
        ;
    }

    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id');
        yield TextField::new('text');
        $createdAt = DateTimeField::new('createdAt')->setFormTypeOptions([
                        'years' => range(date('Y'), date('Y') + 5),
                        'widget' => 'single_text',
                    ]);
                    if (Crud::PAGE_EDIT === $pageName) {
                        yield $createdAt->setFormTypeOption('disabled', true);
                    } else {
                        yield $createdAt;
                    }

        yield AssociationField::new('user');
        yield AssociationField::new('topic');
    }
}
