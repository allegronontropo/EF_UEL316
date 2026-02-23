<?php

namespace App\Controller\Admin;

use App\Entity\PayementMethod;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PayementMethodCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PayementMethod::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Mode de paiement'),
        ];
    }
}
