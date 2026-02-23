<?php

namespace App\Controller\Admin;

use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TransactionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transaction::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['created_at' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('User.email', 'Utilisateur')->hideOnForm(),
            TextField::new('PayementMethod.name', 'Mode de paiement')->hideOnForm(),
            AssociationField::new('PayementMethod', 'Mode de paiement')
                ->onlyOnForms()
                ->setFormTypeOption('choice_label', 'name'),
            DateTimeField::new('created_at', 'Date'),
        ];
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters
    ): QueryBuilder {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $user = $this->getUser();
        if ($user instanceof User) {
            $queryBuilder
                ->andWhere('entity.User = :user')
                ->setParameter('user', $user);
        }

        return $queryBuilder;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Transaction) {
            $user = $this->getUser();
            if ($user instanceof User && null === $entityInstance->getUser()) {
                $entityInstance->setUser($user);
            }

            if (null === $entityInstance->getCreatedAt()) {
                $entityInstance->setCreatedAt(new \DateTimeImmutable());
            }
        }

        parent::persistEntity($entityManager, $entityInstance);
    }
}
