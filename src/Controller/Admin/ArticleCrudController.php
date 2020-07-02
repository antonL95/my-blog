<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Article')
            ->setEntityLabelInPlural('Article')
            ->setSearchFields(['id', 'title', 'article_text', 'image']);
    }

    public function configureFields(string $pageName): iterable
    {
        $title = TextField::new('title');
        $articleText = TextareaField::new('article_text');
        $dateAdd = DateField::new('date_add');
        $imageFile = Field::new('imageFile');
        $id = IntegerField::new('id', 'ID');
        $active = Field::new('active');
        $image = TextField::new('image')->setTemplatePath('vich_uploader_image.html.twig');
        $updatedAt = DateTimeField::new('updatedAt');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $image, $title, $dateAdd, $active];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $title, $articleText, $dateAdd, $active, $image, $updatedAt];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$title, $articleText, $dateAdd, $imageFile];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$title, $articleText, $dateAdd, $imageFile];
        }
    }
}
