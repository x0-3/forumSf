<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ->setEntityLabelInSingular('Conference Comment')
            // ->setEntityLabelInPlural('Conference Comments')
            // ->setSearchFields(['author', 'text', 'email'])
            ->setDefaultSort(['signUpDate' => 'DESC'])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield TextField::new('email');
        yield TextField::new('username');
        yield TextField::new('avatar');
        $signUpDate = DateTimeField::new('signUpDate')->setFormTypeOptions([
                        'years' => range(date('Y'), date('Y') + 5),
                        'widget' => 'single_text',
                    ]);
                    if (Crud::PAGE_EDIT === $pageName) {
                        yield $signUpDate->setFormTypeOption('disabled', true);
                    } else {
                        yield $signUpDate;
                    }

        yield BooleanField::new('isVerified');
    }
}
