<?php

namespace App\Controller\Admin;

use App\Entity\PayementMethod;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminDashboard(routePath: '/admin/PayementMethods', routeName: 'admin-payements-methods')]
class PayementMethodCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PayementMethod::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('title'),
            // TextEditorField::new('description'),
        ];
    }
    
}
